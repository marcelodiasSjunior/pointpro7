@extends('templates.admin')
@section('content')

<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Editar empresa</h1>
        <ul>
            <li>POINT PRO</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @if($company->logo)
    <img src="{{ $company->logo }}" width="64" height="64" />
    @endif

    <div class="row">
        <div class="col-md-2 form-group mb-3"></div>
        <div class="col-md-8 form-group mb-3">
            <label for="foto-funcionario-add">Selecione uma logo para substituir a atual.</label>
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

    <form id="create-company-form" action="/empresas/editar/{{ $company->id }}" method="POST">
        @include('components.form-empresa')
    </form>


</div>
@endsection