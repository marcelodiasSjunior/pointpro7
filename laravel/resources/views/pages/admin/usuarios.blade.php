@extends('templates.admin')
@section('content')

<!-- ============ Body content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Painel Administrativo</h1>
        <ul>
            <li>POINT PRO</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>


    <div class="row" id="reunioes">
        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3 ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Building" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Gerenciamento de Usuarios
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Acompanhe os usuarios:
                            </p>
                            <div class="text-end w-50 float-end">
                                <a href="usuarios/cadastrar" class="btn btn-success btn-icon text-white">
                                    <span class="ul-btn__icon"><i class="i-Add"></i></span>
                                    <span class="ul-btn__text"> Cadastrar</span>
                                </a>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-hover table-striped ">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Cadastrado em</th>
                                        <th scope="col">Ultima atualizacao</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    @foreach($users as $user)
                                    <tr>
                                        <th scope="row">
                                            {{ $user->id }}
                                        </th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $user->updated_at->format('d/m/Y') }}</td>
                                        <td style="padding-bottom: 3px;">
                                            <a class="btn btn-primary ms-2" type="button" href="/usuarios/editar/{{ $user->id }}">
                                                EDITAR
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



    <!-- end of main-content -->
</div>
@endsection