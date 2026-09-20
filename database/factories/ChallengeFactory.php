<?php

namespace Database\Factories;

use App\ChallengeStatus;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_date' => today(),
            'status' => ChallengeStatus::Created,
        ];
    }

    public function startingOn(string $startDate): static
    {
        return $this->state(fn () => ['start_date' => $startDate]);
    }
}
