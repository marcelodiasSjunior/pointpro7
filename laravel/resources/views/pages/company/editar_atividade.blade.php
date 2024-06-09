@extends('templates.company')
@section('content')



<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Editar atividade</h1>
        <ul>
            <li><a href="atividades-01-funcao.html">Progresso por Função</a></li>
            <li><a href="atividades-02-funcao-funcionario.html">Progresso por Funcionários</a></li>
            <li class="remove-pd-xs">Editar atividade</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                        <span class="text-primary" style="vertical-align: middle;">
                            <i class="i-Check" style="font-size: 26px;margin-right: 8px;"></i>
                        </span> Editar atividades recorrentes
                    </h4>

                    <p class="">
                        Escolha a função para editar a <code><b>atividade recorrente</b></code>:
                    </p>
                    <form method="POST" action="/atividades/editar/{{ $atividade->id }}">
                        @include('components.form-atividade')
                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->
@endsection