<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use App\Models\Ferias;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class SolicitacoesController extends Controller
{
    public function index(Request $req)
    {
        $companyId = $req->user()->company->id;
        $funcionarioId = $req->input('funcionario_id');
        $tipo = $req->input('tipo', 'ferias');

        // Carregar ambas as solicitações
        $solicitacoesFerias = Ferias::where('company_id', $companyId)
            ->when($funcionarioId, fn($q) => $q->where('funcionario_id', $funcionarioId))
            ->where('status', 'pendente')
            ->get();

        $solicitacoesAbonos = Atestado::where('company_id', $companyId)
            ->when($funcionarioId, fn($q) => $q->where('funcionario_id', $funcionarioId))
            ->where('status', 0)
            ->get();

        return view('pages.company.solicitacoes', [
            'solicitacoesFerias' => $solicitacoesFerias,
            'solicitacoesAbonos' => $solicitacoesAbonos,
            'funcionarios' => Funcionario::where('company_id', $companyId)->get(),
            'funcionarioId' => $funcionarioId,
            'tipo' => $tipo,
        ]);
    }

    public function aprovar(Request $req, $tipo, $id)
    {
        $companyId = $req->user()->company->id;

        if ($tipo === 'ferias') {
            $solicitacao = Ferias::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 'aprovado';
            $solicitacao->save();
        } else {
            $solicitacao = Atestado::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 1;
            $solicitacao->save();
        }
        return redirect()->back();
    }

    public function rejeitar(Request $req, $tipo, $id)
    {
        $companyId = $req->user()->company->id;

        if ($tipo === 'ferias') {
            $solicitacao = Ferias::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 'rejeitado';
        } else {
            $solicitacao = Atestado::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 2; // Defina um status para rejeitado (ajuste conforme seu modelo)
        }

        $solicitacao->save();
        return redirect()->back();
    }
}
