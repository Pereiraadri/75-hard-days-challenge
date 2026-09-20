<?php

namespace Tests\Unit;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class DayTest extends TestCase
{
    private function dayWithGoals(bool ...$completions): Day
    {
        $goals = collect($completions)->map(function (bool $completed) {
            $goal = new Goal(['title' => 'water', 'body' => 'drink water']);
            $goal->setRelation('pivot', new DayGoal(['completed' => $completed]));

            return $goal;
        });

        $day = new Day;
        $day->setRelation('goals', new Collection($goals->all()));

        return $day;
    }

    public function test_it_counts_the_goals_completed_that_day(): void
    {
        $this->assertSame(2, $this->dayWithGoals(true, false, true)->completedGoalsCount());
    }

    public function test_it_counts_nothing_when_no_goal_is_completed(): void
    {
        $this->assertSame(0, $this->dayWithGoals(false, false)->completedGoalsCount());
    }

    public function test_it_counts_nothing_when_the_day_has_no_goal(): void
    {
        $this->assertSame(0, $this->dayWithGoals()->completedGoalsCount());
    }
}
