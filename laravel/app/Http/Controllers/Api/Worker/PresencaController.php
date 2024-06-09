<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Frequencia;
use Illuminate\Http\Request;

class PresencaController extends Controller
{
    public function index(Request $req)
    {
        $user = $req->user();

        $commonDates = CommomDataService::getCommonDates($req);
        $funcionario_id = $user->funcionario->id;
        $company = $user->funcionario->company;

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
            'ultimaBatidaPontoHoje' => $ultimaBatidaPontoHoje,
            'totalBatidasPontoHoje' => $batidasPontoHoje->count(),
            'batidasPontoHoje' => $batidasPontoHoje,
            'comapany_plan' => $company->plan,
            ...CommomDataService::restApiTokenWeb($req)
        ];

        return $data;
    }
}
