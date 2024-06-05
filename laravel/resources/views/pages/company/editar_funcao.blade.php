@extends('templates.company')
@section('content')


<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Editar Função</h1>
        <ul>
            <li><a href="funcoes.html">Funções cadastradas</a></li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Library" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Editar função e onboarding
                    </h4>
                    <p class="">
                        Edite a <code><b>função e o onboarding</b></code>:
                    </p>

                    <div class="">
                        <div style="margin:25px 0px;">

                            <div class="row">
                                <div class="col-md-2 form-group mb-3"></div>
                                <div class="col-md-8 form-group mb-3">
                                    <label for="basic-url"><code>Onboarding da função</code> - Adicione um arquivo PDF com a apresentação sobre a função e suas atividades - inicialização para novos colaboradores.</label>
                                    <div class="mb-3">
                                        <form class="dropzone dropzone-area" id="document-onboarding" action="/upload-pdf">
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

                            <form method="post" action="/funcoes/{{ $funcao->id }}/editar">
                                <div class="row">
                                    <div class="col-md-2 form-group mb-3"></div>
                                    <div class="col-md-8 form-group mb-3">
                                        <label for="basic-url">Nome da função</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="funcao-add">Nome</span>
                                            <input class="form-control" name="title" value="{{ $funcao->title }}" required type="text" placeholder="" aria-describedby="funcao-add" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group mb-3"></div>
                                </div>

                                <input name="onboarding" type="hidden" required id="input-onboarding" />



                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>ATUALIZAR FUNÇÃO</b></button>
                                    </div>
                                </div>

                                @csrf

                            </form>

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