<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Goal>
 */
class GoalFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(2, true),
            'body' => fake()->sentence(),
            'icon' => '🎯',
            'position' => 0,
        ];
    }

    public function ownedBy(User $user): static
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }
}
