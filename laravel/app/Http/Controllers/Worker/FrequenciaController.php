<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Company;
use App\Models\Frequencia;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Jornada;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class  FrequenciaController extends Controller
{
    public function list(Request $req)
    {

        $funcionario_id = $req->user()->funcionario->id;
        $company_id = $req->user()->funcionario->company->id;
        $commonDates = CommomDataService::getCommonDates($req);
        $funcionario = $req->user()->funcionario;        

        $funcao_id = $funcionario->funcao_id;
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $jornada_id = $funcionario->jornada_id;
        $jornada_title = Jornada::where('id', $jornada_id)->value('title');


        $frequencia = Frequencia::where('funcionario_id', $funcionario_id)
            ->where('company_id', $company_id)
            ->whereMonth('ponto', $commonDates['monthNumber'])
            ->whereYear('ponto', $commonDates['yearNumber'])
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->ponto)->format('d');
            });

            foreach ($frequencia as $batida) {
                $pontoDate = date("Y-m-d", strtotime($batida[0]['ponto']));
                $batida->todas = Frequencia::where('funcionario_id', $funcionario_id)
                    ->where('company_id', $company_id)
                    ->whereDate('ponto', $pontoDate)
                    ->get();
                
            }


        $data = [
            'frequencia' => $frequencia,
            'funcionario_id' => $funcionario_id,
            'funcao_title' => $funcao_title,
            'jornada_title' => $jornada_title,
            ...$commonDates,
            'historico_action' => '/frequencia/',
            ...CommomDataService::restApiTokenWeb($req)
        ];

        return view('pages.worker.frequencia', $data);
    }

    public function exportPdf(Request $req, $funcionario_id, $ano, $mes)
    {
        $req->ano = $ano;
        $req->mes = $mes;
        $date = new DateTime('now');

        $company_id = $req->user()->funcionario->company->id;
        $company_name = Company::where('id', $company_id)->value('title');

        $funcionario = Funcionario::where('id', $funcionario_id)->where('company_id', $company_id)->first();
        $funcionarioUser = $funcionario->user;

        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $inicio  = date("Y-".$mes."-01");
        $fim  = $date->modify('last day of this month');

        $inicio = new DateTime($inicio);

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
        ->get();

        if($frequencias->count() > 0) {
            foreach($frequencias as $frequencia_row) {
                $data_ponto_format = strtotime($frequencia_row->ponto);

                $ponto0 = isset($frequencias[0]) ? $frequencias[0]->hora : "Não computado";
                $ponto1 = isset($frequencias[1]) ? $frequencias[1]->hora : "Não computado";
                $ponto2 = isset($frequencias[2]) ? $frequencias[2]->hora : "Não computado";
                $ponto3 = isset($frequencias[3]) ? $frequencias[3]->hora : "Não computado";

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
                    <th scope='row'>" . $frequencias[0]->ponto_mes . "</th>
                    <th scope='row'>" . $frequencias[0]->ponto_ano . "</th>
                    <th scope='row'>" . $frequencias[0]->dia_semana_nome . "</th>
                    <th scope='row'>" . $ponto0 . "</th>
                    <th scope='row'>" . $ponto1 . "</th>
                    <th scope='row'>" . $ponto2 . "</th>
                    <th scope='row'>" . $ponto3 . "</th>
                    <th scope='row'>" . $compareceu . "</th>
                    </tr>";
                } 
            }
        } else {
            $html .= "
            <tr>
            <th scope='row'>" . $data->format("d/m/Y"). "</th>
            <th scope='row'>" . $data->format("M"). "</th>
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
}
