@extends('templates.company')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Atividades</h1>
        <ul>
            <li><a href="#">Atividades por funcionário</a></li>
            <li><a href="/funcoes">{{$funcao_title}}</a></li>
            <li class="remove-pd-xs">Funcionário: {{ $funcionario_name }}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de atividades <br><br>{{ $funcao_title}} - {{ $funcionario_name }}
                    </h4>

                    <!-- Botão Adicionar (mantido conforme original) -->
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon"><i class="i-Add"></i></span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item"
                                href="atividades-04-funcao-funcionario-atividades-add-edit.html">Adicionar nova
                                Atividade</a>
                        </div>
                    </div>

                    <p class="w-50">
                        Acompanhe o progresso das <code><b>atividades desempenhadas</b></code>:
                    </p>

                    @include('components.filtro')

                    <div class="tab-content" id="myIconTabContent" style="padding: 10px 0px 0px;">
                        <!-- Aba Atividades do Dia -->
                        <div class="tab-pane fade show active" id="homeIcon" role="tabpanel"
                            aria-labelledby="home-icon-tab">
                            <!-- Conteúdo original das atividades do dia -->
                            <div class="col-md-12 mt-3">
                                <div class="text-start">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <!-- Cabeçalho e corpo da tabela de atividades do dia -->
                                            @foreach($atividades as $atividade)
                                                <!-- Linhas das atividades -->
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nova Aba de Histórico -->
                        <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">
                            <div class="col-md-12 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Histórico Completo</h5>

                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th width="10%">ID</th>
                                                        <th width="35%">Atividade</th>
                                                        <th width="15%">Status</th>
                                                        <th width="20%">Data</th>
                                                        <th width="20%">Hora</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($historico as $registro)
                                                        <tr>
                                                            <td>#{{ $registro->id }}</td>
                                                            <td>{{ $registro->atividade->description ?? 'Atividade Removida' }}
                                                            </td>
                                                            <td>
                                                                @if($registro->status == 1)
                                                                    <span class="badge bg-success">Concluído</span>
                                                                @else
                                                                    <span class="badge bg-warning">Em Andamento</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $registro->dia->format('d/m/Y') }}</td>
                                                            <!-- Acesso direto à propriedade -->
                                                            <td>{{ $registro->created_at->format('H:i:s') }}</td>
                                                        </tr>
                                                    @empty {{-- This is crucial, even if you don't have anything to
                                                        display --}}
                                                        <tr>
                                                            <td colspan="5">Nenhum registro encontrado.</td> {{-- Or any
                                                            other message --}}
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        @if($historico->count() > 0)
                                            <div class="mt-3 text-end">
                                                <small class="text-muted">
                                                    Exibindo {{ $historico->count() }} registros
                                                </small>
                                            </div>
                                        @endif
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
<!-- ======= Main content end ======= -->
@endsection