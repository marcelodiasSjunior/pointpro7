@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Atividades</h1>
        <ul>
            <li><a href="/atividades">Progresso por Funções</a></li>
            <li>{{$funcao_title}}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3  w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de atividades <br><br>{{$funcao_title}}
                    </h4>
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon"><i class="i-Add"></i></span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="/atividades/adicionar-nova">Adicionar nova Atividade</a>
                        </div>
                    </div>
                    <p class="w-50">
                        Acompanhe o progresso das <code><b>atividades por funcionário</b></code>:
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
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Progresso das Atividades</th>
                                                        <th scope="col">Atividades</th>
                                                        <th scope="col">Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @foreach($funcionarios as $funcionario)
                                                    @if($funcionario->atividades > 0)
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
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Ver
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <li><a class="dropdown-item" href="/atividades/funcionario/{{ $funcionario->id }}">Ver atividades do dia</a></li>
                                                                    <li><a class="dropdown-item" href="/atividades/funcionario/todas/{{ $funcionario->id }}">Ver todas</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
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
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->


@endsection
