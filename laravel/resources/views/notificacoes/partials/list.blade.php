@forelse($notificacoes as $notificacao)
<div class="dropdown-item notification-item" data-id="{{ $notificacao->id }}">
    <div class="d-flex align-items-start">
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">{{ $notificacao->title }}</h6>
                <small class="text-muted">{{ $notificacao->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-0 text-muted">{{ $notificacao->description }}</p>
            @if($notificacao->ferias)
                <div class="mt-2">
                    <a href="{{ route('ferias.detalhes', $notificacao->ferias->id) }}" 
                       class="btn btn-sm btn-primary">Aprovar/Reprovar</a>
                </div>
            @endif
        </div>
    </div>
</div>
@empty
<div class="dropdown-item text-muted">
    Nenhuma nova notificação
</div>
@endforelse
