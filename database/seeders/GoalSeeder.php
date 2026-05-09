<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Goal::create([
            'title' => 'eat',
            'body' => 'eat healthy',
        ]);

        Goal::create([
            'title' => 'alcool',
            'body' => 'zero alcool',
        ]);

        Goal::create([
            'title' => 'outdoor_sport_session',
            'body' => 'outdoor sport session ( minimum 30 minutes )',
        ]);

        Goal::create([
            'title' => 'indoor_sport_session',
            'body' => 'indoor sport session ( minimum 30 minutes )',
        ]);

        Goal::create([
            'title' => 'water',
            'body' => 'drink 3 liters of water',
        ]);
    }
}
