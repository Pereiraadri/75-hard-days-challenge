<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Str;
use function Laravel\Prompts\error;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $day = Day::firstOrCreate(
            ['user_id' => auth()->id(), 'date' => today()],
        );

        if ($day->wasRecentlyCreated) {
            $goals = Goal::whereNull('user_id')->get();
            foreach ($goals as $goal) {
                DayGoal::create([
                    'day_id' => $day->id,
                    'goal_id' => $goal->id,
                    'completed' => false,
                ]);
            }
        }

        $dayGoals = $day->goals()->withPivot('completed')->get();
        return view('dashboard', compact('day', 'dayGoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($dayParam)
    {
        if (Str::isUuid($dayParam)) {
            $day = Day::findOrFail($dayParam);
            $dayGoals = $day->goals()->withPivot('completed')->get();
        } else {
            $day = Day::firstOrCreate([
                'user_id' => auth()->id(),
                'date' => $dayParam,
            ]);

            $goals = Goal::where('user_id',  null)->get();

            foreach ($goals as $goal) {
                DayGoal::create(['day_id' => $day->id, 'goal_id' => $goal->id]);
            }

            $dayGoals = $day->goals()->withPivot('completed')->get();

        }

        return view('days.show', compact('day', 'dayGoals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Day $day)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Day $day)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Day $day)
    {
        //
    }

    public function validate(Day $day)
    {
        if ($day->user_id === auth()->id()) {
            $day->update([
                'is_validated' => true,
            ]);

            return response()->json(['message' => 'Bien joué, rendez-vous demain !']);
        }

        return response('nul');
    }

    public function unvalidate(Day $day)
    {
        if ($day->user_id === auth()->id()) {
            $day->update(['is_validated' => false]);
            return response()->json(['success' => true]);
        }
    }

    public function calendar()
    {
        $user = auth()->user();
        $startDate = $user->challenge->start_date;
        $userDays = $user->days->mapWithKeys(fn($day) => [
            \Carbon\Carbon::parse($day->date)->format('Y-m-d') => [
                'id' => $day->id,
                'is_validated' => $day->is_validated,
            ]
        ])->toArray();
        $dates = CarbonPeriod::create($startDate, now())->toArray();

        return view('days.calendar', compact('dates', 'userDays', 'startDate'));
    }

    public function stats()
    {
        $totalPossible = DayGoal::whereHas('day', fn($q) =>
        $q->where('user_id', auth()->id())
        )->count();

        $totalCompleted = DayGoal::whereHas('day', fn($q) =>
        $q->where('user_id', auth()->id())
        )->where('completed', true)->count();

        $byGoal = Goal::whereNull('user_id')->get()->map(function($goal) {
            $dayGoals = DayGoal::where('goal_id', $goal->id)
                ->whereHas('day', fn($q) => $q->where('user_id', auth()->id()))
                ->get();

            $goal->total = $dayGoals->count();
            $goal->completed = $dayGoals->where('completed', true)->count();
            return $goal;
        });

        return view('days.stats', compact('totalPossible', 'totalCompleted', 'byGoal'));
    }
}
