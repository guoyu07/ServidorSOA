<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends TestCase
{

    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function test_CreateUser_Ok()
    {
        $response = $this->json('POST', '/users',
            [
                'email' => 'nuevo@mail.com', 
                'first_name' => 'Soy Nuevo',
                'last_name' => 'Nuevecito',
                'password' => '123'
            ]);

        $response->dump();
    }


   public function test_Login_Ok()
    {
        $this->json('POST', '/login', 
            [
                'email' => 'nuevo@mail.com', 
                'password' => '123'
            ])
            ->seeJson([
                'status' => true
            ]);
    }

 
    public function test_DeleteUser_Ok()
    {
        $user = App\User::where('email','nuevo@mail.com')->firstOrFail();
        $this->json('DELETE', '/users/'.$user->id, [])
            ->seeJson([
                    'status' => true
                ]);
    }


 }
