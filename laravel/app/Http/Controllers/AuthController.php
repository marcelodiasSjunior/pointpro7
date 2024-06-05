<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\DomainService;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function recuperar_senha()
    {
        return view('pages.auth.recuperar-senha');
    }
    public function enviar_codigo_recuperacao(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    public function atualizar_senha($token)
    {
        return view('pages.auth.atualizar-senha', ['token' => $token]);
    }
    public function salvar_nova_senha(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function loginView(Request $r)
    {
        if (!$r->user()) {
            return view('pages.auth.login');
        }
        if ($r->user()->role === 1) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.manager')));
        } else if ($r->user()->role === 2) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.painel')));
        } else if ($r->user()->role === 3) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.funcionario')));
        }
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $manter_conectado = $request->manter_conectado === "1";

        if ($r = Auth::attempt($credentials, $manter_conectado)) {
            return Redirect::to(DomainService::getFullHost('auth'));
        } else {
            return Redirect::back()->withErrors(['msg' => 'E-mail ou senha incorretos.']);
        }
    }
}
