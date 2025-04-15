@extends('templates.company')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Notificações da Empresa {{ $company->name }}
                </div>

                <div class="card-body">
                    @forelse($notificacoes as $notificacao)
                    <form action="{{ route('notificacoes.marcarComoLida', $notificacao->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="alert alert-{{ $notificacao->lida ? 'secondary' : 'primary' }} w-100 d-flex align-items-start gap-3">
                            <input
                                type="checkbox"
                                class="mt-1"
                                onchange="this.form.submit()"
                                {{ $notificacao->lida ? 'checked' : '' }}
                            >
                            <div>
                                <h5>{{ $notificacao->title }}</h5>
                                <p>{{ $notificacao->description }}</p>
                                <small>{{ $notificacao->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </form>
                    @empty
                    <p>Nenhuma notificação encontrada.</p>
                    @endforelse

                    {{ $notificacoes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection