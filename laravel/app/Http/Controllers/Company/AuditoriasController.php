<?php

namespace App\Http\Controllers\Company;

use App\Exports\AuditoriasExport;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class AuditoriasController extends Controller
{
    public function exportXLS(Request $req, $funcionario_id, $ano, $mes) {
        $company_id = $req->user()->company->id;
        $func = Funcionario::where('id', $funcionario_id)->first();
        $nomeFuncionario = $func->user->name;
        return Excel::download(new AuditoriasExport($company_id, $funcionario_id, $ano, $mes), $nomeFuncionario.'-auditoria.xlsx');
    }
}
