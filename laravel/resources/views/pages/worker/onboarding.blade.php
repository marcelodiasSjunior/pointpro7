@extends('templates.onboarding-funcionario')
@section('content')


<div class="main-content-wrap d-flex flex-column">


    <!-- ============ Main content start ============= -->
    <div class="main-content">

        <div class="breadcrumb">
            <h1 class="me-2">Cadastrar Biometria</h1>
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="card text-start">
                    <div class="card-body">
                        <p>
                            Seja bem-vindo <code><b>{{ Auth::user()->name }}</b></code>, cadastre a sua biometria abaixo:
                        </p>

                        <div class="card-body">

                            @include('components.webcam')

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