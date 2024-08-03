@extends('templates.admin')
@section('content')

<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Cadastrar empresa</h1>
        <ul>
            <li>POINT PRO</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-2 form-group mb-3"></div>
        <div class="col-md-8 form-group mb-3">
            <label for="foto-funcionario-add">Adicione uma foto com a logomarca</label>
            <div class="mb-3">
                <form class="dropzone dropzone-area" action="/upload-picture" method="post" id="create-company">
                    <div class="fallback">
                        <input name="file" type="file" multiple="multiple" />
                    </div>
                    <div class="dz-message">Clique aqui ou solte o arquivo aqui para enviar</div>
                    @csrf
                </form>
            </div>
        </div>
        <div class="col-md-2 form-group mb-3"></div>
    </div>

    <form id="create-company-form" action="/empresas/cadastrar" method="POST">
        @include('components.form-empresa')
    </form>


</div>
@endsection