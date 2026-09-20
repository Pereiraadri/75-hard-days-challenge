<?php

namespace App\Models;

use App\ChallengeStatus;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'start_date',
    'status'
])]
class Challenge extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'status' => ChallengeStatus::class,
            'start_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function durationInDays(): int
    {
        return config('challenge.duration_in_days');
    }

    public function endDate(): CarbonInterface
    {
        return $this->start_date->copy()->addDays($this->durationInDays() - 1);
    }

    public function hasStarted(): bool
    {
        return $this->start_date->startOfDay()->lessThanOrEqualTo(today());
    }

    public function hasEnded(): bool
    {
        return today()->greaterThan($this->endDate());
    }

    public function covers(DateTimeInterface|string $date): bool
    {
        return CarbonImmutable::parse($date)
            ->startOfDay()
            ->betweenIncluded($this->start_date, $this->endDate());
    }

    public function daysUntilStart(): int
    {
        return (int) today()->diffInDays($this->start_date, absolute: true);
    }

    public function dayNumberFor(DateTimeInterface|string $date): int
    {
        return (int) $this->start_date->diffInDays($date) + 1;
    }

    public function currentDayNumber(): int
    {
        return $this->dayNumberFor(today());
    }

    public function progressPercentage(): int
    {
        $percentage = round($this->currentDayNumber() / $this->durationInDays() * 100);

        return (int) max(0, min(100, $percentage));
    }

    public function dates(): CarbonPeriod
    {
        return CarbonPeriod::create($this->start_date, $this->endDate());
    }

    public function elapsedDates(): CarbonPeriod
    {
        return CarbonPeriod::create($this->start_date, min(today(), $this->endDate()));
    }

    public function remainingDays(): int
    {
        return max(0, $this->durationInDays() - max(0, $this->currentDayNumber()));
    }
}
