<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Day>
 */
class DayFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => today(),
            'is_validated' => false,
        ];
    }

    public function validated(): static
    {
        return $this->state(fn () => ['is_validated' => true]);
    }

    public function on(string $date): static
    {
        return $this->state(fn () => ['date' => $date]);
    }
}
