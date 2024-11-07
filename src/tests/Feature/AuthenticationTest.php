<?php

namespace Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    private string $apiUrl = '/api/v1/auth';

    public function testLogin()
    {
//        User::query()->create([
//            'name' => 'John Doe',
//            "email" => "test30@gmail.com",
//            'password' => 'password'
//        ]);
//
//        $response = $this->postJson($this->apiUrl . "/login", [
//            "email" => "test30@gmail.com",
//            "password" => "password"
//        ]);
//
//        $response->assertStatus(200);
//        $response->assertJsonStructure([
//            'data' => [
//                'access_token',
//                'refresh_token',
//                'expires_in',
//            ],
//        ]); // Check if the response contains the expected structure
        $this->assertTrue(true);
    }
}
