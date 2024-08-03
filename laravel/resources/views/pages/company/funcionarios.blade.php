@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Funcionários</h1>
        <!--  <ul>
              <li><a href="">Dashboard</a></li>
              <li>Version 1</li>
            </ul> -->
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Administrator" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de funcionários
                    </h4>
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin: 0px 5px 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-Add"></i>
                            </span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="/funcionarios/adicionar-novo">Adicionar novo Funcionário</a>
                        </div>
                        <a class="btn btn-primary btn-icon" role="button" href="/funcionarios/exportPDF" target="_blank" style="margin: 0px 5px 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-File-Word" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Exportar PDF</span>
                        </a>
                        <a class="btn btn-primary btn-icon m-1" role="button" href="/funcionarios/exportXLS" target="_blank" style="margin: 0px 5px 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-File-Excel" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Exportar XLS</span>
                        </a>
                    </div>
                    <p class="w-50">
                        Realize a gestão do cadastro dos colaboradores <code><b>funcionários</b></code>:
                    </p>

                    @if($funcionarios->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" style="min-width: 165px;">Nome</th>
                                    <th scope="col" style="min-width: 114px;">Telefone</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col" style="min-width: 156px;">Função</th>
                                    <th scope="col" style="min-width: 75px;">Jornada</th>
                                    <th scope="col">Atividades</th>
                                    <th scope="col">Feedback</th>
                                    <th scope="col">Avaliação</th>
                                    <th scope="col">Frequência</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Apagar</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach($funcionarios as $funcionario)
                                <tr>
                                    <th scope="row">{{ $funcionario->id }}</th>
                                    <td>{{ $funcionario->user->name }}</td>
                                    <td>{{ $funcionario->celular }}</td>
                                    <td>{{ $funcionario->user->email }}</td>
                                    <td>{{ $funcionario->funcao->title }}</td>
                                    <td>{{ $funcionario->jornada->total_semanal }}</td>
                                    <td>{{ $funcionario->qtdAtividades }}</td>
                                    <td><a class="text-primary " style="font-size: 23px;" href="/feedback/funcionario/{{ $funcionario->id }}">
                                            <i class="nav-icon i-Letter-Open fw-bold"></i></a>
                                    </td>
                                    <td><a class="text-primary" style="font-size: 23px;" href="/avaliacoes/funcionario/{{ $funcionario->id }}">
                                            <i class="nav-icon i-ID-Card fw-bold"></i></a>
                                    </td>
                                    <td><a class="text-primary" style="font-size: 23px;" href="/frequencia/{{ $funcionario->id }}">
                                            <i class="nav-icon i-Stopwatch fw-bold"></i></a>
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-primary" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Eye fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/funcionarios/{{ $funcionario->id }}/ver">Ver</a>
                                        </div>
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-warning" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Pen-5 fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/funcionarios/{{ $funcionario->id }}/editar">Editar</a>
                                        </div>
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-danger" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Close-Window fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/funcionarios/{{ $funcionario->id }}/deletar">Apagar</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-dismissible fade show alert-card alert-info" role="alert">
                        <strong class="text-capitalize">Nenhum funcionário cadastrado!</strong>
                    </div>
                    @endif


                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->
@endsection