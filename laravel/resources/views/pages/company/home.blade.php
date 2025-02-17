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
    <!-- end of main-content -->
</div>



@endsection