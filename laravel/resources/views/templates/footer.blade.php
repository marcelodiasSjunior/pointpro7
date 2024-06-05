<!-- Footer Start -->
<div class="flex-grow-1"></div>
<div class="app-footer">
    <div class="row">
        <div class="col-md-9">
            <p>
                <strong>Acompanhamento Profissional</strong>
            </p>
            <p>
                Aproveite o conjunto de recursos e funcionalidades para acompanhar funcionários no cotidiano profissional, <br class="hidden-br-footer">gerenciando funções, jornadas, atividades e tarefas dos colaboradores.
                <sunt></sunt>
            </p>
        </div>
    </div>

    <div style="margin: 0px 0px 30px;" class="visible-970">
        <a style="margin: 20px;" class="text-primary" href="/termosdeuso" target="_blank">Termos de uso</a>
        <a style="margin: 20px;" class="text-primary" href="/politicaprivacidade" target="_blank">Política de privacidade</a><br>
        <a style="margin: 20px;" class="text-primary" href="/manual">Manual de uso</a>
        <a style="margin: 20px;" class="text-primary" href="/suporte">Suporte</a>
    </div>

    <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
        <a style="margin: 0px 0px 30px;" class="btn btn-primary text-white btn-rounded" href="/assinatura">Assinatura</a>
        <div style="margin: 0px 0px 30px;" class="hidden-970">
            <a style="margin: 20px;" class="text-primary" href="/termosdeuso" target="_blank">Termos de uso</a>
            <a style="margin: 20px;" class="text-primary" href="/politicaprivacidade" target="_blank">Política de privacidade</a>
            <a style="margin: 20px;" class="text-primary" href="/manual">Manual de uso</a>
            <a style="margin: 20px;" class="text-primary" href="/suporte">Suporte</a>
        </div>
        <span class="flex-grow-1"></span>
        <div class="d-flex align-items-center">
            <img class="logo" src="{{ secure_asset('dist-assets/images/logo.svg') }}" alt="" />
            <div>
                <p class="m-0">&copy; PRO7 2024.</p>
                <p class="m-0">Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</div>
<!-- fotter end -->
<div class="loadscreen">
    <div class="loader">
        <img class="logo mb-3" src="{{ secure_asset('dist-assets/images/logo.svg') }}" style="display: none" alt="" />
        <div class="loader-bubble loader-bubble-primary d-block"></div>
    </div>
</div>

@include('components.scripts')