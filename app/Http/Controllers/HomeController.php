<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class HomeController extends Controller
{


	public function downloadJava()
	{
		$file= public_path(). "/downloads/ClienteJAVA.zip";

		$headers = array(
			'Content-Type: application/zip',
			);

		return response()->download($file, 'clienteDesktop.zip', $headers);
	}



	public function downloadAndroid()
	{
		$file= public_path(). "/downloads/ClienteANDROID.apk";

		$headers = array(
			'Content-Type: application/apk',
			);

		return response()->download($file, 'clienteMovil.apk', $headers);
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
				'message' => 'Usuario logueado correctamente.',
				'data' => $user
			]);
		}

		return response()->json([ 
				'status' => false,
				'message' => 'Error en las credenciales de inicio de sesión.'
			]);
	}

}
