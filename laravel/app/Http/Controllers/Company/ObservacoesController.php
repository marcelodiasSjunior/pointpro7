<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Observacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ObservacoesController extends Controller
{
    public function listar(Request $req)
    {
        $company_id = $req->user()->company->id;
        $funcao_id = $req->funcao_id;
        $funcionario_id = $req->funcionario_id;
        $atividades = AtividadeFuncionario::where('company_id', $company_id)->where('status', 1);
        $commonDates = CommomDataService::getCommonDates($req);

        if ($funcionario_id) {
            $atividades->where('funcionario_id', $funcionario_id);
        }

        if ($funcao_id) {
            $atividades->whereHas('atividade', function ($queryAtividade) use ($funcao_id) {
                $queryAtividade->where('funcao_id', $funcao_id);
            });
        }

        $data = [
            'funcoes' => Funcao::where('company_id', $company_id)->where('status', 1)->get(),
            'funcionarios' => Funcionario::where('company_id', $company_id)->get(),
            'atividades' => $atividades->with('observacoes')->get(),
            'funcao_id' => $funcao_id,
            'funcionario_id' => $funcionario_id,
            ...$commonDates,
            'historico_action' => '/observacoes'
        ];

        return view('pages.company.observacoes', $data);
    }

    public function edit(Request $req, $atividade_funcionario_id, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        $atividade_id = AtividadeFuncionario::where('id', $atividade_funcionario_id)->where('funcionario_id', $funcionario_id)->where('status', 1)->value('atividade_id');
        $atividade_description = Atividade::where('company_id', $company_id)->where('id', $atividade_id)->value('description');  

        $observacoes = Observacao::where('atividade_funcionario_id', $atividade_funcionario_id)
        ->where('funcionario_id', $funcionario_id)
        ->where('company_id', $company_id);


        $data = [
            'atividade_funcionario_id' => $atividade_funcionario_id,
            'atividade_description' => $atividade_description,
            'funcionario_id' => $funcionario_id,
            'observacoes' => $observacoes->get()
        ];
        return view('pages.company.editar_observacoes', $data);
    }

    public function send_message(Request $req, $atividade_funcionario_id, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        Observacao::create([
            'company_id' => $company_id,
            'funcionario_id' => $funcionario_id,
            'atividade_funcionario_id' => $atividade_funcionario_id,
            'message' => $req->message,
            'sender_id' => $req->user()->id,
            'sender_type' => 2 // 2 - Admin / 1 - Funcionario

        ]);
        Session::flash('success', "A observação da atividade foi cadastrada com sucesso!");
        return Redirect::back();
    }
}
