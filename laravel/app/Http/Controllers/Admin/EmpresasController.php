<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCompanySaveRequest;
use App\Http\Requests\AdminCompanyUpdateRequest;
use App\Http\Services\CityService;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EmpresasController extends Controller
{
    public function list()
    {
        $data = [
            'companies' => Company::get()
        ];
        return view('pages.admin.empresas', $data);
    }

    public function create()
    {
        $data = [
            "states" => CityService::getStates()
        ];
        return view('pages.admin.empresas_cadastrar', $data);
    }

    public function edit(Request  $req, $id)
    {
        $data = [
            "company" => Company::find($id),
            "states" => CityService::getStates()
        ];

        return view('pages.admin.empresas_editar', $data);
    }

    public function update(AdminCompanyUpdateRequest $req, $id)
    {
        $cnpjExists = Company::where('cnpj', $req->cnpj)->where('id', '!=', $id)->first();
        if ($cnpjExists) {
            return Redirect::back()->withErrors(["O cnpj já está sendo utilizado por outra empresa"]);
        }

        $data = $req->only([
            'title',
            'logo',
            'seguimento',
            'razao_social',
            'cnpj',
            'telefone',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id',
            'plan'
        ]);

        Company::where('id', $id)->update($data);

        Session::flash('success', "Empresa atualizada com sucesso");
        return Redirect::back();
    }

    public function save(AdminCompanySaveRequest $req)
    {

        $data = $req->only([
            'title',
            'logo',
            'seguimento',
            'razao_social',
            'cnpj',
            'telefone',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id',
            'plan'
        ]);

        Company::create($data);
        Session::flash('success', "Empresa cadastrada com sucesso");
        return Redirect::to("/empresas");
    }
}
