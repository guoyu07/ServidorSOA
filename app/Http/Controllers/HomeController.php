<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class HomeController extends Controller
{


	public function downloadJava()
	{
		$file= public_path(). "/downloads/ClienteJAVA.jar";

		$headers = array(
			'Content-Type: application/jar',
			);

		return response()->download($file, 'clienteDesktop.jar', $headers);
	}



	public function downloadAndroid()
	{
		$file= public_path(). "/downloads/ArreglosCorto2.jar";

		$headers = array(
			'Content-Type: application/jar',
			);

		return response()->download($file, 'app.jar', $headers);
	}



	public function login(Request $request)
	{
		$credentials = ['email'=>$request['email'], 'password'=>$request['password']];
		$remember = $request['remember'];

		if(Auth::attempt($credentials, $remember))
		{
			$user = Auth::user();
			return response()->json([ 
				'status' => true,
				'message' => 'Login correcto, bienvenid@ '.Auth::user()->full_name 
			]);
		}

		return response()->json([ 
				'status' => false, 
				'message' => 'Error al iniciar sesión, credenciales incorrectas' 
			]);
	}

}
