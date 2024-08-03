@extends('templates.company')
@section('content')
<!-- ============ Main content start - Suporte Técnico ============= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="me-2">Suporte Técnico</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <style>
            .iframe-fix {
                overflow: hidden;
                width: 100%;
                height: 94vh;
                border: none;
                background-color: #fff;
                z-index: 20;
                border-radius: 10px;
            }

            .iframe-fix iframe {
                -webkit-overflow-scrolling: touch !important;
                overflow: scroll !important;
                width: 100%;
                height: 100%;
                border: none;
                margin-top: 0px;
            }
        </style>
        <div class="col-md-12 mb-4">
            <div class="card text-start mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Support" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Atendimento
                    </h4>
                    <p>
                        Solicite atendimento ao <code><b>Suporte Técnico</b></code>:
                    </p>
                </div>
            </div>
            <div class="iframe-fix" style="margin-top: -3px;">
                <iframe style="margin-top: -3px;" allow="autoplay" src="https://tawk.to/chat/651f625b6fcfe87d54b6f90e/1hc19gdf9"></iframe>
            </div>
        </div>
    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->

@endsection