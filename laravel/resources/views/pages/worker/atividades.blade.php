@extends('templates.worker')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Atividades</h1>
        <ul>
            <li><a>{{$funcao_title}}</a></li>
            <li><a>{{$jornada_title}}</a></li>
            <li class="remove-pd-xs">{{ Auth::user()->name }}</li>
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
                        </span> Gerenciamento de atividades
                    </h4>

                    <p class="w-50">
                        Acompanhe o progresso das <code><b>atividades desempenhadas</b></code>:
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
                                                        <th scope="col" style="min-width: 290px;">Atividade</th>
                                                        <th scope="col"><span class="badge bg-danger tx-t">Não realizado</span></th>
                                                        <th scope="col"><span class="badge bg-warning tx-t">Em andamento</span></th>
                                                        <th scope="col"><span class="badge bg-success tx-t">Concluído</span></th>
                                                        <th scope="col">Observações</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @foreach($atividades as $atividade)
                                                    <tr>
                                                        <th scope="row">{{ $atividade->id }}</th>
                                                        <td>{{ $atividade->description }}</td>
                                                        <td style="text-align:center;padding: 2px 5px 4px;">
                                                            <div class="radio-centralizado">
                                                                <label class="radio radio-danger">
                                                                    @if($atividade->current_status === 'nao_iniciada')
                                                                    <input type="radio" name="test_{{ $atividade->id }}" value="0" checked disabled />
                                                                    @else
                                                                    <input type="radio" name="test_{{ $atividade->id }}" value="0" disabled />
                                                                    @endif
                                                                    <span></span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;padding: 2px 5px 4px;">
                                                            <div class="radio-centralizado">
                                                                <label class="radio radio-warning">
                                                                    @if($atividade->current_status === 'nao_iniciada')
                                                                    <form method="POST" action="/atividades/{{ $atividade->atividade_funcionario->id }}/criar">
                                                                        @csrf
                                                                        <input type="hidden" name="dia_da_semana" value="{{ $dayOfTheWeek }}" />
                                                                        <input type="hidden" name="dateForMySQL" value="{{ $dateForMySQL }}" />
                                                                        <input type="radio" name="atividade_id" value="{{ $atividade->id }}" {{ $hasSearch ? 'disabled="true"' : '' }}" onchange="this.form.submit()" />
                                                                    </form>
                                                                    @elseif($atividade->current_status === 'completa')
                                                                    <input type="radio" value="" disabled />
                                                                    @else
                                                                    <input type="radio" value="" checked disabled />
                                                                    @endif
                                                                    <span></span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;padding: 2px 5px 4px;">
                                                            <div class="radio-centralizado">
                                                                <label class="radio radio-success">
                                                                    @if($atividade->current_status === 'iniciada')
                                                                    <form method="POST" action="/atividades/{{ $atividade->funcionario_atividade->id }}/atualizar">
                                                                        @csrf
                                                                        <input type="hidden" name="dia_da_semana" value="{{ $dayOfTheWeek }}" />
                                                                        <input type="hidden" name="dateForMySQL" value="{{ $dateForMySQL }}" />
                                                                        <input type="radio" name="atividade_id" value="{{ $atividade->id }}" {{ $hasSearch ? 'disabled="true"' : '' }}" onchange="this.form.submit()" />
                                                                    </form>
                                                                    @elseif($atividade->current_status === 'nao_iniciada')
                                                                    <input type="radio" value="" disabled />
                                                                    @else
                                                                    <input type="radio" value="" checked disabled />
                                                                    @endif
                                                                    <span></span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="padding-bottom: 3px;">
                                                            <a class="text-primary badge-top-container" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                               <span class="badge bg-danger">{{ $atividade->observacoes }}</span>
                                                                <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                                            </a>
                                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                            @if(isset($atividade->atividade_funcionario[0]->observacoes[0]))
                                                             <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{$atividade->atividade_funcionario->observacoes[0]->id}}">Observações da Atividade</a>
                                                            @else 
                                                             <a class="dropdown-item ul-widget__link--font" href="#">Nenhuma observação cadastrada</a>
                                                            @endif
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