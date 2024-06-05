<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CityService;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\BiometriaFacial;
use App\Models\Frequencia;
use App\Models\Funcionario;
use App\Models\FuncionarioAtividade;
use App\Models\Observacao;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class WorkerDashboardController extends Controller
{
    public function presencaSave()
    {
        Frequencia::create([
            'company_id',
            'funcionario_id',
            'direction',
            'document',
            'frequencia_id',
            'ponto'
        ]);

        Session::flash('success', "A observação da atividade foi cadastrada com sucesso!");
        return Redirect::back();
    }

    public function perfil_atualizar(Request $req)
    {
        $user = User::find(Auth::user()->id);
        if ($req->avatar) {
            $user->avatar = $req->avatar;
            $user->save();
        }

        Session::flash('success', "Perfil atualizado com sucesso");
        return Redirect::back();
    }

    public function home(Request $req)
    {
        $user = Auth::user();
        $company = $user->funcionario->company;
        $funcionario_id = $user->funcionario->id;

        $commonDates = CommomDataService::getCommonDates($req);

        $atividades = Atividade::select('atividades.*')
            ->join('atividade_funcionarios', 'atividade_funcionarios.atividade_id', 'atividades.id')
            ->where('atividade_funcionarios.funcionario_id', $user->funcionario->id)
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();

        foreach($atividades as $row_atividade) {
            $atividade_funcionario = AtividadeFuncionario::where('funcionario_id' , $funcionario_id)->where('atividade_id', $row_atividade->id)->value('id');
            $senderId = Observacao::select('sender_id')->where('atividade_funcionario_id', $atividade_funcionario)->where('funcionario_id', $funcionario_id)->orderBy('id', 'desc')->value('sender_id');
            $row_atividade->atividade_funcionario = $atividade_funcionario;
            $row_atividade->observacao = Observacao::select('message')->where('id', $senderId)->value('message');
            $row_atividade->observacao_count = Observacao::select('message')->where('atividade_funcionario_id', $row_atividade->id)->where('funcionario_id', $funcionario_id)->count();

            $row_atividade->funcionario_atividade = FuncionarioAtividade::select('status')
            ->where('company_id', $company->id)
            ->where('atividade_id', $row_atividade->id)
            ->where('dia', $commonDates['dateForMySQL'])
            ->where('funcionario_id',  $funcionario_id)
            ->value('status');

        }



        $atividades_hoje = AtividadeFuncionario::where('company_id', $user->funcionario->company_id)
            ->where('funcionario_id', $funcionario_id)
            ->whereHas('atividade', function ($qAtividade) use ($commonDates) {
                $qAtividade->whereHas('atividade_dias_semana', function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                })->with(['atividade_dias_semana' => function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                }]);
            })->get();

        $atividades_id = $atividades->pluck('id')->toArray();

        $observacoes = Observacao::whereIn('atividade_funcionario_id', $atividades_id)
            ->where('company_id', $user->funcionario->company_id)
            ->where('funcionario_id', $user->funcionario->id)
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();
        
        $atividadesCompleta = FuncionarioAtividade::where('company_id', $company->id)
            ->where('dia', $commonDates['dateForMySQL'])
            ->where('funcionario_id',  $funcionario_id)
            ->where('status', 1)
            ->get()
            ->count();

        $porcentagem_completas = round($this->getPercentage($atividadesCompleta, $atividades_hoje->count()));

        $ultimaBatidaPontoHoje = Frequencia::where('company_id', $company->id)
            ->where('funcionario_id', $funcionario_id)
            ->whereDate('ponto', $commonDates['dateForMySQL'])
            ->orderBy('ponto', 'DESC')
            ->first();

        $batidasPontoHoje = Frequencia::where('company_id', $company->id)
            ->where('funcionario_id', $funcionario_id)
            ->whereDate('ponto', $commonDates['dateForMySQL'])
            ->orderBy('ponto', 'ASC')
            ->get();

        $data = [
            'atividades' => $atividades,
            'observacoes' => $observacoes,
            'company' => $company,
            'user' => $user,
            'funcionario' => $user->funcionario,
            'atividades_hoje' => $atividades_hoje,
            'historico_action' => '/',
            'porcentagem_completas' => $porcentagem_completas,
            'ultimaBatidaPontoHoje' => $ultimaBatidaPontoHoje,
            'totalBatidasPontoHoje' => $batidasPontoHoje->count(),
            'batidasPontoHoje' => $batidasPontoHoje,
            ...$commonDates,
            ...CommomDataService::restApiTokenWeb($req)

        ];
        return view('pages.worker.home', $data);
    }


    private function getPercentage($completas, $total)
    {
        $percentage = 0;
        if ($completas < 1 || $total < 1) {
            $percentage = 0;
        } else if ($completas === $total) {
            $percentage = 100;
        } else {
            $percentage = (($total - $completas) / $total) * 100;
        }

        if ($percentage > 0 && $percentage !== 100) {
            $percentage = 100 - $percentage;
        }

        return $percentage;
    }

    public function perfil()
    {
        $user = Auth::user();
        $company = $user->funcionario->company;
        $funcionario_id = $user->funcionario->id;

        $funcionario = Funcionario::where(['id' => $funcionario_id, 'company_id' => $company->id])->first();
        $data = [
            'funcionario' => $funcionario,
            'states' => CityService::getStates(),
            'cities' => $funcionario->state_id ? CityService::getCities($funcionario->state_id) : []
        ];

        return view('pages.worker.perfil', $data);
    }

    public function manualuso() {

        return view('pages.worker.manualuso');
    }

    public function novaBiometria(Request $req) {

        $user = Auth::user();
        $company = $user->funcionario->company;
        BiometriaFacial::where('company_id', $company->id)->where('user_id', $user->id)->delete();

        $funcionario_id = $user->funcionario->id;

        $commonDates = CommomDataService::getCommonDates($req);

        $atividades = Atividade::select('atividades.*')
            ->join('atividade_funcionarios', 'atividade_funcionarios.atividade_id', 'atividades.id')
            ->where('atividade_funcionarios.funcionario_id', $user->funcionario->id)
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();

        foreach($atividades as $row_atividade) {
            $atividade_funcionario = AtividadeFuncionario::where('funcionario_id' , $funcionario_id)->where('atividade_id', $row_atividade->id)->value('id');
            $senderId = Observacao::select('sender_id')->where('atividade_funcionario_id', $atividade_funcionario)->where('funcionario_id', $funcionario_id)->orderBy('id', 'desc')->value('sender_id');
            $row_atividade->atividade_funcionario = $atividade_funcionario;
            $row_atividade->observacao = User::select('name')->where('id', $senderId)->value('name');
            $row_atividade->observacao_count = Observacao::select('message')->where('atividade_funcionario_id', $row_atividade->id)->where('funcionario_id', $funcionario_id)->count();

            $row_atividade->funcionario_atividade = FuncionarioAtividade::select('status')
            ->where('company_id', $company->id)
            ->where('atividade_id', $row_atividade->id)
            ->where('dia', $commonDates['dateForMySQL'])
            ->where('funcionario_id',  $funcionario_id)
            ->value('status');
        }

        $atividades_hoje = AtividadeFuncionario::where('company_id', $user->funcionario->company_id)
            ->where('funcionario_id', $funcionario_id)
            ->whereHas('atividade', function ($qAtividade) use ($commonDates) {
                $qAtividade->whereHas('atividade_dias_semana', function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                })->with(['atividade_dias_semana' => function ($qAtividadeDiasSemana) use ($commonDates) {
                    $qAtividadeDiasSemana->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                }]);
            })->get();

        $atividades_id = $atividades->pluck('id')->toArray();

        $observacoes = Observacao::whereIn('atividade_funcionario_id', $atividades_id)
            ->where('company_id', $user->funcionario->company_id)
            ->where('funcionario_id', $user->funcionario->id)
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();
            
        $atividadesCompleta = FuncionarioAtividade::where('company_id', $company->id)
            ->whereIn('atividade_id', $atividades_id)
            ->where('dia_da_semana', $commonDates['dayOfTheWeek'])
            ->where('dia', $commonDates['dateForMySQL'])
            ->where('funcionario_id',  $funcionario_id)
            ->where('status', 1)
            ->get();

        $porcentagem_completas = round($this->getPercentage($atividadesCompleta->count(), $atividades_hoje->count()));

        $ultimaBatidaPontoHoje = Frequencia::where('company_id', $company->id)
            ->where('funcionario_id', $funcionario_id)
            ->whereDate('ponto', $commonDates['dateForMySQL'])
            ->orderBy('ponto', 'DESC')
            ->first();

        $batidasPontoHoje = Frequencia::where('company_id', $company->id)
            ->where('funcionario_id', $funcionario_id)
            ->whereDate('ponto', $commonDates['dateForMySQL'])
            ->orderBy('ponto', 'ASC')
            ->get();

        $data = [
            'atividades' => $atividades,
            'observacoes' => $observacoes,
            'company' => $company,
            'user' => $user,
            'funcionario' => $user->funcionario,
            'atividades_hoje' => $atividades_hoje,
            'historico_action' => '/',
            'porcentagem_completas' => $porcentagem_completas,
            'ultimaBatidaPontoHoje' => $ultimaBatidaPontoHoje,
            'totalBatidasPontoHoje' => $batidasPontoHoje->count(),
            'batidasPontoHoje' => $batidasPontoHoje,
            ...$commonDates,
            ...CommomDataService::restApiTokenWeb($req)

        ];
        return view('pages.worker.home', $data);
    }
}
