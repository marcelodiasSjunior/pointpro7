@extends('templates.worker')
@section('content')

<!-- ============ Body content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Painel Administrativo</h1>
        <ul>
            <li>{{ $funcionario->funcao->title }}</li>
            <li>{{ $funcionario->cargaSemanal }} horas semanais</li>
            @if($funcionario->jornada->segunda)
            <li class="remove-pd-xs">{{ $funcionario->jornada->segunda }}h Seg</li>@endif
            @if($funcionario->jornada->terca)
            <li class="remove-pd-xs">{{ $funcionario->jornada->terca }}h Ter</li>@endif
            @if($funcionario->jornada->quarta)
            <li class="remove-pd-xs">{{ $funcionario->jornada->quarta }}h Qua</li>@endif
            @if($funcionario->jornada->quinta)
            <li class="remove-pd-xs">{{ $funcionario->jornada->quinta }}h Qui</li>@endif
            @if($funcionario->jornada->sexta)
            <li class="remove-pd-xs">{{ $funcionario->jornada->sexta }}h Sex</li>@endif
            @if($funcionario->jornada->sabado)
            <li class="remove-pd-xs">{{ $funcionario->jornada->sabado }}h Sab</li>@endif
            @if($funcionario->jornada->domingo)
            <li class="remove-pd-xs">{{ $funcionario->jornada->domingo }}h Dom</li>@endif
            <li>{{ $user->name }}</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 col-lg-12" style="margin-bottom: 40px;">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Check text-success"></i>
                                <h3 class="t-font-boldest">{{ $atividades->count() }}</h3>
                                <span>Atividades</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Speach-Bubbles text-primary"></i>
                                <h3 class="t-font-boldest">{{ $observacoes->count() }}</h3>
                                <span>Observações</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                @if($company->logo)
                                    <div class="logo-empresa"><img src=" {{ $company->logo }}" alt=""></div>
                                @else
                                    <div style="height: 64px; width: 64px"></div>
                                @endif
                                <h3 class="t-font-boldest">{{ $company->title }}</h3>
                                <span>{{ $company->seguimento }}</span>
                            </div>
                        </div>
                        @if($funcionario->funcao->onboarding)
                            <div class="col-md-3 col-lg-3 col-sm-6 col-6">
                                <a href="{{ $funcionario->funcao->onboarding }}" target="_blank" download>
                                    <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                        <i class="i-File-Download text-danger"></i>
                                        <h3 class="t-font-boldest">Onboarding</h3>
                                        <span>Inicialização</span>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="col-md-3 col-lg-3 col-sm-6 col-6">
                                <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                    <i class="i-File-Download text-danger"></i>
                                    <h3 class="t-font-boldest">Onboarding</h3>
                                    <span>Nao cadastrado</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de atividades
                    </h4>
                    Acompanhe o progresso das suas <code><b>atividades</b></code>:
                    </p>
                    @include('components.filtro')
                    <div class="tab-content" id="myIconTabContent" style="padding: 10px 0px 0px;">
                        <div class="tab-pane fade show active" id="homeIcon" role="tabpanel"
                            aria-labelledby="home-icon-tab">

                            <div class="col-md-12 mt-3">
                                <div class=" text-start">
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped ">
                                                <thead style="text-align: center;">
                                                <tr>
                                                    <th scope="col">Progresso das Atividades</th>
                                                    <th scope="col">Atividades</th>
                                                    <th scope="col">Ver</th>
                                                </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="progress mb-3">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                                    role="progressbar"
                                                                    style="width: {{ $porcentagem_completas }}%"
                                                                    aria-valuenow="0" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                    {{ $porcentagem_completas }}%
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td>{{ $atividades_hoje->count() }}</td>
                                                        <td>
                                                            <a class="text-primary me-2" style="font-size: 23px;"
                                                                href="/atividades">
                                                                <i class="nav-icon i-Eye fw-bold"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
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

    <div class="row">

        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Stopwatch" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Frequência
                    </h4>
                    <div class="text-end w-50 float-end">
                        <a class="btn btn-primary btn-icon m-1" role="button" href="/frequencia">
                            <span class="ul-btn__icon">
                                <i class="i-Eye" style="font-size: 18px;"></i>
                            </span>
                            <span class="ul-btn__text"> Ver histórico</span>
                        </a>
                    </div>
                    <p class="w-50">
                        Controle sua <br><code><b>frequência de presença</b></code>:
                    </p>

                    <div class="">
                        <div style="margin:25px 0px;">

                            <div class="row">
                                <div class="col-md-2 mb-1"></div>
                                <div class="col-md-8 mb-1 text-primary" style="text-align: center;font-size: 18px;">
                                    <ul class="list-group list-group-flash">
                                        <li class="list-group-item border-0">
                                            <span class="badge bg-primary lg m-2">{{ $dayDiffHumans }}</span>
                                            <span class="badge bg-primary lg m-2">{{ $localTime }}</span>
                                            <span class="badge bg-primary lg m-2">{{ $dayOfWeekHuman }}</span>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-md-2 mb-1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div style="margin:25px 0px;">

                            <div class="row">
                                <div class="col-lg-1 col-md-12 col-sm-12 form-group mb-3"></div>
                                <div class="col-lg-10 col-md-12 col-sm-12 form-group mb-3">

                                    <div class="accordion" id="accordionRightIcon">
                                        <div class="card ul-card__v-space">
                                            <div class="card-header header-elements-inline">
                                                <h6
                                                    class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <a class="text-default " data-bs-toggle="collapse"
                                                        href="#accordion-item-icon-right-1"
                                                        aria-expanded="true">COMUNICAR PRESENÇA</a>
                                                </h6>
                                            </div>
                                            <div class="collapse show" id="accordion-item-icon-right-1"
                                                data-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div style="margin:25px 0px;">

                                                        @if(Auth::user()->funcionario->company->plan == 2)
                                                            @if($totalBatidasPontoHoje < 4)
                                                                <div id="webcamFacial"
                                                                    class="alert alert-dismissible fade show alert-card alert-danger"
                                                                    style="display:none" role="alert"><strong
                                                                        class="text-capitalize">Erro:</strong> :Foto invalida
                                                                </div>
                                                                <div id="webcamWrapper">

                                                                    <video id="webcam" autoplay muted playsinline></video>

                                                                    <canvas id="canvasWebcam"></canvas>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div id="folhaPontoDefault"></div>
                                                        @endif

                                                        <input type="hidden" name="api_token_for_web"
                                                            value="{{ $api_token_for_web }}" />
                                                        <input type="hidden" name="plainTextToken"
                                                            value="{{ $plainTextToken }}" />
                                                        <input type="hidden" name="python_api_prefix"
                                                            value="{{ config('app.python_api_prefix') }}" />
                                                        <input type="hidden" name="plainTextToken"
                                                            value="{{ $plainTextToken }}" />
                                                        <input type="hidden" name="asdasd"
                                                            value="{{ Auth::user()->funcionario->company->id }}" />

                                                        @if(Auth::user()->funcionario->company->plan == 2)
                                                            <div class="row" style="display:none" id="sendPicturePonto">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-success btn-lg"
                                                                        style="margin-top: 15px;min-width: 230px;width: 100%;"><b>Confirmar</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                        @endif


                                                        @if(!$ultimaBatidaPontoHoje)
                                                            <div class="row" id="takePicture">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-primary btn-lg"
                                                                        style="margin-top: 5px;min-width: 230px;width: 100%;"><b>INICIAR
                                                                            JORNADA</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                            <input type="hidden" name="direction" value="1" />
                                                        @endif
                                                        @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 1)
                                                            <div class="row" id="takePicture">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-primary btn-lg"
                                                                        style="margin-top: 5px;min-width: 230px;width: 100%;"><b>INICIAR
                                                                            INTERVALO</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                            <input type="hidden" name="direction" value="2" />
                                                        @endif
                                                        @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 2)
                                                            <div class="row" id="takePicture">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-primary btn-lg"
                                                                        style="margin-top: 5px;min-width: 230px;width: 100%;"><b>FINALIZAR
                                                                            INTERVALO</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                            <input type="hidden" name="direction" value="1" />
                                                        @endif
                                                        @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 3)
                                                            <div class="row" id="takePicture">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-primary btn-lg"
                                                                        style="margin-top: 5px;min-width: 230px;width: 100%;"><b>FINALIZAR
                                                                            JORNADA</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                            <input type="hidden" name="direction" value="2" />
                                                        @endif

                                                        @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 4)
                                                            <div class="row">
                                                                <div class="col-md-2 mb-4"></div>
                                                                <div class="col-md-8 mb-4" style="text-align: center;">
                                                                    <button class="btn btn-primary btn-lg"
                                                                        style="margin-top: 5px;min-width: 230px;width: 100%;"><b>JORNADA
                                                                            ENCERRADA</b></button>
                                                                </div>
                                                                <div class="col-md-2 mb-4"></div>
                                                            </div>
                                                            <input type="hidden" name="direction" value="2" />
                                                        @endif

                                                        @foreach($batidasPontoHoje as $batida)
                                                            <div class="row">
                                                                <div class="col-md-2 mb-2"></div>
                                                                <div class="col-md-8 mb-2" style="text-align: center;">
                                                                    <button class="btn btn-success btn-lg"
                                                                        style="min-width: 230px;width: 100%;">
                                                                        @if($loop->index === 0)
                                                                            Inicio da jornada:
                                                                        @elseif($loop->index === 1)
                                                                            Inicio do intervalo:
                                                                        @elseif($loop->index === 2)
                                                                            Fim do intervalo:
                                                                        @elseif($loop->index === 3)
                                                                            Fim da jornada:
                                                                        @endif
                                                                        <b>{{ $batida->hora }}</b>
                                                                    </button>
                                                                </div>
                                                                <div class="col-md-2 mb-2"></div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card ul-card__v-space">
                                            <div class="card-header header-elements-inline">
                                                <h6
                                                    class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <a class="text-default collapsed" data-bs-toggle="collapse"
                                                        href="#accordion-item-icon-right-2">COMUNICAR FALTA</a>
                                                </h6>
                                            </div>
                                            <div class="collapse" id="accordion-item-icon-right-2"
                                                data-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <p style="margin-bottom: 3px;">Anexar comprovante, declaração ou
                                                        atestado:</p>
                                                    <div style="margin:0px 0px 25px;">
                                                        <div class="row">
                                                            <div class="col-md-12 form-group mb-3">
                                                                <div class="mb-3">
                                                                    <form method="POST"
                                                                        action="{{ route('worker.anexarAtestado') }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="fallback">
                                                                            <input name="file" type="file" required />
                                                                        </div>
                                                                        <div class="dz-message">Solte o arquivo aqui
                                                                            para enviar</div>
                                                                        <!-- Campos adicionais -->
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6 mb-3">
                                                                                    <p style="margin-bottom: 3px;">
                                                                                        Ausente:</p>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label
                                                                                                for="startDay">Selecionar
                                                                                                o dia</label>
                                                                                            <select class="form-control"
                                                                                                id="startDay"
                                                                                                name="startDay">
                                                                                                @for ($i = 1; $i <= 31; $i++)
                                                                                                    <option
                                                                                                        value="{{ $i }}">
                                                                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                                                                    </option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-4 mb-3">
                                                                                            <label
                                                                                                for="startMonth">Selecionar
                                                                                                mês</label>
                                                                                            <select class="form-control"
                                                                                                id="startMonth"
                                                                                                name="startMonth">
                                                                                                @foreach (['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'] as $index => $month)
                                                                                                    <option
                                                                                                        value="{{ $index + 1 }}">
                                                                                                        {{ $month }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label
                                                                                                for="startYear">Selecionar
                                                                                                ano</label>
                                                                                            <select class="form-control"
                                                                                                id="startYear"
                                                                                                name="startYear">
                                                                                                @for ($i = now()->year; $i >= 2021; $i--)
                                                                                                    <option
                                                                                                        value="{{ $i }}">
                                                                                                        {{ $i }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label for="startTime">Hora
                                                                                                de início</label>
                                                                                            <input type="time"
                                                                                                class="form-control"
                                                                                                id="startTime"
                                                                                                name="startTime"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label for="endTime">Hora
                                                                                                Fim</label>
                                                                                            <input type="time"
                                                                                                class="form-control"
                                                                                                id="endTime"
                                                                                                name="endTime" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <p style="margin-bottom: 3px;">Até:
                                                                                    </p>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label
                                                                                                for="endDay">Selecionar
                                                                                                o dia</label>
                                                                                            <select class="form-control"
                                                                                                id="endDay"
                                                                                                name="endDay">
                                                                                                @for ($i = 1; $i <= 31; $i++)
                                                                                                    <option
                                                                                                        value="{{ $i }}">
                                                                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                                                                    </option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-4 mb-3">
                                                                                            <label
                                                                                                for="endMonth">Selecionar
                                                                                                mês</label>
                                                                                            <select class="form-control"
                                                                                                id="endMonth"
                                                                                                name="endMonth">
                                                                                                @foreach (['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'] as $index => $month)
                                                                                                    <option
                                                                                                        value="{{ $index + 1 }}">
                                                                                                        {{ $month }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-3 mb-3">
                                                                                            <label
                                                                                                for="endYear">Selecionar
                                                                                                ano</label>
                                                                                            <select class="form-control"
                                                                                                id="endYear"
                                                                                                name="endYear">
                                                                                                @for ($i = now()->year; $i >= 2021; $i--)
                                                                                                    <option
                                                                                                        value="{{ $i }}">
                                                                                                        {{ $i }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12"
                                                                                    style="text-align: center;">
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-primary"
                                                                                        style="margin-top: 15px;min-width: 290px;"><b>COMUNICAR
                                                                                            FALTA</b></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 form-group mb-3"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- end of main-content -->

    @endsection