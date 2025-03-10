@extends('templates.company')
@section('content')

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="me-2">Solicitações</h1>
        <ul>
            <li>Pendentes</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        Solicitações Pendentes
                    </h4>

                    <!-- Tabs para Férias/Abonos -->
                    <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $tipo === 'ferias' ? 'active' : '' }}" href="?tipo=ferias">
            Férias ({{ $solicitacoesFerias->count() }})
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tipo === 'abonos' ? 'active' : '' }}" href="?tipo=abonos">
            Abonos ({{ $solicitacoesAbonos->count() }})
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tipo === 'historico' ? 'active' : '' }}" href="?tipo=historico">
            Histórico
        </a>
    </li>
</ul>

                    <!-- Filtro por Funcionário -->
                    <form method="GET" class="mt-3">
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label>Filtrar por Funcionário:</label>
                                <select name="funcionario_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Todos os Funcionários</option>
                                    @foreach($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" 
                                        {{ $funcionarioId == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- Conteúdo das Tabs -->
                    <div class="tab-content mt-3">
                        <!-- Tab Férias -->
                        <div class="tab-pane {{ $tipo === 'ferias' ? 'show active' : '' }}">
                            @if($solicitacoesFerias->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Funcionário</th>
                                                <th>Período</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitacoesFerias as $ferias)
                                            <tr>
                                                <td>{{ $ferias->funcionario->user->name }}</td>
                                                <td>{{ date('d/m/Y', strtotime($ferias->startDate)) }} - {{ date('d/m/Y', strtotime($ferias->endDate)) }}</td>
                                                <td>
                                                    <a href="{{ route('solicitacoes.aprovar', parameters: ['tipo' => 'ferias', 'id' => $ferias->id]) }}" class="btn btn-sm btn-primary">Aprovar</a>
                                                    <a href="{{ route('solicitacoes.rejeitar', ['tipo' => 'ferias', 'id' => $ferias->id]) }}" class="btn btn-sm btn-danger">Recusar</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    Nenhuma solicitação de férias pendente.
                                </div>
                            @endif
                        </div>

                        <!-- Tab Abonos -->
                        <div class="tab-pane {{ $tipo === 'abonos' ? 'show active' : '' }}">
                            @if($solicitacoesAbonos->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Funcionário</th>
                                                <th>Data</th>
                                                <th>Anexo</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitacoesAbonos as $abono)
                                            <tr>
                                                <td>{{ $abono->funcionario->user->name }}</td>
                                                <td>
                                                    @if($abono->startDate == $abono->endDate)
                                                        {{ date('d/m/Y', strtotime($abono->startDate)) }}<br>
                                                        <span class="text-muted small">
                                                        {{ date('H:i', strtotime($abono->startTime)) }} - {{ date('H:i', strtotime($abono->endTime)) }}
                                                        </span>
    @else
        {{ date('d/m/Y', strtotime($abono->startDate)) }} - {{ date('d/m/Y', strtotime($abono->endDate)) }}<br>
        <span class="text-muted small">
            {{ date('H:i', strtotime($abono->startTime)) }} - {{ date('H:i', strtotime($abono->endTime)) }}
        </span>
    @endif
</td>
                                                <td>
                                                    @if($abono->file)
                                                    <a href="{{ $abono->path }}/{{ $abono->file }}" target="_blank">Ver</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('solicitacoes.aprovar', ['tipo' => 'abonos', 'id' => $abono->id]) }}" class="btn btn-sm btn-primary">Aprovar</a>
                                                    <a href="{{ route('solicitacoes.rejeitar', ['tipo' => 'abonos', 'id' => $abono->id]) }}" class="btn btn-sm btn-danger">Recusar</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    Nenhuma solicitação de abono pendente.
                                </div>
                            @endif
                        </div>

                        <!-- Tab Histórico -->
                        <div class="tab-pane {{ $tipo === 'historico' ? 'show active' : '' }}">
    @if($historico->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Funcionário</th>
                        <th>Ação</th>
                        <th>Período</th>
                        <th>Anexo</th>
                        <th>Data da Alteração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historico as $item)
                    <tr>
                        <td>{{ ucfirst($item->tipo) }}</td>
                        <td>{{ $item->funcionario->user->name }}</td>
                        <td>{{ ucfirst($item->acao) }}</td>
                        <td>
                            @if($item->tipo === 'ferias')
                                {{ date('d/m/Y', strtotime($item->start_date)) }} - {{ date('d/m/Y', strtotime($item->end_date)) }}
                            @else
                                @if($item->start_date == $item->end_date)
                                    {{ date('d/m/Y', strtotime($item->start_date)) }}<br>
                                    <span class="text-muted small">
                                        {{ date('H:i', strtotime($item->start_time)) }} - {{ date('H:i', strtotime($item->end_time)) }}
                                    </span>
                                @else
                                    {{ date('d/m/Y', strtotime($item->start_date)) }} - {{ date('d/m/Y', strtotime($item->end_date)) }}<br>
                                    <span class="text-muted small">
                                        {{ date('H:i', strtotime($item->start_time)) }} - {{ date('H:i', strtotime($item->end_time)) }}
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($item->anexo)
                                <a href="{{ $item->anexo }}" target="_blank">Ver</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mt-3">
            Nenhum registro no histórico.
        </div>
    @endif
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection