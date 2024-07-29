<?php

namespace App\Http\Controllers\Company;

use App\Exports\AuditoriasExport;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Auditoria;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class AuditoriasController extends Controller
{
    public function exportXLS(Request $req, $funcionario_id, $ano, $mes)
    {
        $company_id = $req->user()->company->id;
        $func = Funcionario::where('id', $funcionario_id)->first();
        $nomeFuncionario = $func->user->name;
        return Excel::download(new AuditoriasExport($company_id, $funcionario_id, $ano, $mes), $nomeFuncionario . '-auditoria.xlsx');
    }

    public function historico($funcionario_id, $ano, $mes)
{
    $mesAno = $ano . '-' . str_pad($mes, 2, '0', STR_PAD_LEFT);

    $auditorias = Auditoria::where('company_id', auth()->user()->company_id)
        ->where('funcionario_id', $funcionario_id)
        ->where('acao', 'like', '%' . $mesAno . '%')
        ->get(['id', 'acao', 'created_at']);

    return view('auditoria.historico', compact('auditorias'));
}


}