<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Orders;
use App\Models\Peoples;
use App\Models\Shipto;
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
    
    protected function createPeoples() {
        Peoples::create([
            'name' => 'test',
        ], [
            'name' => 'teste2'
        ]);
    }

    protected function createOrders() {
        $this->createPeoples();
        Orders::create([
            'people_id' => '1',
        ], [
            'people_id' => '2'
        ]);

        Shipto::create([
            'order_id' => '1',
            'name'     => 'test',
            'address'  => 'test',
            'city'     => 'test',
            'country'  => 'test',
        ], [
            'order_id' => '2',
            'name'     => 'test2',
            'address'  => 'test2',
            'city'     => 'test2',
            'country'  => 'test2',
        ]);
    }

    /** @test */
    public function get_all_orders()
    {
        $this->createOrders();
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/orders');                
        $response->assertStatus(200);
    }

    /** @test */
    public function get_all_orders_not_auth()
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(401);
    }

    /** @test */
    public function get_order_not_auth()
    {
        $this->createOrders();
        $response = $this->get('/api/orders/1');
        $response->assertStatus(401);
    }

    /** @test */
    public function get_order_not_exist()
    {
        $this->createOrders();
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->get('/api/orders/9999');
        $response->assertStatus(404);
    }
}
