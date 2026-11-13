<?php

namespace Tests\Feature;

use Tests\TestCase;

class LanguageSwitchTest extends TestCase
{
    public function test_can_switch_language_to_english_and_persist(): void
    {
        $response = $this->get('/lang/en');

        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
        $this->assertNotNull($response->getCookie('locale'));

        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Tracks');

        $responseSupport = $this->get('/support');
        $responseSupport->assertStatus(200);
        $responseSupport->assertSee('Support Rude-Hz');

        $responseLogin = $this->get('/login');
        $responseLogin->assertStatus(200);
        $responseLogin->assertSee('Log in');
    }

    public function test_can_switch_language_to_spanish(): void
    {
        $response = $this->get('/lang/es');

        $response->assertRedirect();
        $this->assertEquals('es', session('locale'));

        $responseSupport = $this->get('/support');
        $responseSupport->assertStatus(200);
        $responseSupport->assertSee('Apoyar Rude-Hz');
    }

    public function test_invalid_locale_is_ignored(): void
    {
        $response = $this->get('/lang/xx');

        $response->assertRedirect();
        $this->assertNotEquals('xx', session('locale'));
    }
}
