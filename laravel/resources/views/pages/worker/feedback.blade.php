@extends('templates.worker')
@section('content')
<!-- ============ Main content start - Feedback DETALHES ============= -->
<div class="main-content">
   <div class="breadcrumb">
      <h1 class="me-2">Feedback</h1>
   </div>
   <div class="separator-breadcrumb border-top"></div>
   <div class="row">
      <div class="col-md-12 mb-4">
         <div class="card text-start">
            <div class="card-body">
               <h4 class="card-title mb-3">
                  <span class="text-primary" style="vertical-align: middle;">
                  <i class="i-Letter-Open" style="font-size: 26px;margin-right: 8px;"></i>
                  </span> Feedback das reuniões
               </h4>
               <p>
                  Acompanhe o retorno de informações das <code><b>reuniões</b></code>:
               </p>
               <div class="mx-auto col-md-10">
                  <div>
                     <h4 class="card-title mb-4 mt-5">Feedback:</h4>
                  </div>
                  <div class="documento-obs">
                     <div>
                        <h4><span class="documento-obs-nome text-danger">Última Interação:</span></h4>
                     </div>


                     @foreach($feedbacks as $row)
                        @if($row->sender_type === 1)
                            <div class="texto-observacao">
                                <h4>• Nome: <span class="documento-obs-nome">{{ $row->name}}</span></h4>
                                <h4>• Função: <span class="documento-obs-funcao">{{$funcao_title}}</span></h4>
                                <h4>• Data: <span class="documento-obs-data">{{date("d/m/Y",  strtotime($row->created_at))}}</span></h4>
                                <h4>• Hora: <span class="documento-obs-data">{{date("H:i",  strtotime($row->created_at))}}</span></h4>
                            <div>

                        {!! $row->message !!}
                            </div>
                            <div class="mt-3 mb-4 border-top"></div>
                        </div>
                        @else
                            <div class="texto-observacao">
                                <h4>• Nome: <span class="documento-obs-nome">{{ $row->name}}</span></h4>
                                <h4>• Data: <span class="documento-obs-data">{{date("d/m/Y",  strtotime($row->created_at))}}</span></h4>
                                <h4>• Hora: <span class="documento-obs-data">{{date("H:i",  strtotime($row->created_at))}}</span></h4>
                            <div>
                                {!! $row->message !!}
                            </div>
                        <div class="mt-3 mb-4 border-top"></div>
                        </div>
                        @endif
                        @endforeach

                  </div>
               </div>
               <form method="post" action="/feedback/{{ $funcionario_id }}">
               @csrf
               <div class="mx-auto col-md-10">
                  <div>
                     <h4 class="card-title mb-4 mt-5">Escreva o feedback:</h4>
                  </div>
                  <div id="full-editor">
                  </div>
                  <textarea name="message" style="display:none" id="hiddenAreaQuill" required></textarea>
                  <div style="text-align:center;">
                  <button type="submit" style="margin: 0px 0px 30px;" class="btn btn-lg btn-primary text-white btn-rounded">ENVIAR FEEDBACK</button>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->
<!--  Modal edit feedback -->
<div
   class="modal fade"
   id="editObservacao"
   tabindex="-1"
   role="dialog"
   aria-labelledby="editObservacaoLabel"
   aria-hidden="true"
   >
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
               Editar feedback
            </h5>
            <button
               class="btn btn-close"
               type="button"
               data-bs-dismiss="modal"
               aria-label="Close"
               ></button>
         </div>
         <div class="modal-body">
            <div class="mx-auto col-md-12">
               <div class="input-group mb-3">
                  <span class="input-group-text">Feedback</span>
                  <textarea rows="10" class="form-control" aria-label="With textarea" placeholder="Texto descritivo do feedback que será editado já vem carregado."></textarea>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button
               class="btn btn-secondary"
               type="button"
               data-bs-dismiss="modal"
               >
            CANCELAR
            </button>
            <button class="btn btn-primary ms-2" type="button">
            SALVAR
            </button>
         </div>
      </div>
   </div>
</div>
<!--  End Modal edit feedback -->
@endsection