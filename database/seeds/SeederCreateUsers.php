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
        	'email'=>'esvin@mail.com',
        	'first_name'=>'Esvin',
        	'last_name'=>'González',
        	'password'=>'123'
        ]);
        App\User::create([
            'email'=>'sarina@mail.com',
            'first_name'=>'Sarina',
            'last_name'=>'Bolaños',
            'password'=>'123'
        ]);
        App\User::create([
            'email'=>'correo@mail.com',
            'first_name'=>'Nuevo',
            'last_name'=>'Usuario',
            'password'=>'123'
        ]);
    }
}
