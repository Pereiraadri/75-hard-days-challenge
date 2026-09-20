<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class DayPageTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-09-20'));
    }

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('days.show', ['date' => '2026-09-15']))->assertRedirect(route('login'));
    }

    public function test_a_user_without_a_challenge_is_sent_to_the_challenge_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('days.show', ['date' => '2026-09-15']))
            ->assertRedirect(route('challenges.create'));
    }

    public function test_opening_a_date_creates_the_day_with_its_goals(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $this->sharedGoals();

        $this->actingAs($user)
            ->get(route('days.show', ['date' => '2026-09-15']))
            ->assertOk();

        $this->assertTrue($user->days()->whereDate('date', '2026-09-15')->exists());
        $this->assertDatabaseCount('day_goal', 3);
    }

    public function test_reloading_a_date_that_already_exists_does_not_fail(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $this->sharedGoals();

        $this->actingAs($user)->get(route('days.show', ['date' => '2026-09-15']))->assertOk();
        $this->actingAs($user)->get(route('days.show', ['date' => '2026-09-15']))->assertOk();

        $this->assertDatabaseCount('days', 1);
        $this->assertDatabaseCount('day_goal', 3);
    }

    public function test_a_parameter_that_is_neither_a_date_nor_an_identifier_is_not_found(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');

        $this->actingAs($user)
            ->get(route('days.show', ['date' => 'not-a-date']))
            ->assertNotFound();

        $this->assertDatabaseCount('days', 0);
    }

    public function test_it_shows_the_day_number_within_the_challenge(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->on('2026-09-15')->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('days.show', $day))
            ->assertOk()
            ->assertSee(__('Day'))
            ->assertSee('6');
    }

    public function test_a_user_cannot_open_the_day_of_another_user(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->on('2026-09-15')->create();

        $this->actingAs($user)
            ->get(route('days.show', $day))
            ->assertForbidden();
    }

    public function test_a_validated_day_offers_to_edit_it_again(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->validated()->on('2026-09-15')->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('days.show', $day))
            ->assertOk()
            ->assertSee(__('Day validated'))
            ->assertSee(__('Edit'));
    }
}
