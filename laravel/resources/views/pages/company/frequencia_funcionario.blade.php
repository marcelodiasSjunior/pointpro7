@extends('templates.company')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="me-2">Frequência</h1>
        <ul>
            <li><a href="/frequencia">Listagem de frequências</a></li>
            <li class="remove-pd-xs">Funcionário: {{ $funcionario_name}}</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Stopwatch" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Controle de frequência<br><br>{{$funcao_title}} | {{$jornada_title}} | {{ $funcionario_name}}
                    </h4>
                    <div class="text-end w-50 float-end">
                        <a class="btn btn-primary btn-icon m-1" role="button"
                           href="/frequencia/{{ $funcionario_id }}/export-pdf/{{ $ano }}/{{ $mes }}"
                           target="_blank">
                            <span class="ul-btn__icon">
                                <i class="i-File-Word" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Exportar PDF</span>
                        </a>
                        <a class="btn btn-primary btn-icon m-1" role="button"
                           href="/frequencia/{{ $funcionario_id }}/export-xls/{{ $ano }}/{{ $mes }}"
                           target="_blank">
                            <span class="ul-btn__icon">
                                <i class="i-File-Word" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Exportar Excel</span>
                        </a>
                        <div class="btn-group m-1">
                            <button type="button" class="btn btn-primary btn-icon dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="ul-btn__icon">
                                    <i class="i-Calendar" style="font-size: 18px;"></i>
                                </span>
                                <span class="ul-btn__text">Auditoria</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                       href="/auditoria/{{ $funcionario_id }}/export-xls/{{ $ano }}/{{ $mes }}"
                                       target="_blank">Exportar para Excel</a></li>
                                <li><a class="dropdown-item"
                                       href="{{ route('auditoria.historico', ['funcionario_id' => $funcionario_id, 'ano' => $ano, 'mes' => $mes]) }}">Visualizar
                                        Histórico</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="w-50">
                        Acompanhe o andamento da <code><b>frequência do funcionário</b></code>:
                    </p>
                    @if($historico_action)
                    <div style="margin:25px 0px;">
                        <form method="get" action="{{ $historico_action }}">
                            <div class="row">
                                <div class="col-md-2 form-group mb-3">
                                    <label for="picker1">Selecionar mês</label>
                                    <select class="form-control" name="mes">
                                        @foreach($monthList as $key => $value)
                                        <option value="{{ $key }}" {{ $monthNumber == $key ? "selected" : ''}}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group mb-3">
                                    <label for="picker1">Selecionar ano</label>
                                    <select class="form-control" name="ano">
                                        @foreach(range($yearMin, $yearMax) as $index)
                                        <option {{ $yearNumber == $index  ? "selected" : ''}}>{{ $index }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" style="margin-top: 24px;">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped ">
                                <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">Dia</th>
                                    <th scope="col">Mês</th>
                                    <th scope="col">Ano</th>
                                    <th scope="col">Semana</th>
                                    <th scope="col">Início da jornada</th>
                                    <th scope="col">Início do intervalo</th>
                                    <th scope="col">Fim do intervalo</th>
                                    <th scope="col">Fim da jornada</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Atestado</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                @foreach($dias as $dia => $dados)
                                @php
                                $carbonDate = \Carbon\Carbon::parse($dados['ponto'])->locale('pt_BR');
                                @endphp
                                <tr>
                                    <th scope="row">{{ $carbonDate->day }}</th>
                                    <td>{{ $carbonDate->translatedFormat('F') }}</td>
                                    <td>{{ $carbonDate->year }}</td>
                                    <td>{{ $carbonDate->translatedFormat('l') }}</td>
                                    @for($i = 0; $i < 4; $i++)
                                    <td>
                                        @if(isset($dados['frequencias'][$i]))
                                        <form method="post" action="{{ route('frequencias.update', $dados['frequencias'][$i]->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input style="width: 47px;" type="text" name="hora" value="{{ $dados['frequencias'][$i]->hora }}">
                                            <button style="width: 63px;" id="saveButton" type="submit" class="btn btn-success">Salvar</button>
                                        </form>
                                        @else
                                        @if (count($dados['frequencias']) == $i)
                                        <form method="post" action="{{ route('frequencias.add') }}">
                                            @csrf
                                            <input type="hidden" name="funcionario_id" value="{{ $funcionario_id }}">
                                            <input type="hidden" name="data" value="{{ $dados['ponto'] }}">
                                            <input style="width: 53px;" type="text" name="hora" placeholder="HH:MM">
                                            <button type="submit" class="btn btn-primary">+ Add</button>
                                        </form>
                                        @endif
                                        @endif
                                    </td>
                                    @endfor
                                    <td>
                                        @if(!empty($dados['frequencias']))
                                        @if($dados['frequencias'][0]->ferias)
                                        <span class="badge bg-warning">Férias</span>
                                        @elseif(count($dados['frequencias']) < 1)
                                        <span class="badge bg-danger">Não compareceu</span>
                                        @elseif(isset($dados['frequencias'][0]->hora) && isset($dados['frequencias'][1]->hora) && isset($dados['frequencias'][2]->hora) && isset($dados['frequencias'][3]->hora))
                                        <span class="badge bg-success">Compareceu</span>
                                        @elseif(count($dados['frequencias']) > 1 && count($dados['frequencias']) < 4)
                                        <span class="badge bg-warning">Não Finalizada</span>
                                        @endif
                                        @else
                                        <span class="badge bg-danger">Não compareceu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($dados['frequencias']) && isset($dados['frequencias'][0]->document))
                                        <a class="text-success me-2" style="font-size: 23px;line-height: 20px;" href="{{ $dados['frequencias'][0]->document }}">
                                            <i style="margin:0px 0px -4px;" class="nav-icon i-File fw-bold"></i>
                                        </a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($dados['atestado'])
                                        <a href="{{ $dados['atestado']->path }}/{{ $dados['atestado']->file }}" target="_blank">
                                            Download Atestado
                                        </a>
                                        @else
                                        -
                                        @endif
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
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="hora"]').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0, 4);
                if (value.length === 4) {
                    value = value.slice(0, 2) + ':' + value.slice(2);
                }
                e.target.value = value;
            });
        });
    });
</script>
