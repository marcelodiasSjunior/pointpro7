@extends('templates.create-company')
@section('content')



<div class="main-content-wrap d-flex flex-column">


    <!-- ============ Main content start ============= -->
    <div class="main-content">

        <div class="breadcrumb">
            <h1 class="me-2">Cadastrar Empresa</h1>
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="card text-start">
                    <div class="card-body">
                        <p>
                            Seja bem-vindo <code><b>{{ Auth::user()->name }}</b></code>, cadastre a sua empresa abaixo:
                        </p>

                        <div class="card-body">

                            <div class="">
                                <div style="margin:25px 0px;">

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
                                    <form id="create-company-form" action="/onboarding" method="POST">
                                        @include('components.form-empresa')
                                    </form>
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



</div>
@endsection

@include('components.scripts')