<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\FuncionarioAtividade;
use App\Models\Observacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ObservacoesController extends Controller
{
    public function listar(Request $req)
    {
        $user = $req->user();
        $funcionario = $user->funcionario;        
        $company_id = $funcionario->company_id;
        $funcao_id = $funcionario->funcao_id;
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');
        $funcionario_id = $funcionario->id;

        $commonDates = CommomDataService::getCommonDates($req);

        $atividades = AtividadeFuncionario::where('company_id', $company_id)
            ->where('funcionario_id', $funcionario->id)
            ->where('status', 1)
            ->whereHas('atividade', function ($qAtividade) use ($commonDates) {
                $qAtividade->whereHas('atividade_dias_semana', function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                })->with(['atividade_dias_semana' => function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                }]);
            })->get();

        foreach($atividades as $row_atividade) {

            $row_atividade->funcionario_atividade = FuncionarioAtividade::select('status')
            ->where('company_id', $company_id)
            ->where('atividade_funcionario_id', $row_atividade->id)
            ->where('dia', $commonDates['dateForMySQL'])
            ->where('funcionario_id',  $funcionario_id)
            ->value('status');
        }

        $data = [
            'funcoes' => Funcao::where('company_id', $company_id)->where('status', 1)->get(),
            'funcionarios' => Funcionario::where('company_id', $company_id)->get(),
            'atividades' => $atividades,
            'funcao_id' => $funcao_id,
            'funcao_title' => $funcao_title,
            'funcionario_id' => $funcionario_id,
            'historico_action' => '/observacoes',
            'user' => $user,
            ...$commonDates
        ];

        return view('pages.worker.observacoes', $data);
    }

    public function edit(Request $req, $atividade_funcionario_id)
    {
        $company_id = $req->user()->funcionario->company->id;
        $funcionario_id = $req->user()->funcionario->id;

        $observacoes = Observacao::where('atividade_funcionario_id', $atividade_funcionario_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('company_id', $company_id)
            ->orderBy('created_at', 'DESC');

        $atividade_id = AtividadeFuncionario::where('id', $atividade_funcionario_id)->where('status', 1)->value('atividade_id');
        $atividade_description = Atividade::where('company_id', $company_id)->where('id', $atividade_id)->value('description');

        $data = [
            'atividade_funcionario_id' => $atividade_funcionario_id,
            'atividade_description' => $atividade_description,
            'funcionario_id' => $funcionario_id,
            'observacoes' => $observacoes->get()
        ];
        return view('pages.worker.editar_observacoes', $data);
    }

    public function send_message(Request $req, $atividade_funcionario_id)
    {
        $company_id = $req->user()->funcionario->company->id;
        $funcionario_id = $req->user()->funcionario->id;

        Observacao::create([
            'company_id' => $company_id,
            'funcionario_id' => $funcionario_id,
            'atividade_funcionario_id' => $atividade_funcionario_id,
            'message' => $req->message,
            'sender_id' => $req->user()->id,
            'sender_type' => 1 // 2 - Admin / 1 - Funcionario

        ]);
        Session::flash('success', "Mensagem enviada com sucesso!");
        return Redirect::back();
    }
}
