<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Cette ligne magique réinitialise la base de données avant chaque test.

    /** @test */
    public function a_user_can_register_successfully()
    {
        // 1. Préparation (Arrange)
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // 2. Action (Act)
        $response = $this->postJson('/api/register', $userData);

        // 3. Assertions (Assert)
        $response->assertStatus(201)
            ->assertJson(['message' => 'User successfully registered.']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    /** @test */
    public function a_user_can_login_and_get_a_token()
    {
        // 1. Arrange: Crée un utilisateur dans la BDD de test.
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Act: Tente de se connecter.
        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        // 3. Assert
        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'token']); // Vérifie que la réponse contient bien un token.
    }
}
