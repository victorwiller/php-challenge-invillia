<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class PeopleApiTest extends TestCase
{
    protected $user;
    use RefreshDatabase;
    protected function authenticate(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $this->user = $user;
        $token = JWTAuth::fromUser($user);

        return $token;
    }

    /** @test */
    public function get_all_peoples()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/peoples');

        $response->assertStatus(200);
        $this->assertArrayHasKey('personname', $response->json());
        $this->assertArrayHasKey('phones', $response->json());
    }

    /** @test */
    public function get_people()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/peoples/1');

        $response->assertStatus(200);
        $this->assertArrayHasKey('personname', $response->json());
        $this->assertArrayHasKey('phones', $response->json());
    }

    /** @test */
    public function get_all_peoples_not_auth()
    {
        $response = $this->get('/api/peoples');

        $response->assertStatus(401);
    }
    
    /** @test */
    public function get_people_not_auth()
    {
        $response = $this->get('/api/peoples/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function get_people_not_exist()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/peoples/9999');

        $response->assertStatus(400);
    }
}
