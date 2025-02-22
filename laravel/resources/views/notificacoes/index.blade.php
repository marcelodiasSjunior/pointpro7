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
                    <div class="alert alert-{{ $notificacao->lida ? 'secondary' : 'primary' }}">
                        <h5>{{ $notificacao->title }}</h5>
                        <p>{{ $notificacao->description }}</p>
                        <small>{{ $notificacao->created_at->diffForHumans() }}</small>
                    </div>
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
