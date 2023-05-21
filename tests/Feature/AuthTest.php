<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $userData = [
            "fullname"=>"bono test",
            "email"=>"bono@gmail.com",
            "password"=>"bono1234",
            "password_confirmation"=>"bono1234",
        ];
        $this->json('POST','api/register',$userData,['Accept'=>'application/json'])
        ->assertStatus(200)
        ->assertJsonStructure(
            [
                'success',
                'data',
                'message'
            ]
            );
    }
    // 
    public function testLogin(){
        $user = User::factory(1)->create(
            [
                'email'=>"rolo@gmail.com",
                'password'=>'password'
            ]
        );
        $loginData = [ 'email'=>"rolo@gmail.com",
        'password'=>'password'];
        $this->json('POST','api/login',$loginData,['Accept'=>'application/json'])->assertStatus(200)->assertJsonStructure([
            'success',
                'data',
                'message'
        ]);
        $this->assertAuthenticated();

    }
}
