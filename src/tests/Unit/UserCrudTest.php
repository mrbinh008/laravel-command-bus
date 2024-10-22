<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    public string $apiUrl = '/api/v1/users';

    public function test_create_user(): void
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'email' => 'john12@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'john12@example.com']);
    }

    public function test_create_user_without_email()
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'password' => 'password'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'error_code' => 422,
                'error_message' => [
                    'email' => ['The email field is required.']
                ]
            ]
        ]);
    }

    public function test_create_user_without_password()
    {
        $response = $this->postJson($this->apiUrl, [
            'name' => 'John Doe',
            'email' => 'ahihi@gmail.com'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                'error_code' => 422,
                'error_message' => [
                    'password' => ['The password field is required.']
                ]
            ]
        ]);
    }

    public function test_read_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson($this->apiUrl . "/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    public function test_update_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson($this->apiUrl . "/{$user->id}", [
            'email' => $user->email,
            'name' => 'John Doe',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'John Doe']);
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson($this->apiUrl . "/{$user->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
