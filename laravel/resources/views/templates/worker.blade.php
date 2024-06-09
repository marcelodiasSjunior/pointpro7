<!DOCTYPE html>
<html lang="pt-br" dir="">

@include('templates.head')

<body class="text-start">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <div class="logo">
                <img src="{{ secure_asset('dist-assets/images/point_pro.svg') }}" alt="" />
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div style="margin: auto"></div>
            <div class="header-part-right">

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        @if(Auth::user()->funcionario && Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" id="userDropdown" alt="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        @else
                        <img src="{{ secure_asset('dist-assets/images/faces/user-no-foto.png') }}" id="userDropdown" alt="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User me-1"></i> {{ Auth::user()->name }}
                            </div>
                            <a class="dropdown-item" href="/perfil">Perfil</a>
                            <a class="dropdown-item" href="#" onCLick="novaBiometria()">Nova biometria</a>
                            <a class="dropdown-item" href="/logout">Desconectar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Painel </span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/atividades"><i class="nav-icon i-Check"></i><span class="nav-text">Atividades</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/observacoes"><i class="nav-icon i-Speach-Bubbles"></i><span class="nav-text">Observações</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/feedback"><i class="nav-icon i-Letter-Open"></i><span class="nav-text">Feedback</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/frequencia"><i class="nav-icon i-Stopwatch"></i><span class="nav-text">Frequência</span></a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->

        <!-- =============== Left side End ================-->

        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')

            @include('components.success')
            @include('components.errors')
            @include('templates.footer_funcionario')
        </div>

    </div>


    <div class="loadscreen">
        <div class="loader">
            <img class="logo mb-3" src="{{ secure_asset('dist-assets/images/point_pro.svg') }}" style="display: none" alt="" />
            <div class="loader-bubble loader-bubble-primary d-block"></div>
        </div>
    </div>

    <style>
        #webcamWrapper {
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        #webcam {
            width: 100%;
            max-width: 450px;
            margin-bottom: 40px;
        }

        #canvasWebcam {}
    </style>
</body>


<script>

function novaBiometria() {

    Swal.fire({
        title: "Ação necessária!",
        text: "Confirma o cancelamento da biometria atual, para cadastro de uma nova?",
        icon: "warning",
        showCloseButton: false,
        showCancelButton: true,
        focusConfirm: true,
        allowOutsideClick: true,
        closeOnEsc: true,
        allowEscapeKey : true,
        confirmButtonText: `Sim`,
        cancelButtonText: 'Não',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/nova-biometria";
            }
        });
    
}

</script>

</html>