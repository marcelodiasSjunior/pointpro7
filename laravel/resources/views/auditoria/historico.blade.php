@extends('templates.company')

@section('content')
<!-- ============ Main content start ============= -->
<div class="main-content">
    <!-- Your other content -->

    <!-- Modal -->
    <div class="modal fade show" id="auditoriaModal" tabindex="-1" aria-labelledby="auditoriaModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="auditoriaModalLabel">Histórico de Auditoria</h5>
                    <a href="{{ url()->previous() }}" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <div id="auditoriaContent">
                        @if($auditorias->isEmpty())
                            <p>Não há registros de auditoria para este período.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ação</th>
                                        <th>Data Alteração/Inclusão</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($auditorias as $auditoria)
                                        <tr>
                                            <td>{{ $auditoria->id }}</td>
                                            <td>{{ $auditoria->acao }}</td>
                                            <td>{{ $auditoria->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Fechar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============ Main content end ============= -->
@endsection