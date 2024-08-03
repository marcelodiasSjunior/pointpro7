<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\Controller;
use App\Models\AtividadeFuncionario;
use App\Models\Observacao;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $req)
    {
        $user = $req->user();
        $atividades = AtividadeFuncionario::where('funcionario_id', $user->funcionario->id)
            ->where('company_id', $user->funcionario->company_id)
            ->with('atividade')
            ->get();

        $atividades_id = $atividades->pluck('id')->toArray();

        $observacoes = Observacao::whereIn('atividade_funcionario_id', $atividades_id)
            ->where('company_id', $user->funcionario->company_id)
            ->where('funcionario_id', $user->funcionario->id)
            ->where('status', 1)
            ->get();
        $user->funcionario->jornada->total_semana =             $user->funcionario->jornada->totalSemanal;
        $data = [
            'atividades' => $atividades->count(),
            'observacoes' => $observacoes->count(),
            'company' => $user->funcionario->company,
            'onboarding' => $user->funcionario->funcao->onboarding,
            'funcao' => $user->funcionario->funcao,
            'jornada' => $user->funcionario->jornada,
            'user' => $user
        ];

        return $data;
    }
}
