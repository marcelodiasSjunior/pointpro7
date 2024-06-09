@extends('templates.company')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Adicionar Jornada</h1>
        <ul>
            <li><a href="jornadas.html">Jornadas cadastradas</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3 ">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Calendar" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Adicionar nova jornada
                    </h4>
                    <p class="">
                        Adicione uma nova <code><b>jornada</b></code>:
                    </p>

                    <div class="">
                        <div style="margin:25px 0px;">
                            <form method="post" action="/jornadas/adicionar-nova">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2 form-group mb-3"></div>
                                    <div class="col-md-8 form-group mb-3">
                                        <label for="basic-url">Nome da jornada</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Nome</span>
                                            <input class="form-control" type="text" name="title" required placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group mb-3"></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-2 form-group mb-3"></div>
                                    <div class="col-md-8 form-group mb-3">
                                        <label for="basic-url">Carga horaria semanal</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Segunda-feira</span>
                                            <input class="form-control" name="segunda" value="8" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Terca-feira</span>
                                            <input class="form-control" name="terca" value="8" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Quarta-feira</span>
                                            <input class="form-control" name="quarta" value="8" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Quinta-feira</span>
                                            <input class="form-control" name="quinta" value="8" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Sexta-feira</span>
                                            <input class="form-control" name="sexta" value="8" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Sabado</span>
                                            <input class="form-control" name="sabado" value="0" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Domingo</span>
                                            <input class="form-control" name="domingo" value="0" required type="number" min="0" max="24" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group mb-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ADICIONAR JORNADA</b></button>
                                    </div>
                                </div>
                            </form>
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