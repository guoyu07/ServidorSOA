<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Validator;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->responseOK("Usuarios obtenidos", User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = $this->checkStore($request);
      if ($validator->fails())
      {
        return $this->responseFAIL("Error en algunos campos, imposible crear el nuevo usuario.", $validator->errors()->all());
      }

      $user = User::create( $request->all() );
      if(! $user)
      {
        return $this->responseFAIL("Imposible crear el nuevo usuario.", [""]);
      }

      return $this->responseOK("Usuario creado correctamente.", $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::find($id);
      if(! $user)
      {
        return $this->responseFAIL("El usuario solicitado no existe.", [""]);
      }

      return $this->responseOK("Usuario encontrado.", $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validator = $this->checkUpdate($request);
      if ($validator->fails())
      {
        return $this->responseFAIL("Error en algunos campos, imposible actualizar el usuario.", $validator->errors()->all());
      }

      $user = User::find($id);
      if (! $user)
      {
        return $this->responseFAIL("El usuario que desea modificar no existe.", [""]);
      }

      $user->fill( $request->all() );
      if(! $user->save())
      {
        return $this->responseFAIL("Imposible actualizar el usuario solicitado.", [""]);
      }

      return $this->responseOK("Usuario actualizado correctamente.", $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      if(! $user)
      {
        return $this->responseFAIL("El usuario que desea eliminar no existe.", [""]);
      }

      if(! $user->delete())
      {
        return $this->responseFAIL("Imposible eliminar el usuario solicitado.", [""]);
      }

      return $this->responseOK("Usuario eliminado correctamente.", $user);
    }

    private function checkUpdate($request)
    {
      return Validator::make($request->all(), [
              'first_name' => 'required',
              'last_name' => 'required',
              'email' => 'required|email|unique:users'
          ]);
    }

    private function checkStore($request)
    {
      return Validator::make($request->all(), [
              'first_name' => 'required',
              'last_name' => 'required',
              'email' => 'required|email|unique:users',
              'password' => 'required'
          ]);
    }

    public function login(Request $request)
    {
        $credentials = ['email'=>$request['email'], 'password'=>$request['password']];
        $remember = $request['remember'];

        if(Auth::attempt($credentials, $remember))
        {
            $user = Auth::user();
            return $this->responseOK('Login correcto, bienvenid@ '.Auth::user()->full_name, $user);
        }

        return $this->responseFAIL('Error al iniciar sesión, credenciales incorrectas', [""]);
    }

    public function changePassword(Request $request, $id)
    {
        if(! $request['password'])
        {
            return $this->responseFAIL('La contraseña no puede estar en blanco.', ['El campo contraseña es requerido.']);
        }

        $user = User::find($id);

        if(! $user)
        {
            return $this->responseFAIL('Error al cambiar la contraseña, el usuario no está logueado.', [""]);
        }

        $user->password = $request['password'];

        if(! $user->save())
        {
            return $this->responseFAIL('Error al actualizar la contraseña.',"");
        }

        return $this->responseOK('La contraseña ha sido cambiada correctamente.', $user);
    }

    public function getToken()
    {
      return response()->json(['token'=>csrf_token()]);
    }
}
