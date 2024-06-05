<input type="hidden" id="input-logo" name="logo" val="" />
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="nome-empresa-add">Nome da empresa</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="nome-empresa-add">Nome</span>
            <input class="form-control" name="title" value="{{ isset($company) ? $company->title : '' }}" required type="text" placeholder="" aria-describedby="nome-empresa-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<!-- <div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="plano-add">Plano</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="plano-add">Plano</span>
            <select class="form-control" name="plano" required id="plano">
                <option value="">SELECIONE</option>
                <option value="1" {{ isset($company) && $company->plan === 1 ? 'selected' : '' }}>Parceiro</option>
                <option value="2" {{ isset($company) && $company->plan === 2 ? 'selected' : '' }}>Especial</option>
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div> -->
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="seguimento-empresa-add">Seguimento</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="seguimento-empresa-add">Seguimento</span>
            <input class="form-control" type="text" value="{{ isset($company) ? $company->seguimento : '' }}" name="seguimento" required placeholder="" aria-describedby="seguimento-empresa-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>

<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="razao-social-empresa-add">Razão social</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="razao-social-empresa-add">Razão social</span>
            <input class="form-control" type="text" value="{{ isset($company) ? $company->razao_social : '' }}" name="razao_social" required placeholder="" aria-describedby="razao-social-empresa-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>


<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="cnpj-empresa-add">CNPJ</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="cnpj-empresa-add">CNPJ</span>
            <input class="form-control" id="input-cnpj" type="text" value="{{ isset($company) ? $company->cnpj : '' }}" minlength="18" name="cnpj" required placeholder="000.000.000/0000-00" aria-describedby="cnpj-empresa-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>

<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="telefone-empresa-add">Telefone</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="telefone-empresa-add">Telefone</span>
            <input class="form-control input-phone" type="text" name="telefone" value="{{ isset($company) ? $company->telefone : '' }}" required placeholder="(00) 00000-0000" aria-describedby="telefone-empresa-add" />
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
            <input id="form-control input-cep" class="form-control" name="cep" value="{{ isset($company) ? $company->cep : '' }}" size="8" maxlength="8" minlength="8" required type="text" placeholder="" aria-describedby="cep-funcionario-add" />
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
            <input class="form-control" id="input-endereco" type="text" name="endereco" value="{{ isset($company) ? $company->endereco : '' }}" required placeholder="av. rua. travessa" aria-describedby="endereco-funcionario-add" />
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
            <select class="form-control" name="state_id" required id="estados-select">
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
            @if(isset($company) && $company->city_id)
            <input type="hidden" id="city_id_get" name="city_id_get" value="{{ $company->city_id }}" />
            @endif

            <span class="input-group-text" id="cidade-funcionario-add">Cidade</span>
            <select class="form-control" required name="city_id" id="cidades-select">
                <option value="">SELECIONE</option>
            </select>
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
            <input class="form-control" id="input-bairro" value="{{ isset($company) ? $company->bairro : '' }}" type="text" name="bairro" required placeholder="" aria-describedby="bairro-endereco-funcionario-add" />
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
            <input class="form-control" type="text" name="numero" value="{{ isset($company) ? $company->numero : '' }}" placeholder="" aria-describedby="numero-endereco-funcionario-add" />
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
            <input class="form-control" type="text" name="complemento" value="{{ isset($company) ? $company->complemento : '' }}" placeholder="" aria-describedby="complemento-endereco-funcionario-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>

<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <button type="submit" class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>GRAVAR DADOS EMPRESA</b></button>
    </div>
</div>
@csrf

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

@include('components.scripts')

