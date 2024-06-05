@extends('templates.company')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Jornadas</h1>
        <!--  <ul>
    <li><a href="">Dashboard</a></li>
    <li>Version 1</li>
  </ul> -->
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 w-50 float-start ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Calendar" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Gerenciamento de jornadas
                    </h4>
                    <div class="dropdown dropleft text-end w-50 float-end">
                        <button class="btn btn-success btn-icon text-white" id="dropdownMenuButton_table2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 111px;margin-bottom: 10px!important;">
                            <span class="ul-btn__icon">
                                <i class="i-Add"></i>
                            </span>
                            <span class="ul-btn__text"> Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_table2">
                            <a class="dropdown-item" href="/jornadas/adicionar-nova">Adicionar nova Jornada</a>
                        </div>
                    </div>
                    <p class="w-50">
                        Realize a gestão do cadastro das <code><b>jornadas</b></code>:
                    </p>



                    <div class="">

                        @if($jornadas->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped ">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome da Jornada</th>
                                        <th scope="col">Descrição da Jornada</th>
                                        <th scope="col">Editar</th>
                                        <th scope="col">Apagar</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    @foreach($jornadas as $jornada)
                                    <tr>
                                        <th scope="row">{{ $jornada->id }}</th>
                                        <td>{{ $jornada->title }}</td>
                                        <td>{{ $jornada->description }}</td>
                                        <td style="padding-bottom: 3px;">
                                            <a class="text-warning me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="nav-icon i-Pen-5 fw-bold"></i>
                                            </a>
                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                <a class="dropdown-item ul-widget__link--font" href="/jornadas/{{ $jornada->id}}/editar">Editar</a>
                                            </div>
                                        </td>
                                        <td style="padding-bottom: 3px;">
                                            <a class="text-danger me-2" style="font-size: 26px;" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="nav-icon i-Close-Window fw-bold"></i>
                                            </a>
                                            <div class="dropdown-menu menu-opcoes" x-placement="bottom-start">
                                                <a class="dropdown-item ul-widget__link--font" href="/jornadas/{{ $jornada->id}}/deletar">Apagar</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-dismissible fade show alert-card alert-info" role="alert">
                            <strong class="text-capitalize">Nenhuma jornada cadastrada</strong>
                        </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->

@endsection