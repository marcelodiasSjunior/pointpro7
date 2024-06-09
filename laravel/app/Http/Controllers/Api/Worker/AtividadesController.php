<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\FuncionarioAtividade;
use App\Models\Observacao;
use Illuminate\Http\Request;

class AtividadesController extends Controller
{
    public function criar(Request $req, $atividade_funcionario_id)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;
        $commonDates = CommomDataService::getCommonDates($req);

        $dataNew = [
            'atividade_id' => (int)$req->atividade_id,
            'funcionario_id' => $funcionario_id,
            'company_id' => $company_id,
            'status' => 0,
            'dia' => $commonDates['dateForMySQL'],
            'atividade_funcionario_id' => (int)$atividade_funcionario_id,
            'dia_da_semana' => $commonDates['dayOfTheWeek']
        ];

        FuncionarioAtividade::create($dataNew);

        return ['message' => 'success'];
    }

    public function atualizar(Request $req, $funcionario_atividade_id)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;


        FuncionarioAtividade::where('atividade_id', $req->atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('id', $funcionario_atividade_id)
            ->where('company_id', $company_id)
            ->update(['status' => 1]);

        return ['message' => 'success'];
    }

    public function index(Request $req)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;

        $commonDates = CommomDataService::getCommonDates($req);

        $atividades = Atividade::where('company_id', $company_id)
            ->whereHas('atividade_funcionario', function ($queryF) use ($funcionario_id) {
                $queryF->where('funcionario_id', $funcionario_id);
            })
            ->whereHas('atividade_dias_semana', function ($queryD) use ($commonDates) {
                $queryD->where('dia_da_semana', $commonDates['dayOfTheWeek']);
            })
            ->get();


        foreach ($atividades as $atividade) {
            $atividadesCadastradas = AtividadeFuncionario::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('funcionario_id', $funcionario_id)
                ->where('status', 1)
                ->get()
                ->count();

            $observacoes = Observacao::whereIn('atividade_funcionario_id', $atividade->id)
                ->where('company_id', $company_id)
                ->where('funcionario_id', $funcionario_id)
                ->get();
                

            $funcionario_atividade = FuncionarioAtividade::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('funcionario_id', $funcionario_id)
                ->where('dia_da_semana', $commonDates['dayOfTheWeek'])
                ->where('dia', $commonDates['dateForMySQL'])
                ->first();

            $atividade->funcionario_atividade = $funcionario_atividade;

            $atividade->atividade_funcionario = AtividadeFuncionario::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('funcionario_id', $funcionario_id)
                ->where('status', 1)
                ->first();

            $atividade->current_status = 'nao_iniciada';

            if ($funcionario_atividade) {
                if ($funcionario_atividade->status === 0) {
                    $atividade->current_status = 'iniciada';
                } else if ($funcionario_atividade->status === 1) {
                    $atividade->current_status = 'completa';
                }
            }
        }

        return [
            'atividades' => $atividades,
            'funcionario_id' => $funcionario_id,
            'historico_action' => '/atividades',
            'hasSearch' =>  $req->dia ? true : false,
            ...$commonDates
        ];
    }
}
