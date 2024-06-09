@extends('templates.company')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">QRCode</h1>
        <ul>
            <li>QRCode</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> QRCode
                    </h4>

                    <p>
                        Imprima o QRCode para redirecionar os funcionarios <code><b>para o painel</b></code>:
                    </p>
                    {!! QrCode::size(400)->generate($url); !!}

                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->



@endsection