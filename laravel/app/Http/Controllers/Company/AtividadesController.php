<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\AtividadeSaveRequest;
use App\Http\Requests\AtividadeUpdateRequest;
use App\Http\Services\CommomDataService;
use App\Models\Atividade;
use App\Models\AtividadeDiasSemana;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\FuncionarioAtividade;
use App\Models\Observacao;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AtividadesController extends Controller
{
    private function getCarbonNow()
    {
        return Carbon::now('America/Sao_Paulo');
    }

    public function listar(Request $req)
    {
        $company_id = $req->user()->company->id;
        $commonDates = CommomDataService::getCommonDates($req);

        $funcoes = Funcao::where('company_id', $company_id)
            ->where('status', 1)
            ->whereHas('atividades', function ($queryAtividade) use ($commonDates, $company_id) {
                $queryAtividade->where('company_id', $company_id)
                    ->whereHas('atividade_dias_semana', function ($queryAtividadeDia) use ($commonDates, $company_id) {
                        $queryAtividadeDia->where('company_id', $company_id)
                            ->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                    });
            })->get();

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

                $getFuncionarios = AtividadeFuncionario::where('company_id', $company_id)
                    ->where('atividade_id', $at[0]->id)
                    ->where('status', 1)
                    ->count();

                $total_funcionarios += $getFuncionarios;
            }

            $funcao->total_funcionarios = $total_funcionarios;
            $funcao->porcentagem_completas = round($this->getPercentage($atividades_total_funcao_completadas, $atividades_total_funcao_completadas));
        }


        $data = [
            'funcoes' => $funcoes,
            ...$commonDates,
            'historico_action' => '/atividades'
        ];

        return view('pages.company.atividades', $data);
    }

    public function listar_por_funcao(Request $req, $funcionario_id)
    {
        $commonDates = CommomDataService::getCommonDates($req);
        $company_id = $req->user()->company->id;
        $funcionarios = Funcionario::where('company_id', $company_id)->get();
        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        foreach ($funcionarios as $funcionario) {

            $atividadesCadastradas = AtividadeFuncionario::where('company_id', $company_id)
                ->where('funcionario_id', $funcionario->id)
                ->where('status', 1)
                ->whereHas('atividade', function ($q) use ($commonDates) {
                    $q->whereHas('atividade_dias_semana', function ($queryD) use ($commonDates) {
                        $queryD->where('dia_da_semana', $commonDates['dayOfTheWeek']);
                    });
                })
                ->get()
                ->count();

            $atividadesCompletas = FuncionarioAtividade::where('company_id', $company_id)
                ->where('dia_da_semana', $commonDates['dayOfTheWeek'])
                ->where('dia', $commonDates['dateForMySQL'])
                ->where('funcionario_id', $funcionario->id)
                ->where('status', 1)
                ->get()
                ->count();

            $funcionario->atividades = $atividadesCadastradas;

            $funcionario->porcentagem_completas = round($this->getPercentage($atividadesCompletas, $atividadesCadastradas));
        }

        $data = [
            'funcionarios' => $funcionarios,
            'funcao_title' => $funcao_title,
            ...$commonDates,
            'historico_action' => '/atividades/funcao/' . $funcionario_id
        ];

        return view('pages.company.atividades_por_funcao', $data);
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

    public function listar_por_funcionario_todas(Request $req, $funcionario_id)
    {
        $funcionario_id = (int)$funcionario_id;
        $commonDates = CommomDataService::getCommonDates($req);
        $company_id = $req->user()->company->id;

        $user_id = Funcionario::where('id', $funcionario_id)->value('user_id');
        $funcionario_name = User::where('id', $user_id)->value('name');

        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $atividades = Atividade::where('company_id', $company_id)
            ->whereHas('atividade_funcionario', function ($queryF) use ($funcionario_id) {
                $queryF->where('funcionario_id', $funcionario_id);
                $queryF->where('status', 1);
            })
            ->get();

        foreach ($atividades as $atividade) {
            $atividadesCompleta = FuncionarioAtividade::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('dia', $commonDates['dateForMySQL'])
                ->where('funcionario_id',  $funcionario_id)
                ->first();

            $atividade->nao_iniciada = !$atividadesCompleta;
            $atividade->iniciada = $atividadesCompleta && $atividadesCompleta->status === 0;
            $atividade->completa = $atividadesCompleta && $atividadesCompleta->status === 1;

            $atividade->observacoes = Observacao::where('funcionario_id', $funcionario_id)->where('atividade_funcionario_id', $atividade->id)->where('company_id', $company_id)->get()->count();
        }

        $data = [
            'atividades' => $atividades,
            'funcionario_id' => $funcionario_id,
            'funcionario_name' => $funcionario_name,
            'funcao_title' => $funcao_title,
            ...$commonDates,
            'historico_action' => '/atividades/funcionario/' . $funcionario_id
        ];
        return view('pages.company.atividades_por_funcionario', $data);
    }
    public function listar_por_funcionario(Request $req, $funcionario_id)
    {

        $funcionario_id = (int)$funcionario_id;
        $commonDates = CommomDataService::getCommonDates($req);
        $company_id = $req->user()->company->id;

        $user_id = Funcionario::where('id', $funcionario_id)->value('user_id');
        $funcionario_name = User::where('id', $user_id)->value('name');

        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $atividades = Atividade::where('company_id', $company_id)
            ->whereHas('atividade_funcionario', function ($queryF) use ($funcionario_id) {
                $queryF->where('funcionario_id', $funcionario_id);
                $queryF->where('status', 1);
            })
            ->whereHas('atividade_dias_semana', function ($queryD) use ($commonDates) {
                $queryD->where('dia_da_semana', $commonDates['dayOfTheWeek']);
            })
            ->get();

        foreach ($atividades as $atividade) {
            $atividadesCompleta = FuncionarioAtividade::where('company_id', $company_id)
                ->where('atividade_id', $atividade->id)
                ->where('dia_da_semana', $commonDates['dayOfTheWeek'])
                ->where('dia', $commonDates['dateForMySQL'])
                ->where('funcionario_id',  $funcionario_id)
                ->first();


            $atividade->nao_iniciada = !$atividadesCompleta;
            $atividade->iniciada = $atividadesCompleta && $atividadesCompleta->status === 0;
            $atividade->completa = $atividadesCompleta && $atividadesCompleta->status === 1;

            $atividade->observacoes = Observacao::where('funcionario_id', $funcionario_id)->where('atividade_funcionario_id', $atividade->id)->where('company_id', $company_id)->get()->count();
        }

        $data = [
            'atividades' => $atividades,
            'funcionario_id' => $funcionario_id,
            'funcionario_name' => $funcionario_name,
            'funcao_title' => $funcao_title,
            ...$commonDates,
            'historico_action' => '/atividades/funcionario/' . $funcionario_id
        ];
        return view('pages.company.atividades_por_funcionario', $data);
    }

    public function criar(Request $req, $funcionario_id, $atividade_id)
    {
        $company_id = $req->user()->company->id;
        $commonDates = CommomDataService::getCommonDates($req);

        $atividade_funcionario =  AtividadeFuncionario::where('company_id', $company_id)
            ->where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('status', 1)
            ->first();


        if ($req->deletar && (int)$req->deletar === 1) {
            FuncionarioAtividade::where('atividade_id', $atividade_id)
                ->where('funcionario_id', $funcionario_id)
                ->where('atividade_funcionario_id', $atividade_funcionario->id)
                ->where('company_id', $company_id)
                ->where('dia_da_semana', $req->dia_da_semana)
                ->where('dia', $req->dateForMySQL)
                ->delete();
            Session::flash('success', "Atividade atualizada com sucesso!");
            return Redirect::back();
        }
        $exists = FuncionarioAtividade::where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('atividade_funcionario_id', $atividade_funcionario->id)
            ->where('company_id', $company_id)
            ->where('dia_da_semana', $req->dia_da_semana)
            ->where('dia', $req->dateForMySQL)
            ->first();

        if (!$exists) {
            $dataNew = [
                'atividade_id' => (int)$req->atividade_id,
                'funcionario_id' => $funcionario_id,
                'company_id' => $company_id,
                'status' => 0,
                'dia' => $req->dateForMySQL,
                'atividade_funcionario_id' => $atividade_funcionario->id,
                'dia_da_semana' => $req->dia_da_semana
            ];

            FuncionarioAtividade::create($dataNew);

            Session::flash('success', "Atividade atualizada com sucesso!");
            return Redirect::back();
        }

        FuncionarioAtividade::where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('atividade_funcionario_id', $atividade_funcionario->id)
            ->where('company_id', $company_id)
            ->where('dia_da_semana', $req->dia_da_semana)
            ->where('dia', $req->dateForMySQL)
            ->update(['status' => 0]);

        Session::flash('success', "Atividade atualizada com sucesso!");
        return Redirect::back();
    }

    public function atualizar(Request $req, $funcionario_id, $atividade_id)
    {
        $company_id = $req->user()->company->id;


        $atividade_funcionario =  AtividadeFuncionario::where('company_id', $company_id)
            ->where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('status', 1)
            ->first();

        FuncionarioAtividade::where('atividade_id', $atividade_id)
            ->where('funcionario_id', $funcionario_id)
            ->where('atividade_funcionario_id', $atividade_funcionario->id)
            ->where('company_id', $company_id)
            ->where('dia_da_semana', $req->dia_da_semana)
            ->where('dia', $req->dateForMySQL)
            ->update(['status' => 1]);

        Session::flash('success', "Atividade atualizada com sucesso!");
        return Redirect::back();
    }

    public function create(Request $req)
    {
        $funcoes = Funcao::where('company_id', $req->user()->company->id)->where('status', 1)->get();

        $funcionarios = Funcionario::where('company_id', $req->user()->company->id)->get();

        $data = [
            'funcionarios' => $funcionarios,
            'funcoes' => $funcoes
        ];

        return view('pages.company.criar_atividade', $data);
    }

    public function delete(Request $req, $atividade_id, $funcionario_id)
    {
        $atividadesFuncionarioCompany = AtividadeFuncionario::where(['funcionario_id' => $funcionario_id, 'company_id' => $req->user()->company->id])->where('status', 1)->get();

        $id_atividade_funcionario = AtividadeFuncionario::select('id')
                                    ->where('funcionario_id', $funcionario_id,)
                                    ->where('company_id', $req->user()->company->id)
                                    ->where('atividade_id', $atividade_id)
                                    ->value('id');

        if($atividadesFuncionarioCompany->count() <= 1) {
            return Redirect::back()->withErrors(['msg' => 'O funcionário possui apenas uma atividade cadastrada. Crie uma nova e mova o funcionário antes de deletar!']);
        } else {
            AtividadeFuncionario::where('funcionario_id',$funcionario_id)->where('id', $id_atividade_funcionario)->update(['status' => 0]);
        }

        Session::flash('success', "Atividade inativada com sucesso para esse funcionario!");
        return Redirect::back();
    }

    public function edit(Request $req, $atividade_id)
    {
        $funcoes = Funcao::where('company_id', $req->user()->company->id)->where('status', 1)->get();
        $funcionarios = Funcionario::where('company_id', $req->user()->company->id)->wherehas('user')->get();
        $atividade = Atividade::where('company_id', $req->user()->company->id)->where('id', $atividade_id)->first();
        $dias_salvos = AtividadeDiasSemana::where('company_id', $req->user()->company->id)->where('atividade_id', $atividade_id)->get()->pluck('dia_da_semana')->toArray();
        $funcionarios_salvos = AtividadeFuncionario::where('company_id', $req->user()->company->id)->where('atividade_id', $atividade_id)->pluck('funcionario_id')->toArray();

        $data = [
            'atividade' => $atividade,
            'funcionarios' => $funcionarios,
            'funcoes' => $funcoes,
            'dias_salvos' => $dias_salvos,
            'funcionarios_salvos' => $funcionarios_salvos
        ];

        return view('pages.company.editar_atividade', $data);
    }

    public function update(AtividadeUpdateRequest $req, $atividade_id)
    {
        $atividade = Atividade::where('company_id', $req->user()->company->id)->where('id', $atividade_id)->first();
        AtividadeDiasSemana::where('company_id', $req->user()->company->id)->where('atividade_id', $atividade_id)->delete();
        AtividadeFuncionario::where('company_id', $req->user()->company->id)->where('atividade_id', $atividade_id)->delete();

        $this->setupAtividade($req, $atividade);

        Atividade::where('company_id', $req->user()->company->id)->where('id', $atividade_id)->update([
            'description' => $req->description,
            'funcao_id' => $req->funcao
        ]);

        Session::flash('success', "Atividade atualizada com sucesso!");
        return Redirect::back();
    }

    public function save(AtividadeSaveRequest $req)
    {
        // Cadastra atividade
        $atividade = Atividade::create([
            'company_id' => $req->user()->company->id,
            'description' => $req->description,
            'funcao_id' => $req->funcao,
            'status' => 1
        ]);
        $this->setupAtividade($req, $atividade);

        Session::flash('success', "Atividade cadastrada com sucesso!");
        return Redirect::back();
    }

    private function setupAtividade($req, $atividade)
    {
        // Cadastra dias da semana para atividade
        $dias_da_semana_todos = array_search('todos', $req->dias_da_semana);
        $dias_da_semana = $req->dias_da_semana;

        if ($dias_da_semana_todos !== false) {
            $dias_da_semana = [];
            foreach (range(1, 7) as $index) {
                $dias_da_semana[$index - 1] = $index;
            }
        }

        foreach ($dias_da_semana as $dia) {
            AtividadeDiasSemana::create([
                'company_id' => $req->user()->company->id,
                'dia_da_semana' => $dia,
                'atividade_id' => $atividade->id
            ]);
        }


        // Cadastra funcionarios para atividade
        $funcionarios_todos = null;

        if (is_array($req->funcionarios)) {
            $funcionarios_todos = array_search('todos', $req->funcionarios);
            $funcionarios = $req->funcionarios;
        }
        if ($funcionarios_todos !== false || !$req->funcionarios) {
            $funcionarios = [];
            $funcionariosList = Funcionario::where('company_id', $req->user()->company->id)->where('funcao_id', $req->funcao)->wherehas('user')->get();

            foreach ($funcionariosList as $f) {
                array_push($funcionarios, $f->id);
            }
        }

        foreach ($funcionarios as $f2) {
            AtividadeFuncionario::create([
                'company_id' => $req->user()->company->id,
                'funcionario_id' => isset($f2->id) ? $f2->id : $f2,
                'atividade_id' => $atividade->id,
                'status' => 1
            ]);
        }
    }
}
