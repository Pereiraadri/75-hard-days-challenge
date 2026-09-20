<?php

namespace Tests\Concerns;

use App\Models\Challenge;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait InteractsWithChallenges
{
    protected function userWithChallengeStartingOn(string $startDate): User
    {
        $user = User::factory()->create();

        Challenge::factory()->startingOn($startDate)->create(['user_id' => $user->id]);

        return $user;
    }

    /**
     * @return Collection<int, Goal>
     */
    protected function sharedGoals(int $count = 3): Collection
    {
        return Goal::factory()
            ->count($count)
            ->sequence(fn ($sequence) => ['position' => $sequence->index])
            ->create();
    }
}
