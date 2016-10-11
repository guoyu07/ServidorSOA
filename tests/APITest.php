<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APITest extends TestCase
{

    public function test_PreTesting()
    {
        $user = App\User::where('email','nuevo@mail.com');
        if($user)
        {
            $user->delete();
        }
        $this->assertTrue(true);
    }


    public function test_CreateUser()
    {
        $this->json('POST', '/users',
            [
                'email' => 'nuevo@mail.com', 
                'first_name' => 'Soy Nuevo',
                'last_name' => 'Nuevecito',
                'password' => '123'
            ])
            ->seeJson([
                'status' => true
            ]);
    }


   public function test_Login()
    {
        $this->json('POST', '/login', 
            [
                'email' => 'nuevo@mail.com', 
                'password' => '123'
            ])
            ->seeJson([
                'status' => true,
            ]);
    }

 
    public function test_DeleteUser()
    {
        $user = App\User::where('email','nuevo@mail.com')->firstOrFail();
        $this->json('DELETE', '/users/'.$user->id, [])
            ->seeJson([
                    'status' => true
                ]);
    }


 }
