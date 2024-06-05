<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserSaveRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Http\Services\CityService;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function list()
    {
        $data = [
            'users' => User::where('role', 2)->get()
        ];
        return view('pages.admin.usuarios', $data);
    }

    public function create()
    {
        $data = [
            'companies' => Company::get()
        ];
        return view('pages.admin.criar_usuario', $data);
    }

    public function save(AdminUserSaveRequest $req)
    {

        $data = $req->only([
            'name',
            'email',
            'password',
            'company_id'
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 2;

        $user = User::create($data);

        UserCompany::create([
            'company_id' => $req->company_id,
            'user_id' => $user->id
        ]);

        Session::flash('success', "Usuario cadastrado com sucesso");
        return Redirect::to("/usuarios");
    }

    public function edit(Request  $req, $id)
    {
        $data = [
            'companies' => Company::get(),
            'user' => User::where('role', 2)->where('id', $id)->first()
        ];

        return view('pages.admin.editar_usuario', $data);
    }

    public function update(AdminUserUpdateRequest $req, $id)
    {
        $emailExists = User::where('email', $req->email)->where('id', '!=', $id)->first();

        if ($emailExists) {
            return Redirect::back()->withErrors(["O email já está sendo utilizado por outra conta"]);
        }

        $data = $req->only([
            'email',
            'email'
        ]);

        if ($req->password) {
            $data['password'] = bcrypt($req->password);
        }

        User::where('role', 2)->where('id', $id)->update($data);

        UserCompany::where([
            'user_id' => $id
        ])->delete();

        UserCompany::create([
            'company_id' => $req->company_id,
            'user_id' => $id
        ]);

        Session::flash('success', "Usuario atualizado com sucesso");
        return Redirect::back();
    }
}
