@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Observações</h1>
        <ul>
            <li>Quantidade</li>
            <li>Por Atividade</li>
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
                        Realize a gestão de informações para cada atividade de seus colaboradores:
                    </p>

                    <form>
                        <div class="">
                            <div style="margin:25px 0px;max-width: 400px;">
                                <label for="select-funcao">Selecione a função:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="select-funcao">Função</span>
                                    <select class="form-control" name="funcao_id" onchange="this.form.submit()">
                                        <option value="">TODAS</option>
                                        @foreach($funcoes as $funcao)
                                        <option value="{{ $funcao->id }}" {{ $funcao_id == $funcao->id ? 'selected' : ''}}>{{ $funcao->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

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
                                                        <th scope="col">ID Atividade</th>
                                                        <th scope="col">Função</th>
                                                        <th scope="col" style="min-width: 270px;">Atividade</th>
                                                        <th scope="col" style="min-width: 200px;">Última Interação</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Observações</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @foreach($atividades as $atividade)
                                                    @if($atividade->observacoes->count() > 0)
                                                    <tr>
                                                        <th scope="row">{{ $atividade->id }}</th>
                                                        <td>{{ $atividade->funcao->title }}</td>
                                                        <td>{{ $atividade->description }}</td>
                                                        <td>
                                                            @if($atividade->observacoes->count() > 0)
                                                            {{ $atividade->observacoes->first()->sender->name ?? 'N/A' }}
                                                            @else
                                                            Nenhuma mensagem enviada ou recebida
                                                            @endif
                                                        </td>
                                                        <td>{{ $dayOfWeekHuman }}</td>
                                                        <td style="padding-bottom: 3px;">
                                                            <a class="text-primary badge-top-container" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                                <span class="badge bg-danger">{{ $atividade->observacoes->count() }}</span>
                                                                <i class="i-Speach-Bubbles fw-bold text-primary header-icon" style="font-size: 33px;"></i>
                                                            </a>
                                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                                <a class="dropdown-item ul-widget__link--font" href="/observacoes/view/{{ $atividade->id }}">Observações da Atividade</a>
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
                                                        <th scope="col">Função</th>
                                                        <th scope="col" style="min-width: 270px;">Atividade</th>
                                                        <th scope="col" style="min-width: 200px;">Última Interação</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Observações</th>
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
