<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\DayGoal;
use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DayGoal>
 */
class DayGoalFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_id' => Day::factory(),
            'goal_id' => Goal::factory(),
            'completed' => false,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => ['completed' => true]);
    }
}
