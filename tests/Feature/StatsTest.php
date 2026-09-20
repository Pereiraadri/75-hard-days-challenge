<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-09-20'));
    }

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('days.stats'))->assertRedirect(route('login'));
    }

    public function test_a_user_without_a_challenge_is_sent_to_the_challenge_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('days.stats'))
            ->assertRedirect(route('challenges.create'));
    }

    public function test_it_sums_the_goals_completed_since_the_challenge_started(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $goals = $this->sharedGoals(3);

        $firstDay = Day::factory()->on('2026-09-11')->create(['user_id' => $user->id]);
        $secondDay = Day::factory()->on('2026-09-12')->create(['user_id' => $user->id]);

        $firstDay->goals()->attach($goals[0], ['completed' => true]);
        $firstDay->goals()->attach($goals[1], ['completed' => true]);
        $firstDay->goals()->attach($goals[2]);
        $secondDay->goals()->attach($goals[0], ['completed' => true]);
        $secondDay->goals()->attach($goals[1]);
        $secondDay->goals()->attach($goals[2]);

        $content = $this->actingAs($user)->get(route('days.stats'))->assertOk()->getContent();

        $this->assertStringContainsString('<span data-score-completed>3</span>', $content);
        $this->assertStringContainsString('/ 6', $content);
        $this->assertStringContainsString(__(':percentage% completed', ['percentage' => 50]), $content);
    }

    public function test_it_ignores_the_days_recorded_before_the_challenge_started(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $goals = $this->sharedGoals(1);

        $beforeTheChallenge = Day::factory()->on('2026-09-01')->create(['user_id' => $user->id]);
        $beforeTheChallenge->goals()->attach($goals[0], ['completed' => true]);

        $content = $this->actingAs($user)->get(route('days.stats'))->assertOk()->getContent();

        $this->assertStringContainsString('<span data-score-completed>0</span>', $content);
        $this->assertStringContainsString('/ 0', $content);
    }

    public function test_it_breaks_the_score_down_by_goal(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $goals = $this->sharedGoals(2);

        $day = Day::factory()->on('2026-09-11')->create(['user_id' => $user->id]);
        $day->goals()->attach($goals[0], ['completed' => true]);
        $day->goals()->attach($goals[1]);

        $this->actingAs($user)
            ->get(route('days.stats'))
            ->assertOk()
            ->assertSee(__(Str::headline($goals[0]->title)))
            ->assertSee(__(Str::headline($goals[1]->title)));
    }

    public function test_it_only_counts_the_days_of_the_signed_in_user(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $goals = $this->sharedGoals(1);

        $otherUserDay = Day::factory()->on('2026-09-11')->create();
        $otherUserDay->goals()->attach($goals[0], ['completed' => true]);

        $content = $this->actingAs($user)->get(route('days.stats'))->assertOk()->getContent();

        $this->assertStringContainsString('<span data-score-completed>0</span>', $content);
        $this->assertStringContainsString('/ 0', $content);
    }
}
