<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Models\Goal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class GoalToggleTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $day = Day::factory()->create();
        $goal = Goal::factory()->create();
        $day->goals()->attach($goal);

        $this->patch(route('day-goals.toggle', [$day, $goal]))->assertRedirect(route('login'));
    }

    public function test_it_marks_a_goal_as_completed(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create(['user_id' => $user->id]);
        $goal = Goal::factory()->create();
        $day->goals()->attach($goal);

        $this->actingAs($user)
            ->patchJson(route('day-goals.toggle', [$day, $goal]))
            ->assertOk()
            ->assertJson(['completed' => true]);

        $this->assertDatabaseHas('day_goal', [
            'day_id' => $day->id,
            'goal_id' => $goal->id,
            'completed' => true,
        ]);
    }

    public function test_toggling_twice_clears_the_goal_again(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create(['user_id' => $user->id]);
        $goal = Goal::factory()->create();
        $day->goals()->attach($goal);

        $this->actingAs($user)->patchJson(route('day-goals.toggle', [$day, $goal]));

        $this->actingAs($user)
            ->patchJson(route('day-goals.toggle', [$day, $goal]))
            ->assertOk()
            ->assertJson(['completed' => false]);

        $this->assertDatabaseHas('day_goal', [
            'day_id' => $day->id,
            'goal_id' => $goal->id,
            'completed' => false,
        ]);
    }

    public function test_a_goal_that_is_not_tracked_for_that_day_is_not_found(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create(['user_id' => $user->id]);
        $goal = Goal::factory()->create();

        $this->actingAs($user)
            ->patchJson(route('day-goals.toggle', [$day, $goal]))
            ->assertNotFound();
    }

    public function test_a_user_cannot_toggle_a_goal_of_another_users_day(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create();
        $goal = Goal::factory()->create();
        $day->goals()->attach($goal);

        $this->actingAs($user)
            ->patchJson(route('day-goals.toggle', [$day, $goal]))
            ->assertForbidden();

        $this->assertDatabaseHas('day_goal', [
            'day_id' => $day->id,
            'goal_id' => $goal->id,
            'completed' => false,
        ]);
    }
}
