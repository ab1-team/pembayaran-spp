<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_spp_payment_form_is_shown_empty_by_default(): void
    {
        $response = $this->withoutMiddleware()
            ->getJson('/app/spp/Pembayaran-spp/0');

        $response->assertOk()->assertJsonPath('success', true);

        $form = $response->json('view');

        $this->assertStringContainsString('id="FormPembayaranSPP"', $form);
        $this->assertStringContainsString('name="siswa_id" value=""', $form);
        $this->assertMatchesRegularExpression('/id="Tunai"[^>]*disabled/', $form);
        $this->assertMatchesRegularExpression('/id="TransferBank"[^>]*disabled/', $form);
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
