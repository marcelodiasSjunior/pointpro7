<?php

namespace App\Http\Controllers\Company;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\FuncionarioSaveRequest;
use App\Http\Requests\FuncionarioUpdateRequest;
use App\Http\Services\CityService;
use App\Models\AtividadeFuncionario;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Jornada;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FuncionariosController extends Controller
{
    public function index(Request $req)
    {
        $funcionarios = Funcionario::where('company_id', $req->user()->company->id)->get();

        foreach($funcionarios as $row) {
            $row->qtdAtividades = AtividadeFuncionario::where('funcionario_id', $row->id)->where('status', 1)->count();
        }

        return view('pages.company.funcionarios', ['funcionarios' => $funcionarios]);
    }

    public function delete($id, Request $req)
    {
        $funcionario = Funcionario::where('company_id', $req->user()->company->id)->where('id', $id)->first();
        $user = User::where('id', $funcionario->user_id)->first();

        $funcionario->delete();
        $user->delete();

        Session::flash('success', "Funcionário excluído com sucesso!");
        return redirect('/funcionarios');
    }

    public function create(Request $req)
    {
        $data = [
            'funcoes' => Funcao::where(['company_id' => $req->user()->company->id])->where('status', 1)->get(),
            'jornadas' => Jornada::where(['company_id' => $req->user()->company->id])->where('status', 1)->get(),
            'states' => CityService::getStates()
        ];
        return view('pages.company.criar_funcionario', $data);
    }

    public function save(FuncionarioSaveRequest $req)
    {
        $data = $req->only([
            'jornada_id',
            'funcao_id',
            'nascimento',
            'admission_date',
            'celular',
            'cpf',
            'rg',
            'rg_emissor',
            'rg_emissao',
            'sexo',
            'nis',
            'nome_pai',
            'nome_mae',
            'titulo_eleitoral',
            'zona_eleitoral',
            'secao_eleitoral',
            'carteira_reservista',
            'serie_reservista',
            'telefone',
            'estado_civil',
            'grau_instrucao',
            'comorbidade',
            'cnh_numero',
            'cnh_categoria',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id',
            'comorbidade',
            'workHome'
        ]);

        if ($req->comorbidade) {
            $data['comorbidade'] = implode(",", $req->comorbidade);
        }

        if($req->foto) {
            $user = User::create([
                'email' => $req->email,
                'name' => $req->name,
                'password' => bcrypt($req->password),
                'role' => 3,
                'avatar' => $req->foto
            ]);

        } else {
            $user = User::create([
                'email' => $req->email,
                'name' => $req->name,
                'password' => bcrypt($req->password),
                'role' => 3
            ]);

        }


        $data['company_id'] = $req->user()->company->id;
        $data['user_id'] = $user->id;

        Funcionario::create($data);

        Session::flash('success', "Funcionário cadastrado com sucesso!");
        return redirect('/funcionarios');
    }

    public function ver($id, Request $req)
    {
        $funcionario = Funcionario::where(['id' => $id, 'company_id' => $req->user()->company->id])->first();

        return view('pages.company.ver_funcionario', ['funcionario' => $funcionario]);
    }

    public function edit($id, Request $req)
    {
        $funcionario = Funcionario::where(['id' => $id, 'company_id' => $req->user()->company->id])->first();
        $data = [
            'funcionario' => $funcionario,
            'funcoes' => Funcao::where(['company_id' => $req->user()->company->id])->where('status', 1)->get(),
            'jornadas' => Jornada::where(['company_id' => $req->user()->company->id])->where('status', 1)->get(),
            'states' => CityService::getStates(),
            'cities' => $funcionario->state_id ? CityService::getCities($funcionario->state_id) : []
        ];

        return view('pages.company.editar_funcionario', $data);
    }

    public function update($id, FuncionarioUpdateRequest $req)
    {
        $funcionario = Funcionario::where(['id' => $id, 'company_id' => $req->user()->company->id])->first();

        $data = $req->only([
            'jornada_id',
            'funcao_id',
            'nascimento',
            'admission_date',
            'celular',
            'cpf',
            'rg',
            'rg_emissor',
            'rg_emissao',
            'sexo',
            'nis',
            'nome_pai',
            'nome_mae',
            'titulo_eleitoral',
            'zona_eleitoral',
            'secao_eleitoral',
            'carteira_reservista',
            'serie_reservista',
            'telefone',
            'estado_civil',
            'grau_instrucao',
            'comorbidade',
            'cnh_numero',
            'cnh_categoria',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id',
            'workHome'
        ]);

        if ($req->comorbidade) {
            $data['comorbidade'] = implode(",", $req->comorbidade);
        }

        if ($req->foto) {
            $user = User::find($funcionario->user_id);
            $user->avatar = $req->foto;
            $user->save();
            $data['foto'] = $req->foto;
        } else {
            $user = User::find($funcionario->user_id);
            $user->save();
        }

        if ($req->email) {
            $userWithEmailExists = User::where('email', $req->email)->where('id', '!=', $funcionario->user_id)->first();
            if (!$userWithEmailExists) {
                User::where('id', $funcionario->user_id)->update([
                    'email' => $req->email
                ]);
            } else {
                return Redirect::back()->withErrors(['msg' => 'Ja existe outro usuario com esse email']);
            }
        }

        if ($req->password) {
            User::where('id', $funcionario->user_id)->update([
                'password' => bcrypt($req->password)
            ]);
        }

        User::where('id', $funcionario->user_id)->update([
            'name' => $req->name
        ]);
        Funcionario::where(['id' => $id, 'company_id' => $req->user()->company->id])
            ->update($data);

        Session::flash('success', "Funcionário atualizado com sucesso!");
        return redirect('/funcionarios');
    }

    public function exportPDF(Request $req) {

        $funcionarios = Funcionario::where('company_id', $req->user()->company->id)->get();

        $pdf = App::make('dompdf.wrapper');
        $html = "";

        $html .= "<h1>Listagem de funcionários</h1>
                        <div class='table-responsive'>
                            <table class='table table-hover table-striped ' border='1' style='font-size: 12px;width: 100%;'>
                                <thead style='text-align: center;'>
                                    <tr>
                                        <th scope='col'>ID</th>
                                        <th scope='col' width: 100%>Nome</th>
                                        <th scope='col'>Celular</th>
                                        <th scope='col'>E-mail</th>
                                        <th scope='col'>Função</th>
                                        <th scope='col'>Jornada</th>
                                        <th scope='col'>Atividades</th>
                                    </tr>
                                </thead>
                                <tbody style='text-align: center;'>";
         foreach($funcionarios as $row) {

            $qtdAtividades = AtividadeFuncionario::where('funcionario_id', $row->id)
                             ->where('status', 1)
                             ->count();


            $html .= "<tr>
            <th scope='row'>" . $row->id . "</th>
            <th scope='row'>" . $row->user->name . "</th>
            <th scope='row'>" . $row->celular. "</th>
            <th scope='row'>" . $row->user->email . "</th>
            <th scope='row'>" . $row->funcao->title . "</th>
            <th scope='row'>" . $row->jornada->total_semanal . "</th>
            <th scope='row'>" . $qtdAtividades . "</th>
            </tr>";
         }


        $html .= "</tbody>
                    </table>
                  </div>";

        $pdf->loadHTML($html);

        return $pdf->stream();

    }

    public function exportXLS(Request $request)
    {
        return Excel::download(new EmployeesExport($request->user()->company->id), 'Relação de Funcionários.xlsx');
    }


}
