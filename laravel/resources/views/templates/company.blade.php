<!DOCTYPE html>
<html lang="pt-br" dir="">

@include('templates.head')

<body class="text-start">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <div class="logo">
                <img src="{{ secure_asset('dist-assets/images/logo.svg') }}" alt="" />
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">
                <!-- Mega menu -->
                <div class="dropdown mega-menu d-none d-md-block">
                    <a href="#" class="btn text-muted dropdown-toggle me-3" id="dropdownMegaMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</a>
                    <div class="dropdown-menu text-start" aria-labelledby="dropdownMenuButton">
                        <div class="row m-0">
                            <div class="col-md-4 p-4 bg-img">
                                <h2 class="title">
                                    Sistema <br />
                                    <b>PRO7</b>
                                </h2>
                                <p style="font-size:12px;">
                                    Sistema de acompanhamento de atividades desempenhadas pelos funcionários.
                                    Aproveite o conjunto de recursos e funcionalidades para acompanhar funcionários no cotidiano profissional, gerenciando funções, jornadas, atividades e tarefas dos colaboradores.
                                </p>
                                <a class="btn btn-lg btn-rounded btn-outline-warning" href="https://pointpro7.com" target="_blank">
                                    Leia mais
                                </a>
                            </div>
                            <div class="col-md-4 p-4">
                                <p class="text-primary text--cap border-bottom-primary d-inline-block">Atalhos</p>
                                <div class="menu-icon-grid w-auto p-0">
                                    <a href="/painel"><i class="i-Bar-Chart"></i> Início</a>
                                    <a href="/manual"><i class="i-Book"></i> Manual</a>
                                    <a href="/suporte"><i class="i-Support"></i> Suporte</a>
                                    <a href="/atividades"><i class="i-Check"></i> Atividades</a>
                                    <a href="/observacoes"><i class="i-Speach-Bubbles"></i> Observações</a>
                                    <a href="/frequencia"><i class="i-Stopwatch"></i> Frequência</a>
                                </div>
                            </div>
                            <div class="col-md-4 p-4">
                                <p class="text-primary text--cap border-bottom-primary d-inline-block">Ferramentas</p>
                                <ul class="links">
                                    <li><a href="/onboarding">Onboarding</a></li>
                                    <li><a href="/funcoes">Funções</a></li>
                                    <li><a href="/jornadas">Jornadas</a></li>
                                    <li><a href="/funcionarios">Funcionários</a></li>
                                    <li><a href="/funcionarios">Feedback</a></li>
                                    <li><a href="/funcionarios">Avaliações</a></li>
                                </ul>
                                <div class="mt-3 mb-4 border-top"></div>
                                <ul class="links">
                                    <li><a href="/empresa">Empresa</a></li>
                                    <li><a href="/assinatura">Assinatura</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Mega menu -->

            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" id="userDropdown" alt="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        @else
                        <img src="{{ secure_asset('dist-assets/images/faces/user-no-foto.png') }}" id="userDropdown" alt="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User me-1"></i> {{ Auth::user()->name }}
                            </div>
                            <a class="dropdown-item" href="/perfil">Perfil</a>
                            <a class="dropdown-item" href="/empresa">Empresa</a>
                            <a class="dropdown-item" href="/assinatura">Assinatura</a>
                            <a class="dropdown-item" href="/logout">Desconectar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  MENU LATERAL NO PAINEL  -->
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
                        <a class="nav-item-hold" href="/frequencia"><i class="nav-icon i-Stopwatch"></i><span class="nav-text">Frequência</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/funcoes"><i class="nav-icon i-Library"></i><span class="nav-text">Funções</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/jornadas"><i class="nav-icon i-Calendar"></i><span class="nav-text">Jornadas</span></a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/funcionarios"><i class="nav-icon i-Administrator"></i><span class="nav-text">Funcionários</span></a>
                        <div class="triangle"></div>
                    </li>
                    @if(Auth::user()->company->plan === 1)
                    <li class="nav-item">
                        <a class="nav-item-hold" href="/qrcode"><i class="nav-icon i-Code-Window"></i><span class="nav-text">QRCode</span></a>
                        <div class="triangle"></div>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->

        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')

            @include('components.success')
            @include('components.errors')
            @include('templates.footer')
        </div>

    </div>


    </div>
</body>

</html>