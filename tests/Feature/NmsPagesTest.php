<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class NmsPagesTest extends TestCase
{
    public function test_poll_history_page_renders(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/nms/poll-history');

        $response->assertStatus(200);
        $response->assertSee('Poll History');
    }
}
