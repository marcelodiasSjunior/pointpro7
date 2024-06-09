@extends('templates.company')
@section('content')



<!-- ============ Main content start ============= -->
<div class="main-content">

    <div class="breadcrumb">
        <h1 class="me-2">Adicionar uma atividade</h1>
        <ul>
            <li><a href="atividades-01-funcao.html">Progresso por Função</a></li>
            <li><a href="atividades-02-funcao-funcionario.html">Progresso por Funcionários</a></li>
            <li class="remove-pd-xs">Adicionar uma atividade</li>
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
                        </span> Adicionar atividades recorrentes
                    </h4>

                    <p class="">
                        Escolha a função para adicionar a <code><b>atividade recorrente</b></code>:
                    </p>
                    <form method="POST" action="/atividades/adicionar-nova">
                        @include('components.form-atividade')
                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- end of row -->
</div>
<!-- ======= Main content end ======= -->


<script>

$(function() {

    let qtdFuncionarios = '<?= count($funcionarios) ?>';

       if(qtdFuncionarios == 0) {
        Swal.fire({
            title: "Ação necessária!",
            text: "É necessário cadastrar ao menos um funcionário!",
            icon: "warning",
            showCloseButton: false,
            showCancelButton: false,
            focusConfirm: true,
            allowOutsideClick: false,
            closeOnEsc: false,
            allowEscapeKey : false,
            confirmButtonText: `Cadastrar funcionário`,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/funcionarios/adicionar-novo";
            }
        });
    }
    
});

</script>

@endsection
@include('components.scripts')