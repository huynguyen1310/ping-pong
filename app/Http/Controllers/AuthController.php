<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 422);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('MyApp')->accessToken;

    return response()->json(['token' => $token], 201);
  }

  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $token = $user->createToken('token')->accessToken;
      return response()->json(['profile' => $user, 'token' => $token], 200);
    } else {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
  }

  public function logout(Request $request)
  {
    $request->user()->token()->revoke();
    return response()->json(['message' => 'Successfully logged out'], 200);
  }

  public function listUsers()
  {
    $users =  User::where('id', '<>', Auth::user()->id)->get();
    return response()->json(['data' => $users], 200);
  }
}
