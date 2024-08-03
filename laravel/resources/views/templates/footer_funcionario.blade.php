 <!-- Footer Start -->
 <div class="flex-grow-1"></div>
 <div class="app-footer">
     <div class="row">
         <div class="col-md-9">
             <p>
                 <strong>Acompanhamento Profissional</strong>
             </p>
             <p>
                 Aproveite o conjunto de recursos e funcionalidades para acompanhar e gerenciar sua frequência e suas atividades.
                 <sunt></sunt>
             </p>
         </div>
     </div>

     <div style="margin: 0px 0px 30px;" class="visible-970">
         <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="/termosdeuso" target="_blank">Termos de uso</a>
         <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="/politicaprivacidade" target="_blank">Política de privacidade</a><br>
         <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="/manual" target="_blank">Manual de uso</a>
         <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="suporte-funcionario.html">Suporte</a>
     </div>

     <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
         <div style="margin: 0px 0px 30px;" class="hidden-970">
            <a style="margin: 20px;" class="text-primary" href="/termosdeuso" target="_blank">Termos de uso</a>
            <a style="margin: 20px;" class="text-primary" href="/politicaprivacidade" target="_blank">Política de privacidade</a>
            <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="/manual" target="_blank">Manual de uso</a>
            <a style="margin: 20px 20px 20px 0px;" class="text-primary" href="suporte-funcionario.html">Suporte</a>
         </div>
         <span class="flex-grow-1"></span>
         <div class="d-flex align-items-center">
             <img class="logo" src="../../dist-assets/images/point_pro.svg" alt="" />
             <div>
                 <p class="m-0">&copy; POINT PRO 2024.</p>
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