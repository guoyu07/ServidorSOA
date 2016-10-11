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
    * Display a listing of the user.
    */
    public function index()
    {
        return response()->json(User::all()->toArray());
    }

    /**
    * Store a newly created user in storage.
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

        return response()->json(["status" => true]);
    }

    /**
    * Display the specified user.
    */
    public function show($id)
    {
        $user = User::find($id);
        if(! $user)
        {
            return $this->responseFAIL("El usuario solicitado no existe.", [""]);
        }

        return response()->json($user);
    }

    /**
    * Update the specified user in storage.
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
    * Remove the specified user from storage.
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

        return response()->json(['status'=>true]);
    }

    /**
    * Change the password of specified user.
    */
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

    private function checkUpdate($request)
    {
        return Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
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

    public function getToken()
    {
        return response()->json(['token'=>csrf_token()]);
    }

}