<?php

namespace Tests\Feature;

use Tests\TestCase;

class SupportPageTest extends TestCase
{
    public function test_support_page_can_be_rendered_successfully(): void
    {
        app()->setLocale('it');
        $response = $this->get('/support');

        $response->assertStatus(200);
        $response->assertSee('Supporta Rude-Hz');
        $response->assertSee('Obiettivi di Sostenibilità');
        $response->assertSee('Infrastruttura');
        $response->assertSee('Contest');
        $response->assertSee('Premi');
        $response->assertSee('Studio');
        $response->assertSee('Strumenti');
        $response->assertSee('Come funziona');
        $response->assertSee('Supporter');
        $response->assertSee('I primi supporter saranno riconosciuti nella community.');
        $response->assertDontSee('donazione deducibile');
    }
}
