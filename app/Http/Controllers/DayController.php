<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Carbon\CarbonImmutable;
use Carbon\Exceptions\InvalidFormatException;
use DateTimeInterface;
use Illuminate\Support\Str;

class DayController extends Controller
{
    public function index()
    {
        $challenge = auth()->user()->challenge;

        return view('dashboard', [
            'challenge' => $challenge,
            'day' => $challenge->covers(today()) ? $this->openDay(today())->load('goals') : null,
        ]);
    }

    public function show(string $dayParam)
    {
        $challenge = auth()->user()->challenge;

        if (Str::isUuid($dayParam)) {
            $day = Day::findOrFail($dayParam);

            $this->authorize('view', $day);
        } else {
            $date = $this->parseDate($dayParam);

            abort_if($date->isFuture(), 404);
            abort_unless($challenge->covers($date), 404);

            $day = $this->openDay($date);
        }

        return view('days.show', [
            'challenge' => $challenge,
            'day' => $day->load('goals'),
        ]);
    }

    public function validate(Day $day)
    {
        $this->authorize('update', $day);

        $day->update(['is_validated' => true]);

        return response()->json(['is_validated' => true]);
    }

    public function unvalidate(Day $day)
    {
        $this->authorize('update', $day);

        $day->update(['is_validated' => false]);

        return response()->json(['is_validated' => false]);
    }

    public function calendar()
    {
        $challenge = auth()->user()->challenge;

        $daysByDate = auth()->user()->days
            ->mapWithKeys(fn (Day $day) => [$day->date->toDateString() => $day]);

        $elapsedDates = $challenge->hasStarted()
            ? collect($challenge->elapsedDates()->toArray())
            : collect();

        $isValidated = fn ($date) => (bool) $daysByDate->get($date->toDateString())?->is_validated;

        return view('days.calendar', [
            'challenge' => $challenge,
            'challengeDates' => $challenge->dates()->toArray(),
            'daysByDate' => $daysByDate,
            'validatedDaysCount' => $elapsedDates->filter($isValidated)->count(),
            'missedDaysCount' => $elapsedDates
                ->reject(fn ($date) => $date->isToday())
                ->reject($isValidated)
                ->count(),
        ]);
    }

    public function stats()
    {
        $challenge = auth()->user()->challenge;

        $countsByGoal = DayGoal::query()
            ->selectRaw('goal_id, count(*) as tracked_count, sum(completed) as completed_count')
            ->whereHas('day', fn ($query) => $query
                ->where('user_id', auth()->id())
                ->where('date', '>=', $challenge->start_date))
            ->groupBy('goal_id')
            ->get()
            ->keyBy('goal_id');

        $goalCompletionRates = Goal::shared()->get()->map(function (Goal $goal) use ($countsByGoal) {
            $counts = $countsByGoal->get($goal->id);
            $trackedCount = (int) ($counts?->tracked_count ?? 0);
            $completedCount = (int) ($counts?->completed_count ?? 0);

            return [
                'goal' => $goal,
                'tracked' => $trackedCount,
                'completed' => $completedCount,
                'percentage' => $this->percentage($completedCount, $trackedCount),
            ];
        });

        $trackedGoalsCount = $goalCompletionRates->sum('tracked');
        $completedGoalsCount = $goalCompletionRates->sum('completed');

        return view('days.stats', [
            'challenge' => $challenge,
            'trackedGoalsCount' => $trackedGoalsCount,
            'completedGoalsCount' => $completedGoalsCount,
            'completionPercentage' => $this->percentage($completedGoalsCount, $trackedGoalsCount),
            'goalCompletionRates' => $goalCompletionRates,
        ]);
    }

    private function percentage(int $completed, int $total): int
    {
        return $total > 0 ? (int) round($completed / $total * 100) : 0;
    }

    private function parseDate(string $date): CarbonImmutable
    {
        try {
            return CarbonImmutable::parse($date)->startOfDay();
        } catch (InvalidFormatException) {
            abort(404);
        }
    }

    private function openDay(DateTimeInterface $date): Day
    {
        $day = Day::firstOrCreate(['user_id' => auth()->id(), 'date' => $date]);

        if ($day->wasRecentlyCreated) {
            $day->goals()->attach(Goal::shared()->pluck('id'));
        }

        return $day;
    }
}
