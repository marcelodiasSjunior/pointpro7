<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'password' => 'required',
            'device_name' => 'required',
            'manter_conectado' => 'required'
        ]);

        $manter_conectado = $req->manter_conectado === "true";

        $data = $req->only(['email', 'password']);

        if (Auth::attempt([...$data, 'role' => 3], $manter_conectado)) {
            $token = $token = $req->user()->createToken('api_token_for_web');
            return ['token' => $token->plainTextToken];
        } else {
            return response()->json(['error' => 'password_login_invalid'], 400);
        }
    }

    public function user(Request $req)
    {
        return $req->user();
    }
}
