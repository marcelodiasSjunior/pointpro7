@csrf
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-4 form-group mb-3">
        <div style="margin:25px 0px;max-width: 400px;">
            <label for="select-funcao">Selecione a função do funcionário*:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="select-funcao">Função</span>
                <select class="form-control" name="funcao_id" required>
                    <option value="">SELECIONE</option>
                    @foreach($funcoes as $funcao)
                    <option value="{{ $funcao->id }}" {{ isset($funcionario) && $funcao->id === $funcionario->funcao_id ? 'selected' : ''}}>{{ $funcao->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4 form-group mb-3">
        <div style="margin:25px 0px;max-width: 400px;">
            <label for="select-jornada">Selecione a jornada do funcionário*:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="select-jornada">Jornada</span>
                <select class="form-control" name="jornada_id" required>
                    <option value="">SELECIONE</option>
                    @foreach($jornadas as $jornada)
                    <option value="{{ $jornada->id }}" {{ isset($funcionario) && $jornada->id === $funcionario->jornada_id ? 'selected' : ''}}>{{ $jornada->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>


<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="nome-funcionario-add">Nome completo*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="nome-funcionario-add">Nome</span>
            <input class="form-control" required type="text" name="name" value="{{ old('name', isset($funcionario) ? $funcionario->user->name : '') }}" placeholder="" aria-describedby="nome-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="cpf-funcionario-add">CPF*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="cpf-funcionario-add">CPF</span>
            <input id="input-cpf" required class="form-control" type="text" name="cpf" value="{{ old('cpf', isset($funcionario) ? $funcionario->cpf : '') }}" placeholder="000.000.000-00" aria-describedby="cpf-funcionario-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="telefone-funcionario-add">Telefone celular*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="telefone-funcionario-add">Celular</span>
            <input class="form-control input-phone" required type="text" name="celular" value="{{ old('celular', isset($funcionario) ? $funcionario->celular : '') }}" placeholder="(00) 00000-0000" aria-describedby="telefone-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="telefone-funcionario-add">Telefone de contato*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="telefone-funcionario-add">Contato</span>
            <input class="form-control input-phone" type="text" name="telefone" value="{{ old('telefone', isset($funcionario) ? $funcionario->telefone : '') }}" placeholder="(00) 00000-0000" aria-describedby="telefone-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="estado-civil-funcionario-add">Estado Civil*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="estado-civil-funcionario-add">Estado Civil</span>
            <select class="form-control" name="estado_civil" required>
                <option>SELECIONE</option>
                @foreach(App\Http\Services\CommomDataService::getEstadoCivil() as $estadoCivil)
                <option value="{{  $estadoCivil['id'] }}" {{ old('estado_civil', isset($funcionario) ? $funcionario->estado_civil : '') === trim((string)$estadoCivil['id']) ? 'selected': '' }}>{{ $estadoCivil['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="grau-instrucao-funcionario-add">Grau de Instrução*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="grau-instrucao-funcionario-add">Grau de Instrução</span>
            <select class="form-control" name="grau_instrucao" required>
                <option>SELECIONE</option>
                @foreach(App\Http\Services\CommomDataService::getGrauInstrucao() as $grauInstrucao)
                <option value="{{ $grauInstrucao['id'] }}" {{ old('grau_instrucao', isset($funcionario) ? $funcionario->grau_instrucao : '') === (string)$grauInstrucao['id'] ? 'selected': '' }}>{{ $grauInstrucao['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="work-home-funcionario-add">Trabalha Home-Office?</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="work-home-funcionario-add">Trabalha Home-Office?</span>
            <select class="form-control" name="workHome" required>
                <option>SELECIONE</option>
                <option value="Sim" {{ isset($funcionario) && $funcionario->workHome === "Sim" ? 'selected' : '' }}>Sim</option>
                <option value="Não" {{ isset($funcionario) && $funcionario->workHome === "Não" ? 'selected' : '' }}>Não</option>
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="comorbidade-funcionario-add">Comorbidade</label>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>

<div class="row">
    <div class="col-md-2 form-group mb-2"></div>
    <div class="col-md-8 mb-2">
        <div class="flex-auto">
            @foreach(App\Http\Services\CommomDataService::getComorbidades() as $comorbidade)
            <div class="form-group">
                <label class="checkbox checkbox-info">
                    <input value="{{ $comorbidade['id'] }}" type="checkbox" name="comorbidade[]" {{ isset($funcionario) && in_array($comorbidade['id'], explode(',', $funcionario->comorbidade)) ? 'checked' : '' }} />
                    <span>{{ $comorbidade['name']}}</span>
                    <span class="checkmark"></span>
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="sexo-funcionario-add">Sexo*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="sexo-funcionario-add">Sexo</span>
            <select class="form-control" name="sexo" required>
                <option>SELECIONE</option>
                <option value="1" {{ old('sexo', isset($funcionario) ? $funcionario->sexo : '') === "1" ? 'selected' : '' }}>MASCULINO</option>
                <option value="2" {{ old('sexo', isset($funcionario) ? $funcionario->sexo : '') === "2" ? 'selected' : '' }}>FEMININO</option>
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="data-nascimento-funcionario-add">Data de nascimento*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="data-nascimento-funcionario-add">Data de nascimento</span>
            <input class="form-control input-date" required name="nascimento" value="{{ old('nascimento', isset($funcionario) ? $funcionario->nascimento : '') }}" type="text" placeholder="00/00/0000" aria-describedby="data-nascimento-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="data-nascimento-funcionario-add">Data de admissão*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="data-nascimento-funcionario-add">Data de admissão</span>
            <input class="form-control input-date" name="admission_date" value="{{ old('admission_date', isset($funcionario) ? $funcionario->admission_date : '') }}" type="text" placeholder="00/00/0000" aria-describedby="data-admission_date-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="nis-pis-pasep-funcionario-add">NIS (NIT/PIS/PASEP)*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="nis-pis-pasep-funcionario-add">NIS</span>
            <input class="form-control" type="text" name="nis" value="{{ old('nis', isset($funcionario) ? $funcionario->nis : '') }}" required placeholder="" aria-describedby="nis-pis-pasep-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-3 form-group mb-3">
        <label for="rg-funcionario-add">RG*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="rg-funcionario-add">RG</span>
            <input class="form-control" type="text" name="rg" value="{{ old('rg', isset($funcionario) ? $funcionario->rg : '') }}" required placeholder="" aria-describedby="rg-funcionario-add" />        </div>
    </div>
    <div class="col-md-3 form-group mb-3">
        <label for="orgao-emissor-funcionario-add">Órgão emissor*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="orgao-emissor-funcionario-add">Emissor</span>
            <input class="form-control" type="text" name="rg_emissor" value="{{ old('rg_emissor', isset($funcionario) ? $funcionario->rg_emissor : '') }}" required placeholder="" aria-describedby="orgao-emissor-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3">
        <label for="data-expedicao-funcionario-add">Data da expedição*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="data-expedicao-funcionario-add">Data</span>
            <input class="form-control input-date" type="text" name="rg_emissao" value="{{ old('rg_emissao', isset($funcionario) ? $funcionario->rg_emissao : '') }}" required placeholder="00/00/0000" aria-describedby="data-expedicao-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="nome-pai-funcionario-add">Nome do pai*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="nome-pai-funcionario-add">Nome do pai</span>
            <input class="form-control" type="text" name="nome_pai" value="{{ old('nome_pai', isset($funcionario) ? $funcionario->nome_pai : '') }}" required placeholder="" aria-describedby="nome-pai-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="nome-mae-funcionario-add">Nome da mãe*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="nome-mae-funcionario-add">Nome da mãe</span>
            <input class="form-control" type="text" name="nome_mae" value="{{ old('nome_mae', isset($funcionario) ? $funcionario->nome_mae : '') }}" required placeholder="" aria-describedby="nome-mae-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="titulo-eleitoral-funcionario-add">Nº do título eleitoral*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="titulo-eleitoral-funcionario-add">Nº do título eleitoral</span>
            <input class="form-control" type="text" name="titulo_eleitoral" value="{{ old('titulo_eleitoral', isset($funcionario) ? $funcionario->titulo_eleitoral : '') }}" required placeholder="" aria-describedby="titulo-eleitoral-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-4 form-group mb-3">
        <label for="zona-titulo-eleitoral-funcionario-add">Zona eleitoral*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="zona-titulo-eleitoral-funcionario-add">Zona eleitoral</span>
            <input class="form-control" type="text" name="zona_eleitoral" value="{{ old('zona_eleitoral', isset($funcionario) ? $funcionario->zona_eleitoral : '') }}" required placeholder="" aria-describedby="zona-titulo-eleitoral-funcionario-add" />        </div>
    </div>
    <div class="col-md-4 form-group mb-3">
        <label for="secao-titulo-eleitoral-funcionario-add">Seção eleitoral*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="secao-titulo-eleitoral-funcionario-add">Seção eleitoral</span>
            <input class="form-control" type="text" name="secao_eleitoral" value="{{ old('secao_eleitoral', isset($funcionario) ? $funcionario->secao_eleitoral : '') }}" required placeholder="" aria-describedby="secao-titulo-eleitoral-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-4 form-group mb-3">
        <label for="reservista-funcionario-add">Carteira de Reservista</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="reservista-funcionario-add">Carteira de Reservista</span>
            <input class="form-control" type="text" name="carteira_reservista" value="{{ isset($funcionario) && $funcionario->carteira_reservista ? $funcionario->carteira_reservista : '' }}" placeholder="" aria-describedby="reservista-funcionario-add" />
        </div>
    </div>
    <div class="col-md-4 form-group mb-3">
        <label for="serie-reservista-funcionario-add">Série da Reservista</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="serie-reservista-funcionario-add">Série da Reservista</span>
            <input class="form-control" type="text" name="serie_reservista" value="{{ isset($funcionario) && $funcionario->serie_reservista ? $funcionario->serie_reservista : '' }}" placeholder="" aria-describedby="serie-reservista-funcionario-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-4 form-group mb-3">
        <label for="cnh-funcionario-add">CNH Nº de registro </label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="cnh-funcionario-add">CNH</span>
            <input class="form-control" type="text" name="cnh_numero" value="{{ isset($funcionario) && $funcionario->cnh_numero ? $funcionario->cnh_numero : ''  }}" placeholder="" aria-describedby="cnh-funcionario-add" />
        </div>
    </div>
    <div class="col-md-4 form-group mb-3">
        <label for="categoria-cnh-funcionario-add">Categoria da CNH</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="categoria-cnh-funcionario-add">Categoria da CNH</span>
            <input class="form-control" type="text" name="cnh_categoria" value="{{ isset($funcionario) && $funcionario->cnh_categoria ? $funcionario->cnh_categoria : ''  }}" placeholder="" aria-describedby="categoria-cnh-funcionario-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-4 form-group mb-3">
        <label for="cep-funcionario-add">CEP*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="cep-funcionario-add">CEP</span>
            <input class="form-control input-cep" type="text" name="cep" value="{{ old('cep', isset($funcionario) ? $funcionario->cep : '') }}" required placeholder="" aria-describedby="cep-funcionario-add" />        </div>
    </div>
    <div class="col-md-6 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="endereco-funcionario-add">Endereço*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="endereco-funcionario-add">Endereço</span>
            <input class="form-control" type="text" name="endereco" value="{{ old('endereco', isset($funcionario) ? $funcionario->endereco : '') }}" required placeholder="av. rua. travessa" aria-describedby="endereco-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="numero-endereco-funcionario-add">Número</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="numero-endereco-funcionario-add">Número</span>
            <input class="form-control" type="text" name="numero" value="{{ isset($funcionario) && $funcionario->numero ? $funcionario->numero : ''  }}" placeholder="" aria-describedby="numero-endereco-funcionario-add" />
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
            <input class="form-control" type="text" name="complemento" value="{{ isset($funcionario) && $funcionario->complemento ? $funcionario->complemento : ''  }}" placeholder="" aria-describedby="complemento-endereco-funcionario-add" />
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="bairro-endereco-funcionario-add">Bairro*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="bairro-endereco-funcionario-add">Bairro</span>
            <input class="form-control" type="text" name="bairro" value="{{ old('bairro', isset($funcionario) ? $funcionario->bairro : '') }}" required placeholder="" aria-describedby="bairro-endereco-funcionario-add" />        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        <label for="estado-funcionario-add">Estado*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="estado-funcionario-add">Estado</span>
            <select class="form-control" name="state_id" required id="estados-select">
                <option>SELECIONE</option>
                @foreach($states as $state)
                <option search="{{ $state['abbr'] }}" value="{{ $state['id'] }}" {{ old('state_id', isset($funcionario) ? $funcionario->state_id : '') == $state['id'] ? 'selected' : '' }}>{{ $state['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>
<div class="row">
    <div class="col-md-2 form-group mb-3"></div>
    <div class="col-md-8 form-group mb-3">
        @if(isset($funcionario) && $funcionario->city_id)
        <input type="hidden" id="city_id_get" name="city_id_get" value="{{ $funcionario->city_id }}" />
        @endif
        <label for="estado-funcionario-add">Cidade*</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="estado-funcionario-add">Cidade</span>
            <select class="form-control" required name="city_id" id="cidades-select">
                <option>SELECIONE</option>
                @if(isset($cities))
                @foreach($cities as $city)
                <option value="{{ $city['id'] }}" {{ old('city_id', isset($funcionario) ? $funcionario->city_id : '') == $city['id'] ? 'selected' : '' }}>{{ $city['name'] }}</option>
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
            <b>Edite o <code>e-mail</code> ou a <code>senha</code> das Credenciais de Acesso do funcionário. <code>Guarde e envie</code> ao funcionário para que ele possa acessar o sistema e gerenciar suas atividades, tarefas e frequência.</b>:
        </p>
    </div>
    <div class="col-md-2 form-group mb-3"></div>
</div>

