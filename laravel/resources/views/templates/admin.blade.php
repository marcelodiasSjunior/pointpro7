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
                        <img src="../../dist-assets/images/faces/16.jpg" id="userDropdown" alt="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User me-1"></i> Karina Bronholo
                            </div>
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
                        <a class="nav-item-hold" href="/empresas"><i class="nav-icon i-Building"></i><span class="nav-text">Empresas </span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/usuarios"><i class="nav-icon i-Administrator"></i><span class="nav-text">Usuarios </span></a>
                        <div class="triangle"></div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-item-hold" href="#"><i class="nav-icon i-Letter-Open"></i><span class="nav-text">Reuniões</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="#"><i class="nav-icon i-Target"></i><span class="nav-text">Avaliações</span></a>
                        <div class="triangle"></div>
                    </li> -->
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->

        <div class="main-content-wrap sidenav-open d-flex flex-column">


            @include('components.success')
            @include('components.errors')
            @yield('content')

            @include('templates.footer')

        </div>

    </div>


    <div class="loadscreen">
        <div class="loader">
            <img class="logo mb-3" src="../../dist-assets/images/point_pro.svg" style="display: none" alt="" />
            <div class="loader-bubble loader-bubble-primary d-block"></div>
        </div>
    </div>

</body>

</html>