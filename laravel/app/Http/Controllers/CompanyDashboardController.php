<?php

namespace App\Http\Controllers;

use App\Http\Services\CityService;
use App\Http\Services\CommomDataService;
use App\Http\Services\DomainService;
use App\Models\Atividade;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\FuncionarioAtividade;
use App\Models\Jornada;
use App\Models\Observacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CompanyDashboardController extends Controller
{
    public function qrcode()
    {
        $data = [
            'url' => DomainService::getFullHost(config('app.sudomains.funcionario'))
        ];
        return view('pages.company.qrcode', $data);
    }
    public function perfil(Request $req)
    {

        $company = Auth::user()->company;
        $data = [
            'company' => $company,
            'user' => $req->user(),
            'states' => CityService::getStates(),
            'cities' => $company->state_id ? CityService::getCities($company->state_id) : []
        ];

        return view('pages.company.perfil', $data);
    }

    public function perfil_atualizar(Request $req)
    {
        $user = User::find(Auth::user()->id);
        if ($req->avatar) {
            $user->avatar = $req->avatar;
            $user->save();
        }

        Session::flash('success', "Perfil atualizado com sucesso!");
        return Redirect::back();
    }

    public function home(Request $req)
    {
        $commonDates = CommomDataService::getCommonDates($req);
        $company = Auth::user()->company;
        $company_id = $company->id;

        // ** //

        $funcoes = Funcao::where('company_id', $company_id)
            ->where('status', 1)
            ->whereHas('atividades', function ($queryAtividade) use ($commonDates, $company_id) {
                $queryAtividade->where('company_id', $company_id)
                    ->whereHas('atividade_dias_semana', function ($queryAtividadeDia) use ($commonDates, $company_id) {
                        $queryAtividadeDia->where('company_id', $company_id)
                            ->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                    });
            })->limit(10)->orderBy('id', 'DESC')->get();

        foreach ($funcoes as $funcao) {
            $atividades = [];
            foreach ($funcao->atividades as $atividade) {
                foreach ($atividade->atividade_dias_semana as $dia) {
                    if ($dia->dia_da_semana === $commonDates['dayOfTheWeek']) {
                        array_push($atividades, [$atividade, $dia]);
                    }
                }
            }

            $atividades_total_funcao_completadas = 0;

            $total_funcionarios = 0;

            foreach ($atividades as $at) {
                $hasAtividade = FuncionarioAtividade::where('company_id', $company_id)
                    ->where('atividade_id', $at[0]->id)
                    ->where('dia', $commonDates['dateForMySQL'])
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->get();

                if ($hasAtividade->count()) {
                    $atividades_total_funcao_completadas = $atividades_total_funcao_completadas + $hasAtividade->count();
                }

            
                $getFuncionarios = AtividadeFuncionario::where('funcionarios.company_id', $company_id)
                ->join('funcionarios', 'atividade_funcionarios.funcionario_id', 'funcionarios.id')
                ->where('atividade_id', $at[0]->id)
                ->where('status', 1)
                ->groupBy('funcionarios.id')
                ->count();


                $total_funcionarios += $getFuncionarios;
            }

            $funcao->total_funcionarios = $total_funcionarios;
            $funcao->porcentagem_completas = round($this->getPercentage($atividades_total_funcao_completadas, count($atividades)));
        }

        // ** //


        $funcionarios = Funcionario::where('company_id', $company_id)->limit(10)->orderBy('id', 'DESC')->get();

        foreach ($funcionarios as $funcionario) {

            $atividadesCadastradas = AtividadeFuncionario::where('company_id', $company_id)
                ->where('funcionario_id', $funcionario->id)
                ->where('status', 1)
                ->get()
                ->count();

            $atividadesCompletas = FuncionarioAtividade::where('company_id', $company_id)
                ->where('dia', $commonDates['dateForMySQL'])
                ->where('funcionario_id', $funcionario->id)
                ->where('status', 1)
                ->get()
                ->count();

            $funcionario->atividades = $atividadesCadastradas;

            $funcionario->porcentagem_completas = round($this->getPercentage($atividadesCompletas, $atividadesCompletas));
        }


        $atividades = Atividade::select('atividades.*')
            ->join('atividade_funcionarios', 'atividade_funcionarios.atividade_id', 'atividades.id')
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();

        foreach($atividades as $row_atividade) {
            $atividade_funcionario = AtividadeFuncionario::where('atividade_id', $row_atividade->id)->value('id');
            $senderId = Observacao::select('sender_id')->where('atividade_funcionario_id', $atividade_funcionario)->orderBy('id', 'desc')->value('sender_id');
            $row_atividade->atividade_funcionario = $atividade_funcionario;
            $row_atividade->observacao = Observacao::select('message')->where('id', $senderId)->value('message');
            $row_atividade->observacao_count = Observacao::select('message')->where('atividade_funcionario_id', $row_atividade->id)->count();

            $funcionario_id = AtividadeFuncionario::where('atividade_id', $row_atividade->id)->value('funcionario_id');
            $row_atividade->funcao_title = Funcao::where('id', $row_atividade->funcao_id)->value('title');
            $row_atividade->funcionario_id = $funcionario_id;
            $row_atividade->user_id = User::select('users.id')->join('funcionarios', 'users.id', 'funcionarios.user_id')->where('funcionarios.id', $funcionario_id)->value('users.id');
            $row_atividade->user_name = User::select('name')->join('funcionarios', 'users.id', 'funcionarios.user_id')->where('funcionarios.id', $funcionario_id)->value('name');

            $row_atividade->funcionario_atividade = FuncionarioAtividade::select('status')
            ->where('company_id', $company->id)
            ->where('atividade_id', $row_atividade->id)
            ->where('dia', $commonDates['dateForMySQL'])
            ->value('status');
        }

        $now = CommomDataService::getCarbonNow();

        $frequencias = DB::table('funcionarios')
                       ->select('frequencias.*', 'users.name', 'funcoes.title as funcao_title')
                       ->leftjoin('frequencias', 'frequencias.funcionario_id', 'funcionarios.id')
                       ->join('users', 'users.id', 'funcionarios.user_id')
                       ->join('funcoes', 'funcoes.id', 'funcionarios.funcao_id')
                       ->where('funcionarios.company_id', $company_id)
                       ->limit(10)
                       ->orderBy('id', 'desc')
                       ->get();
    
        $atividades_detalhes = FuncionarioAtividade::where('company_id', $company_id)
            ->whereDate('created_at', $now)
            ->limit(10)
            ->orderBy('id', 'DESC')
            ->get();
        // ** //


        $funcoes_list = Funcao::where('company_id', $company_id)->where('status', 1)->limit(10)->orderBy('id', 'DESC')->get();
        // ** //

        $jornadas = Jornada::where('company_id', $company_id)->where('status', 1)->limit(10)->orderBy('id', 'DESC')->get();

        // ** //

        $funcionarios_list = Funcionario::where('company_id', $company_id)->limit(10)->orderBy('id', 'DESC')->get();

        // ** //

        $data = [
            'historico_action' => '/',
            'total_funcoes' => Funcao::where('company_id', $req->user()->company->id)->where('status', 1)->count(),
            'total_jornadas' => Jornada::where('company_id', $req->user()->company->id)->where('status', 1)->count(),
            'total_observacoes' => Observacao::where('company_id', $req->user()->company->id)->count(),
            'total_atividades' => Atividade::where('company_id', $req->user()->company->id)->where('status', 1)->count(),
            'total_funcionarios' => Funcionario::where('company_id', $req->user()->company->id)->count(),
            'atividades' => $atividades,
            'funcoes' => $funcoes,
            'funcionarios' => $funcionarios,
            'frequencias' => $frequencias,
            'atividades_detalhes' => $atividades_detalhes,
            'funcoes_list' => $funcoes_list,
            'funcionarios_list' => $funcionarios_list,
            'jornadas' => $jornadas,
            ...$commonDates
        ];
        return view('pages.company.home', $data);
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

    private function generatePDF_funcionarios() {

    }

    private function generatePDF_frequencias() {

    }

    private function generateExcel_funcionarios() {

    }

    private function generateExcel_frequencias() {
        
    }

}
