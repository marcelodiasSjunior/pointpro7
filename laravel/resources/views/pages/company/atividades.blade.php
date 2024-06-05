@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Atividades</h1>
        <ul>
            <li>Progresso</li>
            <li>Por Função</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de atividades
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

                    <p>
                        Acompanhe o progresso das <code><b>atividades por função</b></code>:
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
                                                        <th scope="col" style="min-width: 250px;">Progresso das Atividades</th>
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
                                                            <a class="text-primary me-2" style="font-size: 23px;" href="atividades/funcao/{{ $funcao->id }}">
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
                        <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">

                            <div style="margin:25px 0px;">
                                <form>
                                    <div class="row">
                                        <div class="col-md-2 form-group mb-3">
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
                                        <div class="col-md-2 form-group mb-3">
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
                                        <div class="col-md-2 form-group mb-3">
                                            <label for="picker1">Selecionar ano</label>
                                            <select class="form-control">
                                                <option>2024</option>
                                                <option>2023</option>
                                                <option>2022</option>
                                                <option>2021</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary" style="margin-top: 24px;">Pesquisar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class=" text-start">
                                    <div class="">

                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped ">
                                                <thead style="text-align: center;">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col" style="min-width: 150px;">Função</th>
                                                        <th scope="col" style="min-width: 250px;">Progresso das Atividades</th>
                                                        <th scope="col">Atividades</th>
                                                        <th scope="col">Funcionários</th>
                                                        <th scope="col">Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    <tr>
                                                        <th scope="row">-</th>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
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
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->



@endsection
