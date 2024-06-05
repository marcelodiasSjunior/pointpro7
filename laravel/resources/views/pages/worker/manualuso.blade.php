@extends('templates.worker')
@section('content')

<style>
          
          .video-container {
              position: relative;
              border: 1px solid #efefef !important;
              padding: 20px;
              margin: 0px 25px 80px;
              text-align: center;
          }
          .video-container iframe {
            width: 830px;
            min-height: 400px;
            background: #fff;
          }
          @media (max-width: 1120px){
            .video-container iframe {
              width: 100%;
              min-height: 400px;
              background: #fff;
            }
          }
          @media (max-width: 768px){
            .video-container {
                position: relative;
                border: 1px solid #efefef !important;
                padding: 20px 5px 60px;
                margin: 0px 0px;
            }
            .video-container iframe {
              width: 100%;
              min-height: 280px;
              background: #fff;
            }
          }
</style>

<div class="main-content">
          <div class="breadcrumb">
            <h1 class="me-2">Manual de utilização</h1>
          </div>
          <div class="separator-breadcrumb border-top"></div>
          <div class="row">
            <div class="col-md-12 mb-4">
              <div class="card text-start">
                <div class="card-body">
                  <h4 class="card-title mb-3">
                    <span class="text-primary" style="vertical-align: middle;">
                      <i class="i-Book" style="font-size: 26px;margin-right: 8px;"></i>
                    </span> Recursos e funcionalidades do sistema POINT PRO</h4>
                  <p>
                    Colaborador, consulte o manual de uso abaixo e esclareça suas dúvidas:
                  </p>
                  
                  <p class="mb-3 mt-4" style="font-size: 18px;"><b>Tópicos</b></p>

                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;"><a href="#receber-acesso">• Após receber as credênciais de acesso ao sistema.</a></p>
                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;"><a href="#realizando-atividades">• Realizando Atividades.</a></p>
                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;"><a href="#add-observacoes">• Adicionando Observações.</a></p>
                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;"><a href="#control-freq">• Como funciona o Controle de Frequência.</a></p>
                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;"><a href="#feedback">• Recebendo os Feedbacks.</a></p>
                  <p class="mb-2 mt-2" style="font-size: 16px;padding-left: 25px;padding-bottom: 60px;"><a href="#solicitar-suporte">• Solicitar Suporte.</a></p>


                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">


                  <div id="receber-acesso">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Após receber as credênciais de acesso ao sistema:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 01 Após receber as credênciais de acesso ao sistema  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">

                  <div id="realizando-atividades">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Realizando Atividades:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 02 Realizando Atividades  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">

                  <div id="add-observacoes">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Adicionando Observações:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 03 Adicionando Observações  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">

                  <div id="control-freq">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Como funciona o Controle de Frequência:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 04 Como funciona o Controle de Frequência  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">

                  <div id="feedback">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Recebendo os Feedbacks:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 05 Recebendo os Feedbacks  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                  <hr style="border-top: 1px solid rgb(0 0 0 / 40%);">

                  <div id="solicitar-suporte">
                    <p class="mb-2 mt-2" style="font-size: 16px;padding:60px 5px 30px 25px;"><b>• Solicitar Suporte:</b></p>
                      <div class="">
                        <div class="video-container">

                          <!-- LINK DO VÍDEO 6 Solicitar Suporte  -->
                          <iframe src="https://pointpro7.com/wp-content/uploads/2024/02/ScreenRecorderProject109.mp4" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                      </div>
                  </div>

                </div>
              </div>
            </div>
          </div> 
          <!-- end of row -->
        </div>
        <!-- =======   FIM MANUAL DE USO - EMPRESA   ======= -->


@endsection