<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test it creates an tag.
     * This method tests if the API endpoint can successfully create a new user.
     */
    public function testRegister()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    /**
     * Test it login an user.
     * This method tests if the API endpoint can successfully login an user.
     */
    public function testLogin()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'testpassword'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token'
            ]);
    }

    /**
     * Test it logout an user.
     * This method tests if the API endpoint can successfully logout an user.
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('testToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'User successfully logged out.']);
    }
}
