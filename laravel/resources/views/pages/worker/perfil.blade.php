@extends('templates.worker')
@section('content')

<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <div class="card user-profile o-hidden mb-4">
                        <div class="header-cover" style="background: linear-gradient(to right, #022851, #044874);"></div>
                        <div class="user-info">
                            @if($funcionario->foto)
                            <img class="profile-picture avatar-lg mb-2" src="{{ $funcionario->foto }}" alt="" />
                            @else
                            <img class="profile-picture avatar-lg mb-2" style="background-color:black" src="{{ secure_asset('dist-assets/images/faces/user-no-foto.png') }}" alt="" />
                            @endif
                            <p class="m-0 text-24">{{ $funcionario->user->name }}</p>
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
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-Library text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">FUNÇÃO</p>
                                            <span>{{ $funcionario->funcao->title }}</span>

                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-Calendar text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">JORNADA</p>
                                            <span>{{ $funcionario->jornada->total_semanal }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-Email text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">E-MAIL</p>
                                            <span>{{ $funcionario->user->email }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-ID-Card text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">CPF</p>
                                            <span>{{ $funcionario->cpf }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-Monitor-Vertical text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">TELEFONE CELULAR</p>
                                            <span>{{ $funcionario->celular }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-6 text-center mb-4">
                                            <i class="i-Telephone text-32 text-primary"></i>
                                            <p class="text-16 mt-1 mb-0">TELEFONE CONTATO</p>
                                            <span>{{ $funcionario->telefone }}</span>
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    DATA DE NASCIMENTO
                                                </p>
                                                <span>{{ $funcionario->nascimento }}</span>
                                            </div>
                                            
                                            <div class="mb-4">
                                             <p class="text-primary mb-1">
                                              DATA DE ADMISSÃO
                                              </p>
                                             <span>{{ $funcionario->admission_date }}</span>
                                             </div>

                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    ESTADO CIVIL
                                                </p>
                                                <span>{{ App\Http\Services\CommomDataService::findEstadoCivil($funcionario->estado_civil)['name'] }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    GRAU DE INSTRUÇÃO
                                                </p>
                                                <span>{{ App\Http\Services\CommomDataService::findGrauInstrucao($funcionario->grau_instrucao)['name'] }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    COMORBIDADE
                                                </p>
                                                <span>
                                                    @foreach(App\Http\Services\CommomDataService::findComorbidades($funcionario->comorbidade) as $comorbidade)
                                                    <p>{{ $comorbidade['name'] }}</p>
                                                    @endforeach
                                                </span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    Trabalha Home-Office
                                                </p>
                                                <span>{{ $funcionario->workHome === "Sim" ? "Sim" : "Não" }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    SEXO
                                                </p>
                                                <span>{{ $funcionario->sexo === "1" ? "Masculino" : "Feminino" }}</span>
                                            </div>

                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    NIS (NIT/PIS/PASEP)
                                                </p>
                                                <span>{{ $funcionario->nis }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-6">
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    RG
                                                </p>
                                                <span>{{ $funcionario->rg }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    ÓRGÃO EMISSOR
                                                </p>
                                                <span>{{ $funcionario->rg_emissor }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    DATA DE EXPEDIÇÃO
                                                </p>
                                                <span>{{ $funcionario->rg_emissao }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    Nº TÍTULO ELEITORAL
                                                </p>
                                                <span>{{ $funcionario->titulo_eleitoral }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    ZONA ELEITORAL
                                                </p>
                                                <span>{{ $funcionario->zona_eleitoral }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    SEÇÃO ELEITORAL
                                                </p>
                                                <span>{{ $funcionario->secao_eleitoral }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    NOME DA MÃE
                                                </p>
                                                <span>{{ $funcionario->nome_mae }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    NOME DO PAI
                                                </p>
                                                <span>{{ $funcionario->nome_pai }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    CNH Nº DE REGISTRO
                                                </p>
                                                <span>{{ $funcionario->cnh_numero }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    CATEGORIA DA CNH
                                                </p>
                                                <span>{{ $funcionario->cnh_categoria }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    CARTEIRA DE RESERVISTA
                                                </p>
                                                <span>{{ $funcionario->carteira_reservista }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    SÉRIE DA RESERVISTA
                                                </p>
                                                <span>{{ $funcionario->serie_reservista }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    CEP
                                                </p>
                                                <span>{{ $funcionario->cep }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    ENDEREÇO E NÚMERO
                                                </p>
                                                <span>{{ $funcionario->endereco }}, {{ $funcionario->numero }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    COMPLEMENTO
                                                </p>
                                                <span>{{ $funcionario->complemento }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    BAIRRO
                                                </p>
                                                <span>{{ $funcionario->bairro }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    CIDADE
                                                </p>
                                                <span>{{ App\Http\Services\CityService::getCity($funcionario->city_id)['name'] }}</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1">
                                                    ESTADO
                                                </p>
                                                <span>{{ App\Http\Services\CityService::getState($funcionario->state_id)['name'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div style="margin:25px 0px;">
                            <div class="row">
                                <div class="col-md-2 form-group mb-3"></div>
                                <div class="col-md-8 form-group mb-3">
                                    <label for="foto-funcionario-add">Adicione uma foto</label>
                                    <div class="mb-3">
                                        <form class="dropzone dropzone-area" action="/upload-picture" method="post" id="edit-worker-user">
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
                            <form action="/perfil" method="POST">
                                <input type="hidden" id="avatar" name="avatar" val="" />
                                @include('components.form-funcionario-worker')


                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ATUALIZAR CADASTRO</b></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
    <!-- ======= Main content end ======= -->


    @endsection