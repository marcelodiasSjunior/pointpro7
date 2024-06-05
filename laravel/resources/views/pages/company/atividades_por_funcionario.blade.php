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
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon"><i class="i-Add"></i></span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="atividades-04-funcao-funcionario-atividades-add-edit.html">Adicionar nova Atividade</a>
                        </div>
                    </div>
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
                                                        <th scope="col">Editar</th>
                                                        <th scope="col">Apagar</th>
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
                                                                    @if($atividade->nao_iniciada)
                                                                    <input type="radio" name="radio-{{ $atividade->id }}" value="1" checked />
                                                                    @else
                                                                    <form method="POST" action="/atividades/funcionario/{{ $funcionario_id }}/{{ $atividade->id }}/criar">
                                                                        @csrf
                                                                        <input type="hidden" name="deletar" value="1" />
                                                                        <input type="hidden" name="dia_da_semana" value="{{ $dayOfTheWeek }}" />
                                                                        <input type="hidden" name="dateForMySQL" value="{{ $dateForMySQL }}" />
                                                                        <input type="radio" name="atividade_criar" onchange="this.form.submit()" />
                                                                    </form>
                                                                    @endif
                                                                    <span></span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;padding: 2px 5px 4px;">
                                                            <div class="radio-centralizado">
                                                                <label class="radio radio-warning">
                                                                    @if($atividade->iniciada)
                                                                    <input type="radio" name="radio-{{ $atividade->id }}" value="1" checked />
                                                                    @else
                                                                    <form method="POST" action="/atividades/funcionario/{{ $funcionario_id }}/{{ $atividade->id }}/criar">
                                                                        @csrf
                                                                        <input type="hidden" name="dia_da_semana" value="{{ $dayOfTheWeek }}" />
                                                                        <input type="hidden" name="dateForMySQL" value="{{ $dateForMySQL }}" />
                                                                        <input type="radio" name="atividade_criar" onchange="this.form.submit()" />
                                                                    </form>
                                                                    @endif
                                                                    <span></span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;padding: 2px 5px 4px;">
                                                            <div class="radio-centralizado">
                                                                <label class="radio radio-success">
                                                                    @if($atividade->completa)
                                                                    <input type="radio" name="radio-{{ $atividade->id }}" value="1" checked />
                                                                    @else
                                                                    <form method="POST" action="/atividades/funcionario/{{ $funcionario_id }}/{{ $atividade->id }}/atualizar">
                                                                        @csrf
                                                                        <input type="hidden" name="dia_da_semana" value="{{ $dayOfTheWeek }}" />
                                                                        <input type="hidden" name="dateForMySQL" value="{{ $dateForMySQL }}" />
                                                                        <input type="radio" name="atividade_atualizar" onchange="this.form.submit()" />
                                                                    </form>
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
                                                                <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{ $atividade->id }}/{{ $funcionario_id }}">Observações da Atividade</a>
                                                            </div>
                                                        </td>
                                                        <td style="padding-bottom: 3px;">
                                                            <a class="text-warning me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="nav-icon i-Pen-5 fw-bold"></i>
                                                            </a>
                                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                                <a class="dropdown-item ul-widget__link--font" href="/atividades/editar/{{ $atividade->id }}">Editar</a>
                                                            </div>
                                                        </td>
                                                        <td style="padding-bottom: 3px;">
                                                            <a class="text-danger me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="nav-icon i-Close-Window fw-bold"></i>
                                                            </a>
                                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                                <a class="dropdown-item ul-widget__link--font" href="/atividades/apagar/{{ $atividade->id }}/{{ $funcionario_id }}">Apagar</a>
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
</div>
<!-- ======= Main content end ======= -->
@endsection