<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        $sharedGoals = [
            ['title' => 'eat', 'body' => 'eat healthy', 'icon' => '🥗'],
            ['title' => 'alcool', 'body' => 'zero alcool', 'icon' => '🚫'],
            ['title' => 'outdoor_sport_session', 'body' => 'outdoor sport session ( minimum 30 minutes )', 'icon' => '🏃'],
            ['title' => 'indoor_sport_session', 'body' => 'indoor sport session ( minimum 30 minutes )', 'icon' => '🏠'],
            ['title' => 'water', 'body' => 'drink 3 liters of water', 'icon' => '💧'],
        ];

        foreach ($sharedGoals as $position => $goal) {
            Goal::updateOrCreate(
                ['title' => $goal['title'], 'user_id' => null],
                [...$goal, 'position' => $position],
            );
        }
    }
}
