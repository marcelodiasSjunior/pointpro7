@extends('templates.company')
@section('content')




<!-- ============ Body content start ============= -->
<!--  INDICADORES NO PAINEL  -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Painel Administrativo</h1>
        <!--  <ul>
              <li><a href="">Dashboard</a></li>
              <li>Version 1</li>
            </ul> -->
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 col-lg-12" style="margin-bottom: 40px;">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Administrator text-success"></i>
                                <h3 class="t-font-boldest">{{ $total_funcionarios}}</h3>
                                <span>Funcionários</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Check text-primary"></i>
                                <h3 class="t-font-boldest">{{ $total_atividades }}</h3>
                                <span>Atividades</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Speach-Bubbles" style="color:#05a4e3;"></i>
                                <h3 class="t-font-boldest">{{ $total_observacoes }}</h3>
                                <span>Observações</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Library text-warning"></i>
                                <h3 class="t-font-boldest">{{ $total_funcoes }}</h3>
                                <span>Funções</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Calendar text-danger"></i>
                                <h3 class="t-font-boldest">{{ $total_jornadas}}</h3>
                                <span>Jornadas</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                @if(Auth::user()->company->logo)
                                <div class="logo-empresa"><img src=" {{ Auth::user()->company->logo }}" alt=""></div>
                                @else
                                <div style="height: 64px; width: 64px"></div>
                                @endif

                                <h3 class="t-font-boldest">{{ Auth::user()->company->title }}</h3>
                                <span>{{ Auth::user()->company->seguimento }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ATIVIDADES NO PAINEL -->
    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3 w-50 float-start ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Atividades
                            </h4>
                            <div class="text-end mb-3  w-50 float-end">
                                <a class="btn btn-primary btn-icon m-1" role="button" href="/atividades">
                                    <span class="ul-btn__icon">
                                        <i class="i-Eye" style="font-size: 18px;"></i>
                                    </span>
                                    <span class="ul-btn__text"> Ver completo</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">

                            <p class="">
                                Acompanhe o progresso das <br><code><b>atividades por função</b></code>:
                            </p>
                            @include('components.filtro')
                            <div class="tab-content" id="myIconTabContent" style="padding: 10px 0px 0px;">
                                <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">
                                    <div class="col-md-12 mt-3">
                                        <div class=" text-start">
                                            <div class="">

                                                <div class="table-responsive">
                                                    <table class="table table-hover table-striped ">
                                                        <thead style="text-align: center;">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col" style="min-width: 150px;">Função</th>
                                                                <th scope="col" style="min-width: 200px;">Progresso das Atividades</th>
                                                                <th scope="col">Atividades</th>
                                                                <th scope="col">Funcionários</th>
                                                                <th scope="col">Ver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="text-align: center;">
                                                            @foreach($funcoes as $funcao)
                                                            <tr>
                                                                <th scope="row">{{ $funcao->id }}</th>
                                                                <td>{{ $funcao->title }}</td>
                                                                <td>
                                                                    <div class="progress mb-3">
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $funcao->porcentagem_completas }}%" aria-valuenow="{{ $funcao->porcentagem_completas }}" aria-valuemin="0" aria-valuemax="100">
                                                                            {{ $funcao->porcentagem_completas }}%
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $funcao->atividades->count() }}</td>
                                                                <td>{{ $funcao->total_funcionarios }}</td>
                                                                <td>
                                                                    <a class="text-primary me-2" style="font-size: 23px;" href="/atividades/funcao/{{ $funcao->id }}">
                                                                        <i class="nav-icon i-Eye fw-bold"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">

                            <p class="">
                                Acompanhe o progresso das <br><code><b>atividades por funcionário</b></code>:
                            </p>
                            @include('components.filtro')
                            <div class="tab-content" id="myIconTabContent" style="padding: 10px 0px 0px;">
                                <div class="tab-pane fade show active" id="hoje-tarefa" role="tabpanel" aria-labelledby="hoje-tarefa-tab">
                                    <div class="col-md-12 mt-3">
                                        <div class=" text-start">
                                            <div class="">

                                                <div class="table-responsive">
                                                    <table class="table table-hover table-striped ">
                                                        <thead style="text-align: center;">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col" style="min-width: 260px;">Funcionário</th>
                                                                <th scope="col" style="min-width: 200px;">Progresso das Atividades</th>
                                                                <th scope="col">Atividades</th>
                                                                <th scope="col">Ver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="text-align: center;">
                                                            @foreach($funcionarios as $funcionario)
                                                            <tr>
                                                                <th scope="row">#{{ $funcionario->id }}</th>
                                                                <td>{{ $funcionario->user->name }}</td>
                                                                <td>
                                                                    <div class="progress mb-3">
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $funcionario->porcentagem_completas }}%" aria-valuenow="{{ $funcionario->porcentagem_completas }}" aria-valuemin="0" aria-valuemax="100">
                                                                            {{ $funcionario->porcentagem_completas }}%
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $funcionario->atividades }}</td>
                                                                <td>
                                                                    <a class="text-primary me-2" style="font-size: 23px;" href="/atividades/funcionario/{{ $funcionario->id }}">
                                                                        <i class="nav-icon i-Eye fw-bold"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>







    <!-- OBSERVAÇÕES DE ATIVIDADES NO PAINEL -->
    <div class="row">

        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3 w-50 float-start ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Speach-Bubbles" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Observações de Atividades
                            </h4>
                            <div class="text-end w-50 float-end">
                                <a class="btn btn-primary btn-icon m-1" role="button" href="/observacoes">
                                    <span class="ul-btn__icon">
                                        <i class="i-Eye" style="font-size: 18px;"></i>
                                    </span>
                                    <span class="ul-btn__text"> Ver completo</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <p class="">
                                Acompanhe as anotações e <br><code><b>observações das atividades</b></code>:
                            </p>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped ">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Função</th>
                                            <th scope="col">Funcionário</th>
                                            <th scope="col">Atividade</th>
                                            <th scope="col">Última Interação</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        @foreach($atividades as $atividade)
                                        <tr>
                                        <th scope="row">{{ $atividade->id }}</th>
                                            <td>{{ $atividade->funcao_title }}</td>
                                            <td>{{ $atividade->user_name }}</td>
                                            <td>{{ $atividade->description }}</td>
                                            <td>
                                                @if($atividade->observacao)
                                                {{ $atividade->observacao }}
                                                @else 
                                                Nenhuma mensagem enviada ou recebida
                                                @endif
                                            </td>
                                            <td>{{ $dayOfWeekHuman }}</td>
                                            <td>
                                                @if($atividade->funcionario_atividade !== 0 && $atividade->funcionario_atividade !== 1)
                                                <span class="badge bg-danger">Não realizado</span>
                                                @elseif($atividade->funcionario_atividade == 0)
                                                <span class="badge bg-warning">Em andamento</span>
                                                @elseif($atividade->funcionario_atividade == 1)
                                                <span class="badge bg-success">Concluído</span>
                                                @endif
                                            </td>
                                            <td style="padding-bottom: 3px;">
                                                <a class="text-primary badge-top-container" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                    <span class="badge bg-danger">{{ $atividade->observacao_count }}</span>
                                                    <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                                </a>
                                                <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                    <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{ $atividade->id }}/{{ $atividade->funcionario_id }}">Observações da Atividade</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- FREQUÊNCIA NO PAINEL -->
    <div class="row">

        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Stopwatch" style="font-size: 28px;margin-right: 8px;"></i>
                        </span> Frequência
                    </h4>
                    <div class="text-end w-50 float-end">
                        <a class="btn btn-primary btn-icon m-1" role="button" href="/frequencia">
                            <span class="ul-btn__icon">
                                <i class="i-Eye" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Ver completo</span>
                        </a>
                    </div>
                    <p class="w-50">
                        Acompanhe a <br><code><b>frequência de presença</b></code>:
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped ">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" style="min-width: 200px;">Nome</th>
                                    <th scope="col">Função</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Anexo</th>
                                    <th scope="col">Frequência</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach($frequencias as $frequencia)
                                <tr>
                                    <th scope="row">{{ $frequencia->id}}</th>
                                    <td>{{ $frequencia->name }}</td>
                                    <td>{{ $frequencia->funcao_title }}</td>
                                    <td>{{ $frequencia->ponto ? date("d/m/Y", strtotime($frequencia->ponto)) : '-' }}
                                    <td>
                                        @if($frequencia->ponto)
                                        <span class="badge bg-success">Compareceu</span>
                                        @elseif($frequencia->ferias)
                                        <span class="badge bg-warning">Férias</span>
                                        @else
                                        <span class="badge bg-danger">Não compareceu</span>
                                        @endif
                                    </td>
                                    <td>-</td>
                                    <td style="padding:4px 5px 0px;">
                                        <a class="text-primary" style="font-size: 26px;" href="/frequencia/{{ $frequencia->funcionario_id }}">
                                            <i class="nav-icon i-Stopwatch fw-bold"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- DIVISOR FEEDBACK E AVALIAÇÃO NO PAINEL -->
    <div class="row">
        <div class="col-md-12 col-lg-12 mt-4 mb-4">
            <div class="">
                <div class="card-body" style="background-color: #e5e7eb;padding: 1.25rem;border-radius: 10px;">
                    <div class="row">
                        <div class="col-md-6" style="text-align:center;">
                            <p style="margin-bottom:8px;">
                                <strong>Feedback</strong>
                            </p>
                            <p style="margin-bottom:8px;">
                                Acompanhe o Feedback das reuniões colaborativas.
                                <sunt></sunt>
                            </p>
                            <div class="" style="padding:3px 0px 0px;">
                                <a style="margin: 0px 0px 15px;width: 50%;" class="btn btn-primary text-white btn-rounded btn-icon" href="/funcionarios">
                                    <span class="ul-btn__icon">
                                        <i class="i-Letter-Open" style="font-size: 18px;"></i>
                                    </span>
                                    <span class="ul-btn__text"> <b>FEEDBACK</b></span>
                                </a>
                            </div>
                        </div>

                        <div class="row visible-xs-768">
                            <div class="col-md-2 form-group mb-3"></div>
                            <div class="col-md-8 form-group mb-3">
                                <div class="mt-3 mb-4 border-top"></div>
                            </div>
                            <div class="col-md-2 form-group mb-3"></div>
                        </div>

                        <div class="col-md-6 " style="text-align:center;">
                            <p style="margin-bottom:8px;">
                                <strong>Avaliações</strong>
                            </p>
                            <p style="margin-bottom:8px;">
                                Realize avaliações de desempenho dos funcionários.
                                <sunt></sunt>
                            </p>
                            <div class="" style="padding:3px 0px 0px;">
                                <a style="margin: 0px 0px 15px;width: 50%;" class="btn btn-primary text-white btn-rounded btn-icon" href="/funcionarios">
                                    <span class="ul-btn__icon">
                                        <i class="i-Target" style="font-size: 18px;"></i>
                                    </span>
                                    <span class="ul-btn__text"> <b>AVALIAÇÕES</b></span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>












    <!-- STATUS DE 7 DIAS NO PAINEL -->
    <div class="row">
        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body" style="">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Status Atividades
                    </h4>
                    <p>
                        Acompanhe o status das <code><b>atividades</b></code>:
                    </p>

                    <div class="">
                        <div class="filtro-status titulo-filtro-status">
                            Filtro:
                        </div><br class="visible-xs">
                        <div class="filtro-status">
                            <label class="radio radio-secondary">
                                <input type="radio" name="radio-status-atividade" value="0" checked />
                                <span>Todos</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="filtro-status">
                            <label class="radio radio-danger">
                                <input type="radio" name="radio-status-atividade" value="0" />
                                <span>Não realizado</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="filtro-status">
                            <label class="radio radio-warning">
                                <input type="radio" name="radio-status-atividade" value="0" />
                                <span>Em andamento</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="filtro-status">
                            <label class="radio radio-success">
                                <input type="radio" name="radio-status-atividade" value="0" />
                                <span>Concluído</span>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped ">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Atividade</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Observações</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach($atividades_detalhes as $fa)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <div class="encurta-texto-2">
                                            {{ $fa->atividadeFuncionario->atividade->description }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="encurta-texto-2">{{ $fa->atividadeFuncionario->funcionario->user->name }}</div>
                                    </td>
                                    <td>{{ $fa->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($fa->status === 0)
                                        <span class="badge bg-warning">Em andamento</span>
                                        @endif

                                        @if($fa->status === 1)
                                        <span class="badge bg-success">Concluído</span>
                                        @endif
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-primary badge-top-container" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                            <span class="badge bg-danger">
                                                {{ $fa->atividadeFuncionario->observacoes->count() }}
                                            </span>
                                            <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{ $fa->id }}/{{ $fa->atividadeFuncionario->funcionario->id }} ">Observações da atividade</a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        <div class="paginacao-fixa-no-canto">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled ">
                                        <a class="page-link">Anterior</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="/atividades">1</a>
                                    </li>
                                    <li class="page-item " aria-current="page">
                                        <a class="page-link" href="/atividades">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="/atividades">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="/atividades">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="/atividades">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="/atividades">Próximo</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>







    <!-- DIVISOR SUPORTE NO PAINEL -->
    <div class="row">
        <div class="col-md-12 col-lg-12 mt-4 mb-4">
            <div class="">
                <div class="card-body" style="background-color: #e5e7eb;padding: 1.25rem;border-radius: 10px;">
                    <div class="row">
                        <div class="col-md-9">
                            <p>
                                <strong>Suporte técnico</strong>
                            </p>
                            <p>
                                Nosso equipe está sempre à disposição para iniciar um atendimento imediato e esclarecer todas as suas dúvidas sobre a usabilidade do sistema de acompanhamento de funcionários. Uma equipe especializada e pronta para ajudar, você pode contar conosco para resolver seus problemas e garantir que sua experiência seja perfeita. Não hesite em nos contatar quando precisar, estamos aqui para você!
                                <sunt></sunt>
                            </p>
                        </div>
                        <div class="col-md-3" style="text-align: center;padding: 25px 10px 0px;">
                            <a style="margin: 15px 0px 15px;width: 80%;" class="btn btn-primary text-white btn-rounded btn-icon" href="/suporte">
                                <span class="ul-btn__icon">
                                    <i class="i-Support" style="font-size: 18px;"></i>
                                </span>
                                <span class="ul-btn__text"> <b>SUPORTE</b></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FUNÇÕES NO PAINEL -->
    <div class="row">

        <div class="col-md-6 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Library" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Funções
                    </h4>
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-Add"></i>
                            </span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="/funcoes/adicionar-nova">Adicionar nova Função</a>
                        </div>
                        <a class="btn btn-primary btn-icon" role="button" href="/funcoes" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-Eye" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Ver todas</span>
                        </a>
                    </div>
                    <p class="w-50" style="margin-bottom: 25px;">
                        Gerenciar cadastro de cargos e funções:
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped ">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Função</th>
                                    <th scope="col">Atividades</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Apagar</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach($funcoes_list as $funcao)
                                <tr>
                                    <th scope="row">{{ $funcao->id }}</th>
                                    <td>{{ $funcao->title }}</td>
                                    <td>{{ $funcao->atividades->count() }}</td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-warning me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Pen-5 fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/funcoes/{{ $funcao->id }}/editar">Editar</a>
                                        </div>
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-danger me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Close-Window fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/funcoes/{{ $funcao->id }}/deletar">Apagar</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Calendar" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Jornadas
                    </h4>
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px;">
                            <span class="ul-btn__icon">
                                <i class="i-Add"></i>
                            </span>
                            <span class="ul-btn__text">Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="/jornadas/adicionar-nova">Adicionar nova Jornada</a>
                        </div>
                        <a class="btn btn-primary btn-icon" role="button" href="/jornadas" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-Eye" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Ver todas</span>
                        </a>
                    </div>
                    <p class="w-50" style="margin-bottom: 25px;">
                        Gerenciar cadastro <br class="visible-xs">de jornadas:
                    </p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped ">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome da Jornada</th>
                                    <th scope="col">Descrição da Jornada</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Apagar</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach($jornadas as $jornada)
                                <tr>
                                    <th scope="row">{{ $jornada->id }}</th>
                                    <td>{{ $jornada->title }}</td>
                                    <td>{{ $jornada->description }}</td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-warning me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Pen-5 fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/jornadas/{{ $jornada->id}}/editar">Editar</a>
                                        </div>
                                    </td>
                                    <td style="padding-bottom: 3px;">
                                        <a class="text-danger me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon i-Close-Window fw-bold"></i>
                                        </a>
                                        <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                            <a class="dropdown-item ul-widget__link--font" href="/jornadas/{{ $jornada->id}}/deletar">Apagar</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <div>
                        <h4 class="card-title mb-3 w-50 float-start ">
                            <span class="text-primary" style="vertical-align: middle;">
                                <i class="i-Administrator" style="font-size: 26px;margin-right: 8px;"></i>
                            </span> Funcionários
                        </h4>

                        <div class="dropdown dropleft text-end w-50 float-end">
                            <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px;">
                                <span class="ul-btn__icon">
                                    <i class="i-Add"></i>
                                </span>
                                <span class="ul-btn__text">Adicionar</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                                <a class="dropdown-item" href="/funcionarios/adicionar-novo">Adicionar novo Funcionário</a>
                            </div>
                            <a class="btn btn-primary btn-icon" role="button" href="/funcionarios" style="width: 111px;margin-bottom: 10px;">
                                <span class="ul-btn__icon">
                                    <i class="i-Eye" style="font-size: 18px;"></i>
                                </span>
                                <span class="ul-btn__text"> Ver todos</span>
                            </a>
                        </div>
                        <p class="w-50" style="margin-bottom: 25px;">
                            Gerenciar cadastro de funcionários:
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped ">
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
                                    <td>{{ $funcionario->atividades_count() }}</td>
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
                </div>
            </div>
        </div>

    </div>


    <!-- end of main-content -->
</div>



@endsection