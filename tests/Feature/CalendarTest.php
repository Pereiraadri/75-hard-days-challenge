<?php

namespace Tests\Feature;

use App\Models\Day;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-09-20'));
    }

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $this->get(route('days.calendar'))->assertRedirect(route('login'));
    }

    public function test_a_user_without_a_challenge_is_sent_to_the_challenge_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('days.calendar'))
            ->assertRedirect(route('challenges.create'));
    }

    public function test_it_draws_one_cell_per_day_of_the_challenge(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');

        $response = $this->actingAs($user)->get(route('days.calendar'))->assertOk();

        $this->assertSame(
            config('challenge.duration_in_days'),
            substr_count($response->getContent(), 'day-cell day-cell--')
        );
    }

    public function test_it_counts_validated_missed_and_remaining_days(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        Day::factory()->validated()->on('2026-09-11')->create(['user_id' => $user->id]);
        Day::factory()->on('2026-09-12')->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('days.calendar'))->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('>1</p>', $content);
        $this->assertStringContainsString('>9</p>', $content);
        $this->assertStringContainsString('>64</p>', $content);
    }

    public function test_a_challenge_that_has_not_started_shows_no_missed_day(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-23');

        $response = $this->actingAs($user)->get(route('days.calendar'))->assertOk();
        $content = $response->getContent();

        $this->assertSame(
            config('challenge.duration_in_days'),
            substr_count($content, 'day-cell day-cell--upcoming')
        );
        $this->assertStringContainsString('>0</p>', $content);
        $this->assertStringContainsString('>75</p>', $content);
    }

    public function test_an_existing_day_links_to_its_own_page(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->validated()->on('2026-09-11')->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('days.calendar'))
            ->assertOk()
            ->assertSee(route('days.show', $day));
    }

    public function test_a_day_without_a_record_links_to_its_date(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');

        $this->actingAs($user)
            ->get(route('days.calendar'))
            ->assertOk()
            ->assertSee(route('days.show', ['date' => '2026-09-11']));
    }
}
