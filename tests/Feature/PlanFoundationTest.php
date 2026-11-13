<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_user_has_free_plan_by_default(): void
    {
        $user = User::factory()->create();

        $this->assertEquals('free', $user->plan);
        $this->assertFalse($user->supporter_badge);
        $this->assertNull($user->plan_expires_at);
    }

    public function test_free_user_cannot_access_pro_route(): void
    {
        $user = User::factory()->create(['plan' => 'free']);

        $response = $this->actingAs($user)->get('/test-premium');

        $response->assertStatus(403);
    }

    public function test_pro_user_can_access_pro_route(): void
    {
        $user = User::factory()->create(['plan' => 'pro']);

        $response = $this->actingAs($user)->get('/test-premium');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
