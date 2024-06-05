@extends('templates.company')
@section('content')


<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Observações</h1>
        <ul>
            <li><a href="/observacoes">Quantidade por Atividade</a></li>
            <li>Observações da Atividade</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Speach-Bubbles" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Observações da atividade
                    </h4>
                    <p>
                        Adicione informações sobre a atividade desempenhada:
                    </p>
                    <p class="obs-ativ text-primary">
                    {{ $atividade_description }}
                    </p>

                    <form method="post" action="/observacoes/{{ $atividade_funcionario_id }}/{{ $funcionario_id }}">
                        @csrf
                        <div>
                            <div class="mx-auto col-md-10">
                                <div id="full-editor">

                                </div>
                                <textarea name="message" style="display:none" id="hiddenAreaQuill" required></textarea>
                                <div style="text-align:center;">
                                    <button type="submit" style="margin: 0px 0px 30px;" class="btn btn-lg btn-primary text-white btn-rounded">ENVIAR OBSERVAÇÃO</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div>
                        <div class="mx-auto col-md-10">
                            <div>
                                <h4 class="card-title mb-4 mt-5">Observações da atividade:</h4>
                            </div>
                            <div class="documento-obs">
                                <div>
                                    <h4><span class="documento-obs-nome text-danger">Última Interação:</span></h4>
                                </div>
                                @foreach($observacoes as $observacao)
                                @if($observacao->sender_type === 1)
                                <div class="texto-observacao">
                                    <h4>• Nome: <span class="documento-obs-nome">{{ $observacao->sender->name }}</span></h4>
                                    <h4>• Função: <span class="documento-obs-funcao">{{ $observacao->funcionario->funcao->title }}</span></h4>
                                    <h4>• Data: <span class="documento-obs-data">{{ $observacao->data }}</span></h4>
                                    <h4>• Hora: <span class="documento-obs-data">{{ $observacao->hora }}</span></h4>
                                    <div>
                                        {!! $observacao->message !!}
                                    </div>
                                    <div class="mt-3 mb-4 border-top"></div>
                                </div>
                                @else
                                <div class="texto-observacao">
                                    <h4>• Nome: <span class="documento-obs-nome">{{ $observacao->sender->name }}</span></h4>
                                    <h4>• Data: <span class="documento-obs-data">{{ $observacao->data }}</span></h4>
                                    <h4>• Hora: <span class="documento-obs-data">{{ $observacao->hora }}</span></h4>
                                    <div>
                                        {!! $observacao->message !!}
                                    </div>
                                    <div class="mt-3 mb-4 border-top"></div>
                                </div>
                                @endif
                                @endforeach
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

<!--  Modal edit observacao -->
<div class="modal fade" id="editObservacao" tabindex="-1" role="dialog" aria-labelledby="editObservacaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Editar observação
                </h5>
                <button class="btn btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mx-auto col-md-12">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Observação</span>
                        <textarea rows="10" class="form-control" aria-label="With textarea" placeholder="Texto descritivo da observação que será editada já vem carregado."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                    CANCELAR
                </button>
                <button class="btn btn-primary ms-2" type="button">
                    SALVAR
                </button>
            </div>
        </div>
    </div>
</div>
<!--  End Modal edit observacao -->

@endsection