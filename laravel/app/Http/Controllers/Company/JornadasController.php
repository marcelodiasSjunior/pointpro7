<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\JornadaSaveRequest;
use App\Http\Requests\JornadaUpdateRequest;
use App\Models\Funcionario;
use App\Models\Jornada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class JornadasController extends Controller
{
    public function index(Request $req)
    {
        $jornadas = Jornada::where('company_id', $req->user()->company->id)->where('status', 1)->get();

        return view('pages.company.jornadas', ['jornadas' => $jornadas]);
    }

    public function delete($id, Request $req)
    {
        $userWithJornada = Funcionario::where(['jornada_id' => $id, 'company_id' => $req->user()->company->id])->get();
        $jornadasCompany = Jornada::where(['company_id' => $req->user()->company->id])->where('status', 1)->get();

        if ($jornadasCompany->count() <= 1) {
            return Redirect::back()->withErrors(['msg' => 'A empresa possui apenas uma jornada cadastrada. Crie uma nova e mova os funcionários antes de deletar essa jornada!']);
        } elseif ($userWithJornada->count() > 0) {
            return Redirect::back()->withErrors(['msg' => 'Essa jornada possui funcionários cadastrados, mova os funcionários ativos para outra jornada.']);
        }

        Jornada::where(['id' => $id, 'company_id' => $req->user()->company->id])->update(['status' => 0]);

        Session::flash('success', "Jornada inativada com sucesso!");
        return Redirect::back();
    }

    public function create()
    {
        return view('pages.company.criar_jornada');
    }

    public function save(JornadaSaveRequest $req)
    {
        $data = $req->only([
            'title',
            'segunda',
            'terca',
            'quarta',
            'quinta',
            'sexta',
            'sabado',
            'domingo',
        ]);

        $data['description'] = sprintf(
            "Segunda %s hora(s), Terca %s hora(s), Quarta %s hora(s), Quinta %s hora(s), Sexta %s hora(s), Sabado %s, Domingo %s hora(s)",
            $req->segunda,
            $req->terca,
            $req->quarta,
            $req->quinta,
            $req->sexta,
            $req->sabado,
            $req->domingo
        );

        $data['company_id'] = $req->user()->company->id;

        Jornada::create($data);

        Session::flash('success', "Jornada criada com sucesso");
        return redirect('/jornadas');
    }

    public function edit($id, Request $req)
    {
        $jornada = Jornada::where(['id' => $id, 'company_id' => $req->user()->company->id])->first();

        return view('pages.company.editar_jornada', ['jornada' => $jornada]);
    }

    public function update($id, JornadaUpdateRequest $req)
    {
        $data = $req->only([
            'title',
            'segunda',
            'terca',
            'quarta',
            'quinta',
            'sexta',
            'sabado',
            'domingo'
        ]);

        $data['description'] = sprintf(
            "Segunda %s hora(s), Terca %s hora(s), Quarta %s hora(s), Quinta %s hora(s), Sexta %s hora(s), Sabado %s, Domingo %s hora(s)",
            $req->segunda,
            $req->terca,
            $req->quarta,
            $req->quinta,
            $req->sexta,
            $req->sabado,
            $req->domingo
        );

        $data['company_id'] = $req->user()->company->id;

        Jornada::where(['id' => $id, 'company_id' => $req->user()->company->id])
            ->update($data);

        Session::flash('success', "Jornada atualizada com sucesso!");
        return redirect('/jornadas');
    }
}
