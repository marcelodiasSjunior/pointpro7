<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuncaoSaveRequest;
use App\Http\Requests\FuncaoUpdateRequest;
use App\Models\Funcao;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FuncoesController extends Controller
{
    public function index(Request $req)
    {
        $funcoes = Funcao::where('company_id', $req->user()->company->id)->where('status', 1)->get();

        return view('pages.company.funcoes', ['funcoes' => $funcoes]);
    }

    public function delete($id, Request $req)
    {
        Funcao::where(['id' => $id, 'company_id' => $req->user()->company->id])->update(['status' => 0]);
        Session::flash('success', "Função inativada com sucesso!");
        return Redirect::back();
    }

    public function create()
    {
        return view('pages.company.criar_funcao');
    }

    public function save(FuncaoSaveRequest $req)
    {
        Funcao::create([
            'title' => $req->title,
            'onboarding' => $req->onboarding,
            'company_id' => $req->user()->company->id,
            'status' => 1
        ]);

        Session::flash('success', "Função cadastrada com sucesso!");
        return redirect('/funcoes');
    }

    public function edit($id, Request $req)
    {
        $funcao = Funcao::where(['id' => $id, 'company_id' => $req->user()->company->id])->first();

        return view('pages.company.editar_funcao', ['funcao' => $funcao]);
    }

    public function update($id, FuncaoUpdateRequest $req)
    {
        $data = [
            'title' => $req->title,
        ];

        if ($req->onboarding) {
            $data['onboarding'] = $req->onboarding;
        }
        Funcao::where(['id' => $id, 'company_id' => $req->user()->company->id])
            ->update($data);

        Session::flash('success', "Função atualizada com sucesso!");
        return redirect('/funcoes');
    }
}
