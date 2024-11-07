<?php

namespace Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test
    public string $apiUrl = '/api/v1/users'; // API URL

    public function test_create_user(): void
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'email' => 'john12@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200); // Check if the response status is 200
        $this->assertDatabaseHas('users', ['email' => 'john12@example.com']); // Check if the user is created in the database
    }

    public function test_create_user_without_email()
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'password' => 'password'
        ]);

        $response->assertStatus(422); // Check if the response status is 422
        $response->assertJson([
            'errors' => [
                'error_code' => 422,
                'error_message' => [
                    'email' => ['The email field is required.']
                ]
            ]
        ]); // Check if the response contains the expected error message
    }

    public function test_create_user_without_password()
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'email' => 'ahihi@gmail.com'
        ]);

        $response->assertStatus(422); // Check if the response status is 422
        $response->assertJson([
            'errors' => [
                'error_code' => 422,
                'error_message' => [
                    'password' => ['The password field is required.']
                ]
            ]
        ]); // Check if the response contains the expected error message
    }

    public function test_read_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson($this->apiUrl . "/{$user->id}");

        $response->assertStatus(200) // Check if the response status is 200
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]); // Check if the response contains the expected user data
    }

    public function test_update_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson($this->apiUrl . "/{$user->id}", [
            'email' => $user->email,
            'name' => 'John Doe',
        ]);

        $response->assertStatus(200); // Check if the response status is 200
        $this->assertDatabaseHas('users', ['name' => 'John Doe']); // Check if the user is updated in the database
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson($this->apiUrl . "/{$user->id}");

        $response->assertStatus(200); // Check if the response status is 200
        $this->assertSoftDeleted('users', ['id' => $user->id]); // Check if the user is soft deleted in the database
    }
}
