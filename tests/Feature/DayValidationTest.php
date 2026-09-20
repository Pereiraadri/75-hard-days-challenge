<?php

namespace Tests\Feature;

use App\Models\Day;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithChallenges;
use Tests\TestCase;

class DayValidationTest extends TestCase
{
    use InteractsWithChallenges, RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_screen(): void
    {
        $day = Day::factory()->create();

        $this->patch(route('days.validate', $day))->assertRedirect(route('login'));
    }

    public function test_a_user_validates_their_own_day(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->patchJson(route('days.validate', $day))
            ->assertOk()
            ->assertJson(['is_validated' => true]);

        $this->assertTrue($day->fresh()->is_validated);
    }

    public function test_a_user_reopens_their_own_validated_day(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->validated()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->patchJson(route('days.unvalidate', $day))
            ->assertOk()
            ->assertJson(['is_validated' => false]);

        $this->assertFalse($day->fresh()->is_validated);
    }

    public function test_a_user_cannot_validate_the_day_of_another_user(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->create();

        $this->actingAs($user)
            ->patchJson(route('days.validate', $day))
            ->assertForbidden();

        $this->assertFalse($day->fresh()->is_validated);
    }

    public function test_a_user_cannot_reopen_the_day_of_another_user(): void
    {
        $user = $this->userWithChallengeStartingOn('2026-09-10');
        $day = Day::factory()->validated()->create();

        $this->actingAs($user)
            ->patchJson(route('days.unvalidate', $day))
            ->assertForbidden();

        $this->assertTrue($day->fresh()->is_validated);
    }
}
