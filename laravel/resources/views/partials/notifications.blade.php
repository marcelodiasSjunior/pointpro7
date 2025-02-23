<a class="text-primary position-relative d-inline-block mx-3" href="#" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.5rem; line-height: 1;">
    <i class="i-Bell header-icon"></i>
    @if($notificacoes->count() > 0)
        <span class="badge bg-danger position-absolute translate-middle" style="top: 15%; right: -10px; padding: 4px 6px; font-size: 0.65rem;">
            {{ $notificacoes->count() }}
        </span>
    @endif
</a>
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px;">
    <div class="dropdown-header">Notificações</div>
    @forelse($notificacoes as $notificacao)
        <a class="dropdown-item" href="#">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="i-Bell text-primary"></i>
                </div>
                <div>
                    <h6 class="mb-0">{{ $notificacao->title }}</h6>
                    <small class="text-muted">{{ $notificacao->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </a>
    @empty
        <a class="dropdown-item text-center" href="#">Nenhuma notificação encontrada.</a>
    @endforelse
    <div class="dropdown-footer text-center">
        <a href="{{ route('todas.notificacoes') }}">Ver todas</a>
    </div>
</div>