@extends('templates.company')
@section('content')


<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Dados da assinatura</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="card user-profile o-hidden mb-4">
        <div class="header-cover" style="
                background-image: url('../../dist-assets/images/bg-perfil-padrao.jpg');
              "></div>
        <div class="user-info">
            @if($company->logo)
            <img class="profile-picture avatar-lg mb-2" src="{{ $company->logo }}" alt="" style="border: 4px solid #d5d5d5;" />
            @endif

            <p class="m-0 text-24">{{ $company->title }}</p>
            <p class="text-muted m-0">{{ $company->seguimento }}</p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-2 form-group mb-3"></div>
                <div class="col-md-8 form-group mb-3">
                    <div class="mt-3 mb-4 border-top"></div>
                </div>
                <div class="col-md-2 form-group mb-3"></div>
            </div>

            <div class="tab-content" id="profileTabContent">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-4">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CNPJ
                                </p>
                                <span>{{ $company->cnpj }}</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-4">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    RAZÃO SOCIAL
                                </p>
                                <span>{{ $company->razao_social }}</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-4">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    PLANO
                                </p>
                                <span>{{ isset($company) && $company->plan === 1 ? 'Parceiro' : 'Especial' }}</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-4">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    DATA DE COMPRA
                                </p>
                                <span></span>
                            </div>
                        </div>

                        <div class="col-md-3 col-4">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    DATA DE VENCIMENTO
                                </p>
                                <span></span>
                            </div>
                        </div>
                       

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection