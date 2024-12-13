<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|string|email",
            "password" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $administrador = User::Create([
            "name" => $request->get('name'),
            "email" => $request->get('email'),
            "password" => bcrypt($request->get('password')),
        ]);

        $administrador->email_verified_at = null;
        $administrador->save();

        return response()->json("Usuario registrado",200);

    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email",
            "password" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $user = User::Where("email", $request->get('email'))->first();

        if(!$user){
            return response()->json("Usuario no encontrado",404);
        }

        if(!Hash::check($request->get('password'), $user->password)){
            return response()->json("Usuario no encontrado",403);
        }

        $token = $user->createToken('Token')->plainTextToken;
        return response()->json([
            "msg" => "usuario encontrado exitosamente",
            "token" => $token,
        ]);

    }
}
