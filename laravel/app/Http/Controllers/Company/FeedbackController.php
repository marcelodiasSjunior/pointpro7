<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use App\Models\Feedback;
use App\Models\Funcao;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    public function listar(Request $req, $funcionario_id)
    {
        $company_id = $req->user()->company->id;
        $funcao_id = Funcionario::where('id', $funcionario_id)->value('funcao_id');
        $funcao_title = Funcao::where('id', $funcao_id)->value('title');
        
        $feedbacks = DB::table('feedback')
                     ->select('feedback.*', 'users.name')
                     ->join('users', 'users.id', 'feedback.sender_id')
                     ->where('funcionario_id', $funcionario_id)
                     ->get();
        $commonDates = CommomDataService::getCommonDates($req);

        $data = [
            'feedbacks' => $feedbacks,
            'funcionario_id' => $funcionario_id,
            'funcao_title' => $funcao_title,
            ...$commonDates,
            'historico_action' => '/feedback'
        ];

        return view('pages.company.feedback', $data);
    }


    public function send_message(Request $req, $funcionario_id)
    {
        $company_id = $req->user()->company->id;

        Feedback::create([
            'company_id' => $company_id,
            'funcionario_id' => $funcionario_id,
            'message' => $req->message,
            'sender_id' => $req->user()->id,
            'sender_type' => 2 // 2 - Admin / 1 - Funcionario

        ]);
        Session::flash('success', "Feedback foi registrado com sucesso!");
        return Redirect::back();
    }
}
