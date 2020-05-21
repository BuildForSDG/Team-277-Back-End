<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function __construct(){
      $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function register(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|string',
        'surname' => 'required|string',             
        'email' =>  'required|unique:users',
        'phone_number' => 'required|unique:users|max:12',
        'gender'  => 'required',
        'role_id' => 'required',        
        'password' => 'min:6|required_with:pass_confirm|same:pass_confirm',
        'pass_confirm' => 'min:6'
      ]);

      $user = User::create([
        'name' => $request->name,
        'surname' => $request->surname,              
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'gender'  => $request->gender,
        'role_id' => $request->role_id,         
        'password' => bcrypt($request->password)
      ]);
      
      if($user->errors){
        return response()->json($user, 201);
      }

      $token = auth()->login($user);

      return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
      $credentials = $request->only(['email', 'password']);

      if (!$token = auth()->attempt($credentials)) {
        return response()->json(['errors' => 'Unauthorized'], 401);
      }

      return $this->respondWithToken($token);
    }

    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    
    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user'=> auth()->user()
      ]);
    }

}
