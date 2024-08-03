@extends('templates.admin')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Editar Usuario</h1>
        <ul>
            <li><a href="/usuarios">Usuarios cadastrados</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Administrator" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Editar novo usuario
                    </h4>
                    <p class="">
                        Editar um <code><b>usuario</b></code>:
                    </p>


                    <div class="">
                        <div style="margin:25px 0px;">

                            <div class="">
                                <div style="margin:25px 0px;">
                                    <form action="/usuarios/editar/{{ $user->id }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-2 form-group mb-3"></div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="select-company">Selecione a empresa:</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="select-company">Empresa</span>
                                                    <select class="form-control" name="company_id">
                                                        <option value="">TODOS</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{ $company->id }}" {{ $user->companyId == $company->id ? 'selected' : ''}}>{{ $company->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="nome-usuario-add">Nome</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="nome-usuario-add">Nome</span>
                                                    <input class="form-control" name="name" value="{{ $user->name }}" required type="text" placeholder="Nome completo" aria-describedby="nome-usuario-add" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 form-group mb-3"></div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="email-usuario-add">E-mail</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="email-usuario-add">E-mail</span>
                                                    <input class="form-control" name="email" value="{{ $user->email }}" required type="text" placeholder="nome@email.com.br" aria-describedby="email-usuario-add" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="senha-usuario-add">Senha</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="senha-usuario-add">Senha</span>
                                                    <input class="form-control" name="password" type="text" placeholder="" aria-describedby="senha-usuario-add" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 form-group mb-3"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" style="text-align: center;">
                                                <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ADICIONAR USUARIO</b></button>
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
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->


@endsection