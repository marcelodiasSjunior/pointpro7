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

    <div class="row" id="clientes">
        <div class="col-md-12 col-lg-12" style="margin-bottom: 40px;">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Building text-success"></i>
                                <h3 class="t-font-boldest">{{ $company_count }}</h3>
                                <span>Empresas Clientes</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Administrator text-primary"></i>
                                <h3 class="t-font-boldest">{{ $user_count }}</h3>
                                <span>Usuarios</span>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-lg-4 col-sm-6 col-6">
                            <div class="ul-widget__content-v4 card-icon-bg margin-xs-card">
                                <i class="i-Target text-danger"></i>
                                <h3 class="t-font-boldest">0</h3>
                                <span>Avaliações</span>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="row" id="reunioes">
        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3 ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Building" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Gerenciamento de Empresas Clientes
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Acompanhe as empresas clientes:
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="avaliacoes">
        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3 ">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Letter-Open" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Gerenciamento de Reuniões e Feedback
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Acompanhe as reuniões e feedbacks:
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-4 mt-4">
            <div class="card text-start">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title mb-3">
                                <span class="text-primary" style="vertical-align: middle;">
                                    <i class="i-Target" style="font-size: 26px;margin-right: 8px;"></i>
                                </span> Gerenciamento de Avaliações
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="">
                                Acompanhe as avaliações:
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- end of main-content -->
</div>
@endsection