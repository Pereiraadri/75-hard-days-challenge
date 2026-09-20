<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-09-20'));
    }

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_a_user_without_a_challenge_is_sent_to_the_challenge_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('challenges.create'));
    }

    public function test_it_opens_todays_day_and_attaches_the_shared_goals(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $this->sharedGoals();

        $this->actingAs($user)->get(route('dashboard'))->assertOk();

        $this->assertTrue(
            $user->days()->whereDate('date', '2026-09-20')->where('is_validated', false)->exists()
        );
        $this->assertDatabaseCount('day_goal', 3);
    }

    public function test_coming_back_to_the_dashboard_does_not_duplicate_the_day_goals(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $this->sharedGoals();

        $this->actingAs($user)->get(route('dashboard'))->assertOk();
        $this->actingAs($user)->get(route('dashboard'))->assertOk();

        $this->assertDatabaseCount('days', 1);
        $this->assertDatabaseCount('day_goal', 3);
    }

    public function test_it_shows_the_current_day_number_of_the_challenge(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('11');
    }

    public function test_it_announces_the_countdown_when_the_challenge_has_not_started(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-23');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee(trans_choice('Starts in :count day|Starts in :count days', 3, ['count' => 3]));
    }

    public function test_a_validated_day_locks_its_goals(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $goals = $this->sharedGoals(1);

        $day = Day::factory()->validated()->create(['user_id' => $user->id, 'date' => '2026-09-20']);
        $day->goals()->attach($goals->first());

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('is-locked', escape: false);
    }
}
