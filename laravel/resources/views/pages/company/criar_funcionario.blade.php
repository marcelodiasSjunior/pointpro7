@extends('templates.company')
@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Adicionar Funcionário</h1>
        <ul>
        <li><a href="/funcionarios">Funcionários cadastrados</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Administrator" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Adicionar novo funcionário
                    </h4>
                    <p class="">
                        Adicione um novo <code><b>funcionário</b></code>:
                    </p>


                    <div class="">
                        <div style="margin:25px 0px;">

                            <div class="row">
                                <div class="col-md-2 form-group mb-3"></div>
                                <div class="col-md-8 form-group mb-3">
                                    <label for="foto-funcionario-add">Adicione uma foto</label>
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
                            <div class="">
                                <div style="margin:25px 0px;">
                                    <form action="/funcionarios/adicionar-novo" method="POST">
                                        <input type="hidden" id="input-logo" name="foto" val="" />
                                        @include('components.form-funcionario')
                                        <div class="row">
                                            <div class="col-md-2 form-group mb-3"></div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="email-funcionario-add">E-mail</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="email-funcionario-add">E-mail</span>
                                                    <input class="form-control" name="email" value="" required type="email" placeholder="nome@email.com.br" aria-describedby="email-funcionario-add""/>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group mb-3">
                                                <label for="senha-funcionario-add">Senha</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="senha-funcionario-add">Senha</span>
                                                    <input class="form-control" name="password" required type="text" placeholder="" aria-describedby="senha-funcionario-add" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 form-group mb-3"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" style="text-align: center;">
                                                <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ADICIONAR FUNCIONÁRIO</b></button>
                                            </div>
                                        </div>
                                    </form>
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

    let qtdFuncoes = '<?= count($funcoes) ?>';
    let qtdJornadas = '<?= count($jornadas) ?>';

       if(qtdFuncoes == 0 || qtdJornadas == 0) {
        Swal.fire({
            title: "Ação necessária!",
            text: "É necessário cadastrar ao menos uma função e uma jornada!",
            icon: "warning",
            showCloseButton: false,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnEsc: false,
            allowEscapeKey : false,
            confirmButtonText: `Cadastrar função`,
            cancelButtonText: 'Cadastrar jornada'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/funcoes/adicionar-nova";
            } else {
                window.location.href = "/jornadas/adicionar-nova";
            }
        });
    }

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
            document.querySelector('input[name=cidade]').value = json.localidade;
            document.querySelector('input[name=estado]').value = json.uf;
          }

      });


  });


});

</script>


@endsection
@include('components.scripts')
