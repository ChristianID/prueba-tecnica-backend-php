<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(Login $request)
    {
        $user= User::select('id','name','email','password')
            ->whereEmail($request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            abort(401, 'Bad credentials');
        }

        $user->tokens()->delete();
        $user['token'] = $user->createToken('userToken')->plainTextToken;
        $user->makeHidden('id');

        return response()->json([
            'user' => $user
        ]);
    }

}
