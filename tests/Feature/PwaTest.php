<?php

namespace Tests\Feature;

use Tests\TestCase;

class PwaTest extends TestCase
{
    public function test_manifest_json_is_reachable_and_valid(): void
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Rude-Hz',
            'short_name' => 'Rude-Hz',
            'start_url' => '/',
            'display' => 'standalone',
        ]);
    }

    public function test_service_worker_is_reachable(): void
    {
        $response = $this->get('/sw.js');

        $response->assertStatus(200);
        $this->assertStringContainsString('CACHE_NAME', $response->content());
    }

    public function test_home_page_includes_pwa_meta_and_sw_registration(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('manifest.json');
        $response->assertSee('serviceWorker');
    }
}
