<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Company;
use App\Models\Frequencia;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Jornada;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set( 'America/Sao_Paulo' );


class FrequenciaController extends Controller
{
    public function listar(Request $req)
    {
        $company_id = $req->user()->company->id;
        $commonDates = CommomDataService::getCommonDates($req);
        $now = CommomDataService::getCarbonNow();

        $funcionarios = Funcionario::where('company_id', $company_id)->with('frequencias', function ($queryFrequencias) use ($now) {
            $queryFrequencias->whereDate('ponto', $now);
        })->get();

        foreach ($funcionarios as $funcionario) {
            $funcionario->esta_de_ferias_hoje = false;
        }

        $data = [
            'funcionarios' => $funcionarios,
            ...$commonDates,
            'historico_action' => '/frequencia'
        ];

        return view('pages.company.frequencia', $data);
    }

    public function funcionario(Request $req, $funcionario_id)
    {
        $company_id = $req->user()->company->id;
        $commonDates = CommomDataService::getCommonDates($req);

        $frequencias = Frequencia::where('funcionario_id', $funcionario_id)
            ->where('company_id', $company_id)
            ->whereMonth('ponto', $commonDates['monthNumber'])
            ->whereYear('ponto', $commonDates['yearNumber'])
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->ponto)->format('d');
            });

            foreach ($frequencias as $batida) {
                $pontoDate = date("Y-m-d", strtotime($batida[0]['ponto']));
                $batida->todas = Frequencia::where('funcionario_id', $funcionario_id)
                    ->where('company_id', $company_id)
                    ->whereDate('ponto', $pontoDate)
                    ->get();
            }

        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $jornada_id = Funcionario::where('id', $funcionario_id)->value('jornada_id');
        $jornada_title = Jornada::where('id', $jornada_id)->value('title');

        $funcionario_name = Funcionario::where('funcionarios.id', $funcionario_id)->join('users', 'users.id', 'funcionarios.user_id')->value('users.name');

        $data = [
            'frequencias' => $frequencias,
            ...$commonDates,
            'funcao_title' => $funcao_title,
            'jornada_title' => $jornada_title,
            'funcionario_id' => $funcionario_id,
            'funcionario_name' => $funcionario_name,
            'historico_action' => '/frequencia/' . $funcionario_id
        ];

        return view('pages.company.frequencia_funcionario', $data);
    }

    public function exportPdf(Request $req, $funcionario_id, $ano, $mes)
    {
        $req->ano = $ano;
        $req->mes = $mes;
        $commonDates = CommomDataService::getCommonDates($req);

        $monthNumber = $commonDates['monthNumber'];
        $monthList = $commonDates['monthList'];
        $monthName = $monthList['0'.$monthNumber];

        $company_id = $req->user()->company->id;
        $company_name = Company::where('id', $company_id)->value('title');

        $funcionario = Funcionario::where('id', $funcionario_id)->where('company_id', $company_id)->first();
        $funcionarioUser = $funcionario->user;

        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $inicio  = date("Y-".$mes."-01");
        $fim  = date("Y-".$mes."-t");

        $inicio = new DateTime($inicio);
        $fim = new DateTime($fim);

        $interval = new DateInterval('P1D');
        $periodo = new DatePeriod($inicio, $interval ,$fim);

        $html = "";

        $html .= "<h2>". $company_name . "</h2>";
        $html .= "<h4>Frequência do colaborador <br>" . $funcionarioUser->name . " - " . $mes ."/".$ano. " - " . $funcao_title . "</h4>";
        $html .= "<div class='table-responsive'>";
        $html .= "<table class='table table-hover table-striped ' border='1'>";
        $html .= "<thead style='text-align: center;font-size: 14px;'>";

        $html .= "<tr>";
        $html .= "<th scope='col'>Dia</th>";
        $html .= "<th scope='col'>Mês</th>";
        $html .= "<th scope='col'>Ano</th>";
        $html .= "<th scope='col'>Semana</th>";
        $html .= "<th scope='col'>Início da jornada</th>";
        $html .= "<th scope='col'>Início do intervalo</th>";
        $html .= "<th scope='col'>Fim do intervalo</th>";
        $html .= "<th scope='col'>Fim da jornada</th>";
        $html .= "<th scope='col'>Status</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody style='text-align: center;font-size: 12px;'>";

       foreach($periodo as $data){

        $frequencias = Frequencia::where('funcionario_id', $funcionario_id)
        ->where('company_id', $company_id)
        ->whereDate('ponto', $data->format("Y-m-d"))
        ->with('frequencias')
        ->first();

        if($frequencias) {
                $data_ponto_format = strtotime($frequencias->ponto);

                $batidas = Frequencia::where('funcionario_id', $funcionario_id)
                ->where('company_id', $company_id)
                ->whereDate('ponto', $data->format("Y-m-d"))
                ->get();

                $ponto0 = isset($batidas[0]) ? $batidas[0]->hora : "Não computado";
                $ponto1 = isset($batidas[1]) ? $batidas[1]->hora : "Não computado";
                $ponto2 = isset($batidas[2]) ? $batidas[2]->hora : "Não computado";
                $ponto3 = isset($batidas[3]) ? $batidas[3]->hora : "Não computado";

                $compareceu = "Faltou";

                if ($ponto0 !== "Não computado" || $ponto1 !== "Não computado" || $ponto2 !== "Não computado" || $ponto3 !== "Não computado") {
                  $compareceu = "Incompleto";
                }

                if ($ponto0 !== "Não computado" && $ponto1 !== "Não computado" && $ponto2 !== "Não computado" && $ponto3 !== "Não computado") {
                  $compareceu = "Compareceu";
                }

                if(date("Y-m-d", $data_ponto_format) == $data->format("Y-m-d")) {
                    $html .= "
                    <tr>
                    <th scope='row'>" . $data->format("d/m/Y"). "</th>
                    <th scope='row'>" . $monthName . "</th>
                    <th scope='row'>" . $batidas[0]->ponto_ano . "</th>
                    <th scope='row'>" . $batidas[0]->dia_semana_nome . "</th>
                    <th scope='row'>" . $ponto0 . "</th>
                    <th scope='row'>" . $ponto1 . "</th>
                    <th scope='row'>" . $ponto2 . "</th>
                    <th scope='row'>" . $ponto3 . "</th>
                    <th scope='row'>" . $compareceu . "</th>
                    </tr>";
                }
        } else {
            $html .= "
            <tr>
            <th scope='row'>" . $data->format("d/m/Y"). "</th>
            <th scope='row'>" . $monthName . "</th>
            <th scope='row'>" . $data->format("Y"). "</th>
            <th scope='row'>-</th>
            <th scope='row'>-</th>
            <th scope='row'>-</th>
            <th scope='row'>-</th>
            <th scope='row'>-</th>
            <th scope='row'>Não compareceu</th>
            </tr>";
        }



       }



        $pdf = App::make('dompdf.wrapper');


        $html .= "</tbody>
                    </table>
                  </div>";

        $pdf->loadHTML($html);

        return $pdf->stream();
    }

    public function edit($id)
    {
        $frequencia = Frequencia::find($id);
        return view('editFrequencia')->with('frequencia', $frequencia);
    }

    public function update(Request $request, $id)
    {
        $frequencia = Frequencia::find($id);

        // Get the input and ensure it's in the correct format
        $hora = $request->input('hora');
        if (!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $hora)) {
            return response()->json(['error' => 'Hora inválida. Deve estar no formato HH:MM.'], 400);
        }

        // Combine current date with the time
        $ponto = date('Y-m-d') . ' ' . $hora;

        $frequencia->ponto = $ponto;
        $frequencia->save();

        return back()->with('success', 'Atualização realizada com sucesso!');
    }
}
