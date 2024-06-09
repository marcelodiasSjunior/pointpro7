@extends('templates.worker')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Observações de Atividades</h1>
        <ul>
            <li>{{ $funcao_title }}</li>
            <li>Quantidade de observações por atividade</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">

                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Speach-Bubbles" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de observações das atividades
                    </h4>
                    <p class="">
                        Realize a gestão de informações para cada atividade sua:
                    </p>

                    @include('components.filtro')
                    <div class="tab-content" id="myIconTabContent" style="padding: 10px 0px 0px; display:block !important">
                        <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">

                            <div class="col-md-12 mt-3">
                                <div class=" text-start">
                                    <div class="">

                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped ">
                                                <thead style="text-align: center;">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col" style="min-width: 270px;">Atividade</th>
                                                        <th scope="col" style="min-width: 200px;">Última Interação</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Observações</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @foreach($atividades as $atividade)
                                                    <tr>
                                                        <th scope="row">{{ $atividade->id }}</th>
                                                        <td>{{ $atividade->atividade->description }}</td>

                                                        <td>
                                                            @if($atividade->observacoes->count() > 0)
                                                            {{ $atividade->observacoes[0]->sender->name }}
                                                            @else
                                                            Nenhuma mensagem enviada ou recebida
                                                            @endif
                                                        </td>
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
                                                                <span class="badge bg-danger">{{ $atividade->observacoes->count() }}</span>
                                                                <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                                            </a>
                                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                                <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{ $atividade->id}}">Observações da Atividade</a>
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
            </div>
        </div>

    </div>
    <!-- end of row -->
    <!-- ======= Main content end ======= -->
    @endsection