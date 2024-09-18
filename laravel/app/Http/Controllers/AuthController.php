<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\DomainService;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;
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

    private function isEmpresaAtiva($companyId){
        return Company::where('id', $companyId)->value('ativa');
    }

    private function getEmpresaAtiva($userId)
    {
        // Tentar obter o ID da empresa na relação gestor (UserCompany)
        $companyIdGestor = UserCompany::where('user_id', $userId)->value('company_id');
        if ($companyIdGestor) {
            // Retorna se a empresa do gestor está ativa
            return $this->isEmpresaAtiva($companyIdGestor);
        }

        // Se não for gestor, tenta buscar como funcionário
        $companyIdFuncionario = Funcionario::where('user_id', $userId)->value('company_id');

        if ($companyIdFuncionario) {
            // Retorna se a empresa do funcionário está ativa
            return $this->isEmpresaAtiva($companyIdFuncionario);
        }

        // Se não encontrar empresa, retorna null (não está associada a nenhuma empresa)
        return 1;
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $manter_conectado = $request->manter_conectado === "1";

        $user_id = User::where('email', $request->email)->value('id');
        $empresa_ativa = $this->getEmpresaAtiva($user_id);
        if (!$empresa_ativa || $empresa_ativa == 2) {
            Auth::logout(); // Deslogar se a empresa estiver inativa
            return Redirect::back()->withErrors(['msg' => 'Empresa inativa, login negado']);
        }
        if ($r = Auth::attempt($credentials, $manter_conectado)) {
            return Redirect::to(DomainService::getFullHost('auth'));
        } else {
            return Redirect::back()->withErrors(['msg' => 'E-mail ou senha incorretos.']);
        }
    }
}
