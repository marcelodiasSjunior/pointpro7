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
        $commonDates = CommomDataService::getCommonDates($req);

        $atividades = AtividadeFuncionario::where('company_id', $company_id)
            ->where('status', 1)
            ->with([
                'atividade.observacoes' => function ($query) {
                    $query->orderBy('created_at', 'DESC');
                }
            ])
            ->with('funcionario')
            ->with('funcionario_atividade');



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
            'atividades' => $atividades->get(),
            'funcao_id' => $funcao_id,
            'funcionario_id' => $funcionario_id,
            ...$commonDates,
            'historico_action' => '/observacoes'
        ];

        return view('pages.company.observacoes', $data);
    }

    public function edit(Request $req, $atividade_id, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        $atividade = Atividade::where('id', $atividade_id)
            ->where('company_id', $company_id)
            ->where('status', 1)
            ->get();
        $atividade_id = $atividade->first()->id;
        $atividade_description = $atividade->first()->description;

        $observacoes = Observacao::where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('company_id', $company_id);


        $data = [
            'atividade_id' => $atividade_id,
            'atividade_description' => $atividade_description,
            'funcionario_id' => $funcionario_id,
            'observacoes' => $observacoes->get()
        ];
        return view('pages.company.editar_observacoes', $data);
    }

    public function send_message(Request $req, $atividade_id, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        Observacao::create([
            'company_id' => $company_id,
            'funcionario_id' => $funcionario_id,
            'atividade_id' => $atividade_id,
            'message' => $req->message,
            'sender_id' => $req->user()->id,
            'sender_type' => 2 // 2 - Admin / 1 - Funcionario

        ]);
        Session::flash('success', "A observação da atividade foi cadastrada com sucesso!");
        return Redirect::back();
    }
}
