@extends('templates.worker')
@section('content')

<!-- ============ Body content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Painel Administrativo</h1>
        <ul>
            <li>{{ $funcionario->funcao->title }}</li>
            <li>{{ $funcionario->cargaSemanal }} horas semanais</li>
            @if($funcionario->jornada->segunda)<li class="remove-pd-xs">{{ $funcionario->jornada->segunda }}h Seg</li>@endif
            @if($funcionario->jornada->terca)<li class="remove-pd-xs">{{ $funcionario->jornada->terca }}h Ter</li>@endif
            @if($funcionario->jornada->quarta)<li class="remove-pd-xs">{{ $funcionario->jornada->quarta }}h Qua</li>@endif
            @if($funcionario->jornada->quinta)<li class="remove-pd-xs">{{ $funcionario->jornada->quinta }}h Qui</li>@endif
            @if($funcionario->jornada->sexta)<li class="remove-pd-xs">{{ $funcionario->jornada->sexta }}h Sex</li>@endif
            @if($funcionario->jornada->sabado)<li class="remove-pd-xs">{{ $funcionario->jornada->sabado }}h Sab</li>@endif
            @if($funcionario->jornada->domingo)<li class="remove-pd-xs">{{ $funcionario->jornada->domingo }}h Dom</li>@endif
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
                        <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">

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
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $porcentagem_completas }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                                    {{ $porcentagem_completas }}%
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td>{{ $atividades_hoje->count() }}</td>
                                                        <td>
                                                            <a class="text-primary me-2" style="font-size: 23px;" href="/atividades">
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



        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">

                            <h4 class="card-title mb-3 w-50 float-start ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Speach-Bubbles" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Gerenciamento de observações
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
                            <p>
                                Acompanhe as anotações e <code><b>observações das atividades</b></code>:
                            </p>

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
                                            <td>{{ $atividade->description }}</td>

                                            <td>
                                                @if($atividade->observacao)
                                                {{ $atividade->observacao }}
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
                                                    <span class="badge bg-danger">{{ $atividade->observacoes_count}}</span>
                                                    <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                                </a>
                                                <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                @if(isset($atividade->observacao))
                                                <a class="dropdown-item ul-widget__link--font" href="/observacoes/{{$atividade->id}}">Observações da Atividade</a>
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
                                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                    <a class="text-default " data-bs-toggle="collapse" href="#accordion-item-icon-right-1" aria-expanded="true">COMUNICAR PRESENÇA</a>
                                                </h6>
                                            </div>
                                            <div class="collapse show" id="accordion-item-icon-right-1" data-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div style="margin:25px 0px;">

                                                        @if(Auth::user()->funcionario->company->plan == 2)
                                                        @if($totalBatidasPontoHoje < 4) <div id="webcamFacial" class="alert alert-dismissible fade show alert-card alert-danger" style="display:none" role="alert"><strong class="text-capitalize">Erro:</strong> :Foto invalida </div>
                                                    <div id="webcamWrapper">

                                                        <video id="webcam"></video>

                                                        <canvas id="canvasWebcam"></canvas>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <div id="folhaPontoDefault"></div>
                                                    @endif

                                                    <input type="hidden" name="api_token_for_web" value="{{ $api_token_for_web }}" />
                                                    <input type="hidden" name="plainTextToken" value="{{ $plainTextToken }}" />
                                                    <input type="hidden" name="python_api_prefix" value="{{ config('app.python_api_prefix') }}" />
                                                    <input type="hidden" name="plainTextToken" value="{{ $plainTextToken }}" />
                                                    <input type="hidden" name="asdasd" value="{{ Auth::user()->funcionario->company->id }}" />

                                                    @if(Auth::user()->funcionario->company->plan == 2)
                                                    <div class="row" style="display:none" id="sendPicturePonto">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-success btn-lg" style="margin-top: 15px;min-width: 230px;width: 100%;"><b>Confirmar</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    @endif


                                                    @if(!$ultimaBatidaPontoHoje)
                                                    <div class="row" id="takePicture">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-primary btn-lg" style="margin-top: 5px;min-width: 230px;width: 100%;"><b>INICIAR JORNADA</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    <input type="hidden" name="direction" value="1" />
                                                    @endif
                                                    @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 1)
                                                    <div class="row" id="takePicture">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-primary btn-lg" style="margin-top: 5px;min-width: 230px;width: 100%;"><b>INICIAR INTERVALO</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    <input type="hidden" name="direction" value="2" />
                                                    @endif
                                                    @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 2)
                                                    <div class="row" id="takePicture">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-primary btn-lg" style="margin-top: 5px;min-width: 230px;width: 100%;"><b>FINALIZAR INTERVALO</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    <input type="hidden" name="direction" value="1" />
                                                    @endif
                                                    @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 3)
                                                    <div class="row" id="takePicture">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-primary btn-lg" style="margin-top: 5px;min-width: 230px;width: 100%;"><b>FINALIZAR JORNADA</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    <input type="hidden" name="direction" value="2" />
                                                    @endif

                                                    @if($ultimaBatidaPontoHoje && $totalBatidasPontoHoje === 4)
                                                    <div class="row">
                                                        <div class="col-md-2 mb-4"></div>
                                                        <div class="col-md-8 mb-4" style="text-align: center;">
                                                            <button class="btn btn-primary btn-lg" style="margin-top: 5px;min-width: 230px;width: 100%;"><b>JORNADA ENCERRADA</b></button>
                                                        </div>
                                                        <div class="col-md-2 mb-4"></div>
                                                    </div>
                                                    <input type="hidden" name="direction" value="2" />
                                                    @endif

                                                    @foreach($batidasPontoHoje as $batida)
                                                    <div class="row">
                                                        <div class="col-md-2 mb-2"></div>
                                                        <div class="col-md-8 mb-2" style="text-align: center;">
                                                            <button class="btn btn-success btn-lg" style="min-width: 230px;width: 100%;">
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
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a class="text-default collapsed" data-bs-toggle="collapse" href="#accordion-item-icon-right-2">COMUNICAR FALTA</a>
                                            </h6>
                                        </div>
                                        <div class="collapse" id="accordion-item-icon-right-2" data-parent="#accordionRightIcon">
                                            <div class="card-body">
                                                <p style="margin-bottom: 3px;">Anexar comprovante, declaração ou atestado:</p>
                                                <div style="margin:0px 0px 25px;">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mb-3">
                                                            <div class="mb-3">
                                                                <button class="btn btn-outline-primary mb-2" id="button-select">
                                                                    ESCOLHER ARQUIVO
                                                                </button>
                                                                <form class="dropzone dropzone-area" id="button-select-upload" action="#">
                                                                    <div class="fallback">
                                                                        <input name="file" type="file" multiple="multiple" />
                                                                    </div>
                                                                    <div class="dz-message">Solte o arquivo aqui para enviar</div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <form method="get" action="/">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <p style="margin-bottom: 3px;">Ausente:</p>
                                                            <div class="row">
                                                                <div class="col-sm-3 mb-3">
                                                                    <label for="picker1">Selecionar o dia</label>
                                                                    <select class="form-control">
                                                                        <option>01</option>
                                                                        <option>02</option>
                                                                        <option>03</option>
                                                                        <option>04</option>
                                                                        <option>05</option>
                                                                        <option>06</option>
                                                                        <option>07</option>
                                                                        <option>08</option>
                                                                        <option>09</option>
                                                                        <option>10</option>
                                                                        <option>11</option>
                                                                        <option>12</option>
                                                                        <option>13</option>
                                                                        <option>14</option>
                                                                        <option>15</option>
                                                                        <option>16</option>
                                                                        <option>17</option>
                                                                        <option>18</option>
                                                                        <option>19</option>
                                                                        <option>20</option>
                                                                        <option>21</option>
                                                                        <option>22</option>
                                                                        <option>23</option>
                                                                        <option>24</option>
                                                                        <option>25</option>
                                                                        <option>26</option>
                                                                        <option>27</option>
                                                                        <option>28</option>
                                                                        <option>29</option>
                                                                        <option>30</option>
                                                                        <option>31</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4 mb-3">
                                                                    <label for="picker1">Selecionar mês</label>
                                                                    <select class="form-control">
                                                                        <option>Janeiro</option>
                                                                        <option>Fevereiro</option>
                                                                        <option>Março</option>
                                                                        <option>Abril</option>
                                                                        <option>Maio</option>
                                                                        <option>Junho</option>
                                                                        <option>Julho</option>
                                                                        <option>Agosto</option>
                                                                        <option>Setembro</option>
                                                                        <option>Outubro</option>
                                                                        <option>Novembro</option>
                                                                        <option>Dezembro</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <label for="picker1">Selecionar ano</label>
                                                                    <select class="form-control">
                                                                        <option>2024</option>
                                                                        <option>2023</option>
                                                                        <option>2022</option>
                                                                        <option>2021</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <p style="margin-bottom: 3px;">Até:</p>
                                                            <div class="row">
                                                                <div class="col-sm-3 mb-3">
                                                                <label for="picker1">Selecionar o dia</label>
                                                                    <select class="form-control">
                                                                        <option>01</option>
                                                                        <option>02</option>
                                                                        <option>03</option>
                                                                        <option>04</option>
                                                                        <option>05</option>
                                                                        <option>06</option>
                                                                        <option>07</option>
                                                                        <option>08</option>
                                                                        <option>09</option>
                                                                        <option>10</option>
                                                                        <option>11</option>
                                                                        <option>12</option>
                                                                        <option>13</option>
                                                                        <option>14</option>
                                                                        <option>15</option>
                                                                        <option>16</option>
                                                                        <option>17</option>
                                                                        <option>18</option>
                                                                        <option>19</option>
                                                                        <option>20</option>
                                                                        <option>21</option>
                                                                        <option>22</option>
                                                                        <option>23</option>
                                                                        <option>24</option>
                                                                        <option>25</option>
                                                                        <option>26</option>
                                                                        <option>27</option>
                                                                        <option>28</option>
                                                                        <option>29</option>
                                                                        <option>30</option>
                                                                        <option>31</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4 mb-3">
                                                                    <label for="picker1">Selecionar mês</label>
                                                                    <select class="form-control">
                                                                        <option>Janeiro</option>
                                                                        <option>Fevereiro</option>
                                                                        <option>Março</option>
                                                                        <option>Abril</option>
                                                                        <option>Maio</option>
                                                                        <option>Junho</option>
                                                                        <option>Julho</option>
                                                                        <option>Agosto</option>
                                                                        <option>Setembro</option>
                                                                        <option>Outubro</option>
                                                                        <option>Novembro</option>
                                                                        <option>Dezembro</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <label for="picker1">Selecionar ano</label>
                                                                    <select class="form-control">
                                                                        <option>2024</option>
                                                                        <option>2023</option>
                                                                        <option>2022</option>
                                                                        <option>2021</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: center;">
                                                            <button class="btn btn-outline-primary" style="margin-top: 15px;min-width: 290px;"><b>COMUNICAR FALTA</b></button>
                                                        </div>
                                                    </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="card ul-card__v-space">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                            <a class="text-default collapsed" data-bs-toggle="collapse" href="#accordion-item-icon-right-3">COMUNICAR FÉRIAS</a>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="accordion-item-icon-right-3" data-parent="#accordionRightIcon">
                                        <form method="get" action="/">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <p style="margin-bottom: 3px;">Ausente:</p>
                                                        <div class="row">
                                                            <div class="col-sm-3 mb-3">
                                                            <label for="picker1">Selecionar o dia</label>
                                                                <select class="form-control">
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                    <option>24</option>
                                                                    <option>25</option>
                                                                    <option>26</option>
                                                                    <option>27</option>
                                                                    <option>28</option>
                                                                    <option>29</option>
                                                                    <option>30</option>
                                                                    <option>31</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4 mb-3">
                                                                <label for="picker1">Selecionar mês</label>
                                                                <select class="form-control">
                                                                    <option>Janeiro</option>
                                                                    <option>Fevereiro</option>
                                                                    <option>Março</option>
                                                                    <option>Abril</option>
                                                                    <option>Maio</option>
                                                                    <option>Junho</option>
                                                                    <option>Julho</option>
                                                                    <option>Agosto</option>
                                                                    <option>Setembro</option>
                                                                    <option>Outubro</option>
                                                                    <option>Novembro</option>
                                                                    <option>Dezembro</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3 mb-3">
                                                                <label for="picker1">Selecionar ano</label>
                                                                <select class="form-control">
                                                                    <option>2024</option>
                                                                    <option>2023</option>
                                                                    <option>2022</option>
                                                                    <option>2021</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <p style="margin-bottom: 3px;">Até:</p>
                                                        <div class="row">
                                                            <div class="col-sm-3 mb-3">
                                                            <label for="picker1">Selecionar o dia</label>
                                                                <select class="form-control">
                                                                    <option>01</option>
                                                                    <option>02</option>
                                                                    <option>03</option>
                                                                    <option>04</option>
                                                                    <option>05</option>
                                                                    <option>06</option>
                                                                    <option>07</option>
                                                                    <option>08</option>
                                                                    <option>09</option>
                                                                    <option>10</option>
                                                                    <option>11</option>
                                                                    <option>12</option>
                                                                    <option>13</option>
                                                                    <option>14</option>
                                                                    <option>15</option>
                                                                    <option>16</option>
                                                                    <option>17</option>
                                                                    <option>18</option>
                                                                    <option>19</option>
                                                                    <option>20</option>
                                                                    <option>21</option>
                                                                    <option>22</option>
                                                                    <option>23</option>
                                                                    <option>24</option>
                                                                    <option>25</option>
                                                                    <option>26</option>
                                                                    <option>27</option>
                                                                    <option>28</option>
                                                                    <option>29</option>
                                                                    <option>30</option>
                                                                    <option>31</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4 mb-3">
                                                                <label for="picker1">Selecionar mês</label>
                                                                <select class="form-control">
                                                                    <option>Janeiro</option>
                                                                    <option>Fevereiro</option>
                                                                    <option>Março</option>
                                                                    <option>Abril</option>
                                                                    <option>Maio</option>
                                                                    <option>Junho</option>
                                                                    <option>Julho</option>
                                                                    <option>Agosto</option>
                                                                    <option>Setembro</option>
                                                                    <option>Outubro</option>
                                                                    <option>Novembro</option>
                                                                    <option>Dezembro</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3 mb-3">
                                                                <label for="picker1">Selecionar ano</label>
                                                                <select class="form-control">
                                                                    <option>2024</option>
                                                                    <option>2023</option>
                                                                    <option>2022</option>
                                                                    <option>2021</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="margin:0px 0px 25px;">
                                                <div class="row">
                                                        <div class="col-md-12" style="text-align: center;">
                                                            <button class="btn btn-outline-primary" style="min-width: 290px;"><b>COMUNICAR FÉRIAS</b></button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
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