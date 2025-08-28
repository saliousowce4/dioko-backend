<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_payment()
    {
        $response = $this->postJson('/api/payments', []); // Pas d'authentification

        $response->assertStatus(401); // 401 Unauthorized
    }

    /** @test */
    public function an_authenticated_user_can_create_a_payment()
    {
        Storage::fake('public'); // Simule le système de stockage de fichiers.

        // Arrange: Crée et authentifie un utilisateur.
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $paymentData = [
            'description' => 'Test Payment',
            'amount' => 150.75,
            'category' => 'Utilities',
            'attachment' => UploadedFile::fake()->image('document.jpg'),
        ];

        // Act
        $response = $this->postJson('/api/payments', $paymentData);

        // Assert
        $response->assertStatus(201)
            ->assertJsonFragment(['description' => 'Test Payment']);

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => 150.75,
        ]);

        // Vérifie que le fichier a bien été "uploadé"
        Storage::disk('public')->assertExists('attachments/' . $paymentData['attachment']->hashName());
    }
}
