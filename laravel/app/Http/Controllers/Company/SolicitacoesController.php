<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use App\Models\Ferias;
use App\Models\Funcionario;
use App\Models\SolicitacaoHistorico;
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

        $historico = collect();
        if ($tipo === 'historico') {
            $historico = SolicitacaoHistorico::whereHas('funcionario', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
                ->when($funcionarioId, fn($q) => $q->where('funcionario_id', $funcionarioId))
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('pages.company.solicitacoes', [
            'solicitacoesFerias' => $solicitacoesFerias,
            'solicitacoesAbonos' => $solicitacoesAbonos,
            'historico' => $historico,
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

            SolicitacaoHistorico::create([
                'tipo' => 'ferias',
                'funcionario_id' => $solicitacao->funcionario_id,
                'acao' => 'aprovado',
                'anexo' => $solicitacao->file ? $solicitacao->path . '/' . $solicitacao->file : null,
                'start_date' => $solicitacao->startDate,
                'end_date' => $solicitacao->endDate,
            ]);

        } else {
            $solicitacao = Atestado::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 1;
            $solicitacao->save();

            // Registrar histórico
            SolicitacaoHistorico::create([
                'tipo' => 'abono',
                'funcionario_id' => $solicitacao->funcionario_id,
                'acao' => 'aprovado',
                'anexo' => $solicitacao->file ? $solicitacao->path . '/' . $solicitacao->file : null,
                'start_date' => $solicitacao->startDate,
                'end_date' => $solicitacao->endDate,
                'start_time' => $solicitacao->startTime,
                'end_time' => $solicitacao->endTime,
            ]);
        }
        return redirect()->back();
    }

    public function rejeitar(Request $req, $tipo, $id)
    {
        $companyId = $req->user()->company->id;

        if ($tipo === 'ferias') {
            $solicitacao = Ferias::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 'rejeitado';
            $solicitacao->save();

            SolicitacaoHistorico::create([
                'tipo' => 'ferias',
                'funcionario_id' => $solicitacao->funcionario_id,
                'acao' => 'rejeitado',
                'anexo' => $solicitacao->file ? $solicitacao->path . '/' . $solicitacao->file : null,
                'start_date' => $solicitacao->startDate,
                'end_date' => $solicitacao->endDate,
            ]);
        } else {
            $solicitacao = Atestado::where('company_id', $companyId)->findOrFail($id);
            $solicitacao->status = 2;
            $solicitacao->save();

            SolicitacaoHistorico::create([
                'tipo' => 'abono',
                'funcionario_id' => $solicitacao->funcionario_id,
                'acao' => 'rejeitado',
                'anexo' => $solicitacao->file ? $solicitacao->path . '/' . $solicitacao->file : null,
                'start_date' => $solicitacao->startDate,
                'end_date' => $solicitacao->endDate,
                'start_time' => $solicitacao->startTime,
                'end_time' => $solicitacao->endTime,
            ]);
        }

        return redirect()->back();
    }
}
