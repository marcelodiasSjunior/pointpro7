<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\FuncionarioAtividade;
use App\Models\Jornada;
use App\Models\Observacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AtividadesController extends Controller
{
    public function criar(Request $req, $atividade_funcionario_id)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;

        $dataNew = [
            'atividade_id' => (int)$req->atividade_id,
            'funcionario_id' => $funcionario_id,
            'company_id' => $company_id,
            'status' => 0,
            'atividade_funcionario_id' => (int)$atividade_funcionario_id,
            'dia' => $req->dateForMySQL,
            'dia_da_semana' => $req->dia_da_semana
        ];

        FuncionarioAtividade::create($dataNew);

        Session::flash('success', "Atividade registrada com sucesso!");
        return Redirect::back();
    }
    public function atualizar(Request $req, $funcionario_atividade_id)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;


        FuncionarioAtividade::where('atividade_id', $req->atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('id', $funcionario_atividade_id)
            ->where('company_id', $company_id)
            ->where('dia_da_semana', $req->dia_da_semana)
            ->where('dia', $req->dateForMySQL)
            ->update(['status' => 1]);

        Session::flash('success', "Atividade atualizada com sucesso");
        return Redirect::back();
    }
    public function listar(Request $req)
    {
        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;

        $commonDates = CommomDataService::getCommonDates($req);

        $funcionario = $req->user()->funcionario;        

        $funcao_id = $funcionario->funcao_id;
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $jornada_id = $funcionario->jornada_id;
        $jornada_title = Jornada::where('id', $jornada_id)->value('title');


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

            $funcionario_atividade = FuncionarioAtividade::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('funcionario_id',  $funcionario_id)
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

            $atividade->observacoes = Observacao::where('funcionario_id', $funcionario_id)->where('atividade_funcionario_id', $atividade->id)->where('company_id', $company_id)->get()->count();

        }

        $data = [
            'atividades' => $atividades,
            'funcao_title' => $funcao_title,
            'jornada_title' => $jornada_title,
            'funcionario_id' => $funcionario_id,
            'historico_action' => '/atividades',
            'hasSearch' =>  $req->dia ? true : false,
            ...$commonDates
        ];

        return view('pages.worker.atividades', $data);
    }
}
