<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Notificacao;

class NotificacaoController extends Controller
{
    public function index()
    {
        // Validação do company_id
        $company_id = Auth::user()->company->id;
        $notificacoes = Notificacao::where('company_id', $company_id)
        ->where('read', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('notificacoes.index', [
            'notificacoes' => $notificacoes,
            'company_id' => $company_id,
            'company' => Auth::user()->company,
        ]);
    }

    public function getUltimasNotificacoes()
    {
        $notificacoes = Notificacao::where('company_id', Auth::user()->company->id)
            ->where('read', 0)
            ->with('funcionario')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('notificacoes.partials.list', [
            'notificacoes' => $notificacoes
        ]);
    }

    public function marcarComoLida($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $notificacao->read = 1;
        $notificacao->save();

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }

    public function home()
    {
        $company_id = Auth::user()->company->id;
        $notificacoes = Notificacao::where('company_id', $company_id)
            ->where('read', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gestor.home', [
            'notificacoes' => $notificacoes,
        ]);
    }
}
