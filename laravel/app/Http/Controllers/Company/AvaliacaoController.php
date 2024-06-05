<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Avaliacao;
use App\Models\Funcao;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AvaliacaoController extends Controller
{

    public function funcionario(Request $req, $funcionario_id)
    {
        $company_id = $req->user()->company->id;
        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');

        $funcionario =  Funcionario::select('funcionarios.*', 'users.name as nome')->where('funcionarios.id', $funcionario_id)->join('users', 'users.id', 'funcionarios.user_id')->first();
        
        $avaliacoes = DB::table('avaliacoes')
                     ->select('avaliacoes.*', 'users.name')
                     ->join('users', 'users.id', 'avaliacoes.sender_id')
                     ->where('funcionario_id', $funcionario_id)
                     ->get();

        //Calcula a média 
        $media_geral = 0.00;
        foreach ($avaliacoes as $row) {
             $media = ($row->competencia_1 + $row->competencia_2 + $row->competencia_3 + $row->competencia_4 + $row->competencia_5 + $row->competencia_6 + $row->competencia_7 + $row->competencia_8 + $row->competencia_9) / 9;
             $media = number_format($media, 2, '.', '');
             $media_geral += number_format($media, 2, '.', '');
             $row->media = $media;
        }

        if(count($avaliacoes) >= 1) {
            $media_geral = number_format($media_geral / count($avaliacoes), 2);
        } else {
            $media_geral = $media_geral;
        }

        $commonDates = CommomDataService::getCommonDates($req);

        $data = [
            'avaliacoes' => $avaliacoes,
            'funcionario' => $funcionario,
            'funcionario_id' => $funcionario_id,
            'funcao_title' => $funcao_title,
            'media_geral' => $media_geral,
            ...$commonDates,
            'historico_action' => '/avaliacao'
        ];

        return view('pages.company.avaliacoes_funcionario', $data);
    }


    public function send_avaliacao(Request $req, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        Avaliacao::create([
            'company_id' => $company_id,
            'funcionario_id' => $funcionario_id,
            'message' => $req->message,
            'sender_id' => $req->user()->id,
            'sender_type' => 2, // 2 - Admin
            'competencia_1' => $req->competencia_1,
            'competencia_2' => $req->competencia_2,
            'competencia_3' => $req->competencia_3,
            'competencia_4' => $req->competencia_4,
            'competencia_5' => $req->competencia_5,
            'competencia_6' => $req->competencia_6,
            'competencia_7' => $req->competencia_7,
            'competencia_8' => $req->competencia_8,
            'competencia_9' => $req->competencia_9

        ]);
        Session::flash('success', "Avaliação registrada com sucesso!");
        return Redirect::back();
    }
}
