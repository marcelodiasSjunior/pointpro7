@extends('templates.company')
@section('content')


<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Empresa</h1>
        <!--  <ul>
              <li><a href="">Dashboard</a></li>
              <li>Version 1</li>
            </ul> -->
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
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CNPJ
                                </p>
                                <span>{{ $company->cnpj }}</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    RAZÃO SOCIAL
                                </p>
                                <span>{{ $company->razao_social }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    TELEFONE
                                </p>
                                <span>{{ $company->phone }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CEP
                                </p>
                                <span>{{ $company->cep }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    ENDEREÇO
                                </p>
                                <span>{{ $company->endereco }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    NÚMERO
                                </p>
                                <span>{{ $company->numero }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    COMPLEMENTO
                                </p>
                                <span>{{ $company->complemento }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    BAIRRO
                                </p>
                                <span>{{ $company->bairro }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CIDADE
                                </p>
                                <span>
                                    @if($company->city_id)
                                    {{ App\Http\Services\CityService::getCity($company->city_id)['name'] }}
                                    @endif
                                </span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    ESTADO
                                </p>
                                <span>
                                    @if($company->state_id)
                                    {{ App\Http\Services\CityService::getState($company->state_id)['name'] }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Building" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Editar dados da empresa
                    </h4>
                    <p>
                        Você pode deixar o <code><b>cadastro completo</b></code>:
                    </p>


                    <div class="accordion" id="accordionRightIcon">
                        <div class="card ul-card__v-space">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a class="text-default collapsed" data-bs-toggle="collapse" href="#accordion-item-icon-right-3">EDITAR CADASTRO EMPRESA</a>
                                </h6>
                            </div>
                            <div class="collapse" id="accordion-item-icon-right-3" data-parent="#accordionRightIcon">
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
                                            <form id="create-company-form" action="/atualizar-empresa" method="POST">
                                                @include('components.form-empresa')
                                            </form>

                                        </div>

                                    </div>



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