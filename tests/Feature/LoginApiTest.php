<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginApiTest extends TestCase
{
    protected $user;
    use RefreshDatabase;

    /** @test */
    public function testLogin()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('secret1234'),
        ]);

        $response = $this->post('/api/login', [
            'email'    => 'test@test.com',
            'password' => 'secret1234'
        ]);
        
        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }
}
