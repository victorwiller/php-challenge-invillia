<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderApiTest extends TestCase
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
    public function get_all_orders_not_auth()
    {
        $response = $this->get('/api/orders');

        $response->assertStatus(401);
    }

    /** @test */
    public function get_all_orders_auth()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/orders');

        $response->assertStatus(200);
    }
    
    /** @test */
    public function get_some_order_not_auth()
    {
        $response = $this->get('/api/orders/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function get_some_order_not_exist()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/orders/9999');

        $response->assertStatus(400);
    }
}
