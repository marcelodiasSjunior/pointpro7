@extends('templates.company')
@section('content')


<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Perfil</h1>
        <ul>
            <li>Administrador</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>



    <div class="card user-profile o-hidden mb-4">
        <div class="header-cover" style="
                background-image: url('../../dist-assets/images/bg-perfil-padrao.jpg');
              "></div>
        <div class="user-info">
        @if(Auth::user()->avatar)
        <img class="profile-picture avatar-lg mb-2" src="{{ Auth::user()->avatar }}" alt="" />
        @else
        <img class="profile-picture avatar-lg mb-2" style="background-color:black" src="{{ secure_asset('dist-assets/images/faces/user-no-foto.png') }}" alt="" />
        @endif
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
                        <div class="col-md-3 col-6 text-center mb-4">
                            <i class="i-Email text-32 text-primary"></i>
                            <p class="text-16 mt-1 mb-0">E-MAIL</p>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="col-md-3 col-6 text-center mb-4">
                            <i class="i-ID-Card text-32 text-primary"></i>
                            <p class="text-16 mt-1 mb-0">CNPJ</p>
                            <span>{{ $company->cnpj }}</span>
                        </div>
                        <div class="col-md-3 col-6 text-center mb-4">
                        <i class="i-ID-Card text-32 text-primary"></i>
                            <p class="text-16 mt-1 mb-0">SEGMENTO</p>
                            <span>{{ $company->seguimento }}</span>
                        </div>
                        <div class="col-md-3 col-6 text-center mb-4">
                            <i class="i-Telephone text-32 text-primary"></i>
                            <p class="text-16 mt-1 mb-0">TELEFONE CONTATO</p>
                            <span>{{ $company->telefone }}</span>
                        </div>
                    </div>
                    <hr />

                    <div class="row">
                        <div class="col-md-3 col-6"></div>
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CEP
                                </p>
                                <span>{{ $company->cep }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    ENDEREÇO E NÚMERO
                                </p>
                                <span>{{ $company->endereco }}, {{ $company->numero }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    COMPLEMENTO
                                </p>
                                <span>{{ $company->complemento }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    BAIRRO
                                </p>
                                <span>{{ $company->bairro }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    CIDADE
                                </p>
                                <span>{{ App\Http\Services\CityService::getCity($company->city_id)['name'] }}</span>
                            </div>
                            <div class="mb-4">
                                <p class="text-primary mb-1">
                                    ESTADO
                                </p>
                                <span>{{ App\Http\Services\CityService::getState($company->state_id)['name'] }}</span>
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
                            <i class="i-Administrator" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Editar meus dados
                    </h4>
                    <p>
                        Você pode deixar seu <code><b>cadastro completo</b></code>:
                    </p>


                    <div class="accordion" id="accordionRightIcon">
                        <div class="card ul-card__v-space">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a class="text-default collapsed" data-bs-toggle="collapse" href="#accordion-item-icon-right-3">EDITAR CADASTRO</a>
                                </h6>
                            </div>
                            <div class="collapse" id="accordion-item-icon-right-3" data-parent="#accordionRightIcon">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-2 form-group mb-3"></div>
                                        <div class="col-md-8 form-group mb-3">
                                            <label for="foto-funcionario-add">Adicione uma foto</label>
                                            <div class="mb-3">
                                                <form class="dropzone dropzone-area" action="/upload-picture" method="post" id="edit-company-user">
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
                                    <!-- COMEÇO EDITAR CADASTRO -->
                                    <div class="">
                                        <div style="margin:25px 0px;">
                                            <form method="POST" action="/perfil">
                                                @csrf

                                                <input name="avatar" type="hidden" required id="company-user-avatar" />
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="nome-funcionario-add">Nome completo</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="nome-funcionario-add">Nome</span>
                                                            <input class="form-control" type="text" placeholder="" aria-describedby="nome-funcionario-add" value="{{ $user->name }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="cpf-funcionario-add">CNPJ</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="cpf-funcionario-add">CNPJ</span>
                                                            <input class="form-control" type="text" placeholder="000.000.000-00" aria-describedby="cpf-funcionario-add" value="{{$company->cnpj}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="telefone-funcionario-add">Telefone de contato</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="telefone-funcionario-add">Contato</span>
                                                            <input class="form-control"  type="text" placeholder="(00) 00000-0000" aria-describedby="telefone-funcionario-add"  value="{{$company->telefone}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label for="cep-funcionario-add">CEP</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="cep-funcionario-add">CEP</span>
                                                            <input class="form-control input-cep" name="cep" id="cep" type="text" placeholder="" aria-describedby="cep-funcionario-add" value="{{$company->cep}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="endereco-funcionario-add">Endereço</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="endereco-funcionario-add">Endereço</span>
                                                            <input class="form-control" id="endereco" name="endereco" type="text" placeholder="av. rua. travessa" aria-describedby="endereco-funcionario-add" value="{{$company->endereco}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="numero-endereco-funcionario-add">Número</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="numero-endereco-funcionario-add">Número</span>
                                                            <input class="form-control" id="numero" name="numero" type="text" placeholder="" aria-describedby="numero-endereco-funcionario-add"  value="{{$company->numero}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="complemento-endereco-funcionario-add">Complemento</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="complemento-endereco-funcionario-add">Complemento</span>
                                                            <input class="form-control" type="text" id="complemento" name="complemento" placeholder="" aria-describedby="complemento-endereco-funcionario-add"  value="{{$company->complemento}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="bairro-endereco-funcionario-add">Bairro</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="bairro-endereco-funcionario-add">Bairro</span>
                                                            <input class="form-control" id="bairro" name="bairro" type="text" placeholder="" aria-describedby="bairro-endereco-funcionario-add" value="{{$company->bairro}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="estado-funcionario-add">Estado</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="estado-funcionario-add">Estado</span>
                                                            <select class="form-control">
                                                                <option>SELECIONE</option>
                                                                @foreach($states as $state)
                                                               <option search="{{ $state['abbr'] }}" value="{{ $state['id'] }}" {{ isset($company) && $company->state_id === $state['id'] ? 'selected' : '' }}>{{ $state['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <label for="estado-funcionario-add">Cidade</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="estado-funcionario-add">Cidade</span>
                                                            <select class="form-control">
                                                                <option>SELECIONE</option>
                                                                @if(isset($cities))
                                                                @foreach($cities as $city)
                                                               <option value="{{ $city['id'] }}" {{ isset($company) && $company->city_id === $city['id'] ? 'selected' : '' }}>{{ $city['name'] }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <div class="mt-3 mb-4 border-top"></div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-8 form-group mb-3">
                                                        <p class="">
                                                            <b>Ao alterar suas credenciais de acesso como <code>e-mail</code> ou sua <code>senha</code>, recomendamos que as <code>guarde e envie</code> para um local seguro.</b>:
                                                        </p>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label for="email-funcionario-add">E-mail</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="email-funcionario-add">E-mail</span>
                                                            <input class="form-control" type="text" placeholder="nome@email.com.br" aria-describedby="email-funcionario-add" value="{{$user->email}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label for="senha-funcionario-add">Senha</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="senha-funcionario-add">Senha</span>
                                                            <input class="form-control" type="text" placeholder="" aria-describedby="senha-funcionario-add" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 form-group mb-3"></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12" style="text-align: center;">
                                                        <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ATUALIZAR CADASTRO</b></button>
                                                    </div>
                                                </div>

                                        </div>
                                        </form>
                                    </div>
                                    <!-- FIM DO EDITAR CADASTRO -->


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

<script>

$(function() {

  const cep = document.querySelector("input[name=cep]");
  
  cep.addEventListener('blur', e=> {
  		const value = cep.value.replace(/[^0-9]+/, '');
      const url = `https://viacep.com.br/ws/${value}/json/`;
      
      fetch(url)
      .then( response => response.json())
      .then( json => {
      		
          if( json.logradouro ) {
          	document.querySelector('input[name=endereco]').value = json.logradouro;
            document.querySelector('input[name=bairro]').value = json.bairro;
            document.querySelector('input[name=estado]').value = json.uf;
          }
      
      });
      
      
  });

    
});

</script>


@endsection
@include('components.scripts')

