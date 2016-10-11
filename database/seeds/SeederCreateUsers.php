<?php

use Illuminate\Database\Seeder;

class SeederCreateUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'email'=>'correo@mail.com',
        	'first_name'=>'Nuevo',
        	'last_name'=>'Usuario',
        	'password'=>'123'
        ]);
    }
}
