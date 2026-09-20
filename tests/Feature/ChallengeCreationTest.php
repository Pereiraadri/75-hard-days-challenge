<?php

namespace Tests\Feature;

use App\ChallengeStatus;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class ChallengeCreationTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('challenges.create'))->assertRedirect(route('login'));
        $this->post(route('challenges.store'))->assertRedirect(route('login'));
    }

    public function test_the_form_lists_the_shared_goals(): void
    {
        $goals = $this->sharedGoals(2);

        $this->actingAs(User::factory()->create())
            ->get(route('challenges.create'))
            ->assertOk()
            ->assertSee(__($goals[0]->body))
            ->assertSee(__($goals[1]->body));
    }

    public function test_the_form_ignores_the_goals_of_other_users(): void
    {
        $otherUser = User::factory()->create();
        $privateGoal = Goal::factory()->ownedBy($otherUser)->create();

        $this->actingAs(User::factory()->create())
            ->get(route('challenges.create'))
            ->assertOk()
            ->assertDontSee(__($privateGoal->body));
    }

    public function test_a_user_starts_a_challenge(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('challenges.store'), ['start_date' => '2026-09-20'])
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(
            $user->challenge()
                ->whereDate('start_date', '2026-09-20')
                ->where('status', ChallengeStatus::Created->value)
                ->exists()
        );
    }

    public function test_the_start_date_is_required(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('challenges.store'), [])
            ->assertSessionHasErrors('start_date');

        $this->assertDatabaseCount('challenges', 0);
    }

    public function test_the_start_date_must_be_a_date(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('challenges.store'), ['start_date' => Str::random(8)])
            ->assertSessionHasErrors('start_date');

        $this->assertDatabaseCount('challenges', 0);
    }

    public function test_a_user_who_already_has_a_challenge_skips_the_form(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');

        $this->actingAs($user)->get(route('dashboard'))->assertOk();
    }
}
