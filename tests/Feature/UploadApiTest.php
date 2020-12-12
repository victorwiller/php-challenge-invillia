<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class UploadApiTest extends TestCase
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
    public function send_upload() {
        $token = $this->authenticate();

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer '. $token,
                'Content-Type:' => 'multipart/form-data'
            ])
            ->post('/api/upload', [
                'file'=> [
                    'file[0]' => [file_get_contents('public/people.xml')],
                    'file[1]' => [file_get_contents('public/shiporders.xml')]
                ]
            ]);

        $response->assertStatus(200);
    }
    
    /** @test */
    public function send_upload_not_auth()
    {
        $response = $this->post('/api/upload');

        $response->assertStatus(401);
    }

    /** @test */
    public function send_upload_is_empty()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token])->post('/api/upload');

        $response->assertStatus(406);
    }
}
