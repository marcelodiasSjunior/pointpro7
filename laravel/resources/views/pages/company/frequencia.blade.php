@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Frequência</h1>
        <ul>
            <li>Status</li>
            <li>Por Funcionário</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Stopwatch" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Controle de frequência
                    </h4>
                    <p>
                        Acompanhe o andamento da <code><b>frequência dos funcionários</b></code>:
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
                                                        <th scope="col" style="min-width: 200px;">Nome</th>
                                                        <th scope="col">Função</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Anexo</th>
                                                        <th scope="col">Frequência</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @foreach($funcionarios as $funcionario)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>{{ $funcionario->user->name }}</td>
                                                        <td>{{ $funcionario->funcao->title }}</td>
                                                        <td>
                                                            @if($funcionario->frequencias->count())
                                                            <span class="badge bg-success">Compareceu</span>
                                                            @elseif($funcionario->esta_de_ferias_hoje)
                                                            <span class="badge bg-warning">Férias</span>
                                                            @else
                                                            <span class="badge bg-danger">Não compareceu</span>
                                                            @endif
                                                        </td>
                                                        <td>-</td>
                                                        <td style="padding:4px 5px 0px;">
                                                            <a class="text-primary" style="font-size: 26px;" href="/frequencia/{{ $funcionario->id }}">
                                                                <i class="nav-icon i-Stopwatch fw-bold"></i>
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
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->

@endsection