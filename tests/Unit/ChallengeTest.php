<?php

namespace Tests\Unit;

use App\Models\Challenge;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ChallengeTest extends TestCase
{
    private const TODAY = '2026-09-20';

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse(self::TODAY));
    }

    private function startingOn(string $startDate): Challenge
    {
        return new Challenge(['start_date' => $startDate]);
    }

    public function test_it_reads_its_duration_from_the_configuration(): void
    {
        config(['challenge.duration_in_days' => 30]);

        $this->assertSame(30, $this->startingOn(self::TODAY)->durationInDays());
    }

    public function test_it_ends_on_the_last_day_of_the_challenge(): void
    {
        $this->assertSame('2026-12-03', $this->startingOn(self::TODAY)->endDate()->toDateString());
    }

    public function test_it_has_started_when_the_start_date_is_today_or_in_the_past(): void
    {
        $this->assertTrue($this->startingOn(self::TODAY)->hasStarted());
        $this->assertTrue($this->startingOn('2026-09-01')->hasStarted());
        $this->assertFalse($this->startingOn('2026-09-21')->hasStarted());
    }

    public function test_it_has_ended_once_the_last_day_is_behind_us(): void
    {
        $this->assertFalse($this->startingOn('2026-09-11')->hasEnded());
        $this->assertFalse($this->startingOn('2026-07-08')->hasEnded());
        $this->assertTrue($this->startingOn('2026-07-07')->hasEnded());
    }

    public function test_it_covers_the_dates_from_its_first_to_its_last_day(): void
    {
        $challenge = $this->startingOn(self::TODAY);

        $this->assertTrue($challenge->covers(self::TODAY));
        $this->assertTrue($challenge->covers('2026-12-03'));
        $this->assertFalse($challenge->covers('2026-09-19'));
        $this->assertFalse($challenge->covers('2026-12-04'));
    }

    public function test_it_counts_the_days_left_before_it_starts(): void
    {
        $this->assertSame(3, $this->startingOn('2026-09-23')->daysUntilStart());
    }

    public function test_the_first_day_of_the_challenge_is_day_one(): void
    {
        $challenge = $this->startingOn(self::TODAY);

        $this->assertSame(1, $challenge->dayNumberFor(self::TODAY));
        $this->assertSame(10, $challenge->dayNumberFor('2026-09-29'));
        $this->assertSame(75, $challenge->dayNumberFor('2026-12-03'));
    }

    public function test_the_current_day_number_is_negative_before_the_challenge_starts(): void
    {
        $this->assertSame(-2, $this->startingOn('2026-09-23')->currentDayNumber());
    }

    public function test_the_progress_percentage_never_leaves_the_zero_to_hundred_range(): void
    {
        $this->assertSame(13, $this->startingOn('2026-09-11')->progressPercentage());
        $this->assertSame(0, $this->startingOn('2026-10-20')->progressPercentage());
        $this->assertSame(100, $this->startingOn('2026-01-01')->progressPercentage());
    }

    public function test_it_counts_the_remaining_days(): void
    {
        $this->assertSame(74, $this->startingOn(self::TODAY)->remainingDays());
        $this->assertSame(75, $this->startingOn('2026-10-20')->remainingDays());
        $this->assertSame(0, $this->startingOn('2026-01-01')->remainingDays());
    }

    public function test_it_spans_exactly_the_configured_number_of_dates(): void
    {
        $dates = $this->startingOn(self::TODAY)->dates()->toArray();

        $this->assertCount(75, $dates);
        $this->assertSame(self::TODAY, $dates[0]->toDateString());
        $this->assertSame('2026-12-03', end($dates)->toDateString());
    }

    public function test_elapsed_dates_stop_at_today(): void
    {
        $dates = $this->startingOn('2026-09-11')->elapsedDates()->toArray();

        $this->assertCount(10, $dates);
        $this->assertSame(self::TODAY, end($dates)->toDateString());
    }

    public function test_elapsed_dates_stop_at_the_end_of_a_finished_challenge(): void
    {
        $dates = $this->startingOn('2026-01-01')->elapsedDates()->toArray();

        $this->assertCount(75, $dates);
        $this->assertSame('2026-03-16', end($dates)->toDateString());
    }
}
