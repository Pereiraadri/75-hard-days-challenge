<?php

namespace Tests\Feature;

use App\ChallengeStatus;
use App\Models\Challenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengeStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_database_stores_every_status_the_domain_defines(): void
    {
        foreach (ChallengeStatus::cases() as $status) {
            $challenge = Challenge::factory()->create(['status' => $status]);

            $this->assertSame($status, $challenge->fresh()->status);
        }
    }
}
