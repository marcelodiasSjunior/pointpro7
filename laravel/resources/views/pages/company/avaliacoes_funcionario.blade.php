@extends('templates.company')
@section('content')


        <!-- ============ Main content start - Feedback DETALHES ============= -->
        <div class="main-content">

          <div class="breadcrumb">
            <h1 class="me-2">Avaliações</h1>
          </div>

          <div class="separator-breadcrumb border-top"></div>

          <div class="row">

            <div class="col-md-12 mb-4">
              <div class="card text-start">
                <div class="card-body">
                  <h4 class="card-title mb-3">
                    <span class="text-primary" style="vertical-align: middle;">
                      <i class="i-Target" style="font-size: 26px;margin-right: 8px;"></i>
                    </span> Avaliações do colaborador
                  </h4>
                  <p>
                    Realize <code><b>avaliações</b></code> do colaborador:
                  </p>
                    
                  <div class="mx-auto col-md-10">
                    <div>
                      <style type="text/css">
                        .user-avaliacao img {
                          width: 85px;
                          height: 85px;
                          border-radius: 50%;
                          object-fit: cover;
                          float: right;
                        }
                        .user-avaliacao{
                          text-align: right;
                        }
                      </style>
                      <div class="user-avaliacao">
                       @if($funcionario->foto)
                        <img src="{{ $funcionario->foto}}" alt=""/>
                        @else
                        <img src="{{ secure_asset('dist-assets/images/faces/user-no-foto.png') }}" alt="">
                        @endif
                      </div>
                    </div>

                    <div style="margin-top:40px;">
                      <h5>• Nome: <span class="documento-obs-nome">{{$funcionario->nome}}</span></h5>
                      <h5>• Função: <span class="documento-obs-funcao">{{$funcao_title}}</span></h5>
                      <h5>• Data de admissão: <span class="documento-obs-data">{{$funcionario->admission_date ? date("d/m/Y",  strtotime($funcionario->admission_date)): 'Não preenchido.'}}</span></h5>
                    </div>

                    <hr style="border-top: 1px solid rgb(0 0 0 / 70%)!important;">

                    <div>
                      <h4 class="card-title mb-4 mt-3">Realize a avaliação:</h4>
                    </div>
                    
                    <div class="mb-5 mt-4">
                      <h5> Data da avaliação: <span class="documento-obs-data">{{$dayOfWeekHuman}} - {{$dayOfWeekName}}</span></h5>
                    </div>
                

                    <!--  COMEÇO DOS CRITÉRIOS  -->
                    <div class="mx-auto">
                      <div class="documento-obs">
                        <div>
                          <h4><span class="documento-obs-nome text-danger">Critérios de Avaliação:</span></h4>
                        </div>
                        <div class="texto-observacao">
                          <h5 style="margin-bottom: 10px!important;">Avalie o nível de intensidade da sua satisfação com os aspectos relacionados abaixo, sendo que: quanto maior a satisfação mais próxima do 10 deverá ser a sua nota. E quanto menor a satisfação, mas próximo do 1 deverá ser sua nota. 
                          </h5>
                          <h5 style="margin-bottom: 0px!important;">
                            <b>10</b> Acima de qualquer expectativa, um exemplo a ser seguido. 
                            <br><b>9</b> Excelente, sabe o que precisa para desempenhar seu papel. 
                            <br><b>8</b> Bom, desempenha corretamente suas atividades. 
                            <br><b>7</b> Desempenha corretamente, mas precisa de motivação da equipe/gestor para cumprir seu papel. 
                            <br><b>6</b> Desempenha seu papel com algumas falhas e não consegue motivar-se por conta própria. 
                            <br><b>5</b> Regular precisa entender melhor seu papel, ter mais empenho e mudar comportamento. 
                            <br><b>4</b> Ruim, comportamento abaixo da expectativa, precisa de mudanças rápidas. 
                            <br><b>3</b> Ruim, comportamento bem abaixo da expectativa, não esta correspondendo ao perfil desejado. 
                            <br><b>2</b> Péssimo, precisa de mudança de comportamento urgente. 
                            <br><b>1</b> Péssimo, reavaliar. 
                          </h5>
                        </div>
                      </div>
                    </div>
                    <!--  FIM DOS CRITÉRIOS  -->

                    <div>
                      <h4 class="card-title mb-4 mt-5">Adicione notas de acordo com os critérios acima e as competências abaixo:</h4>
                    </div>

                    <!-- COMEÇO DA TABELA -->
                    <form method="post" action="/avaliacoes/funcionario/{{ $funcionario_id }}">
                    @csrf
                    <div class="table-responsive">
                      <table class="table table-hover table-striped">
                        <thead style="text-align: left;">
                          <tr>
                            <th scope="col" style="min-width: 160px;font-size: 16px;">Competência</th>
                            <th scope="col" style="min-width: 180px;font-size: 16px;">Descrição</th>
                            <th scope="col" style="min-width: 90px;font-size: 16px;">Nota</th>
                          </tr>
                        </thead>
                        <tbody style="text-align: center;">
                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Pontualidade / Assiduidade</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Chega e sai nos horários estabelescidos. Avisa com antecedências possíveis atrasos ou saídas antecipadas. É pontual em reuniões e eventos.</td>
                            <td>
                              <div class="form-group mb-3">
                             <select class="form-control" name="competencia_1" id="competencia_1" required>                            
                                  <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>

                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;font-weight: 600;">Iniciativa / Pró-atividade</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Capacidade de antecipar-se, não espera determinações. Apresenta sugestões pertinentes com frequência. Tem iniciativa para conhecer atividades diversas das que executa.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_2" id="competencia_2" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;font-weight: 600;">Relacionamento</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Se relaciona bem com clientes internos e externos.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_3" id="competencia_3" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 
                          
                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;">Organização</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Elabora cronograma de atividades, definindo prazos e prioridades. Executa suas atividades de maneira lógica e objetiva, de forma a serem facilmente compreendidas e continuadas por terceiros em caso de necessidade.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_4" id="competencia_4" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Metas</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Cumpre todas as metas estabelecidas. Contribui decisivamente e com contínuo esforço para o alcance ou a superação de suas metas e as da empresa.</td>
                            <td>
                              <div class="form-group mb-3">
                               <select class="form-control" name="competencia_5" id="competencia_5" required>                            
                               <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Qualidade do serviço / Atenção</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Desenvolve seu trabalho de acordo com os requisitos. Entrega trabalhos completos, revisados e corretos. Presta atenção no que faz e toma providências para não haver erros, quando esses ocorrem, atua de modo a evitar sua reincidência.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_6" id="competencia_6" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Postura Profissional </td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Apresenta um bom marketing pessoal, honestidade, discrição, aparência adequada. Uniforme adequado, asseio e maquiagem.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_7" id="competencia_7" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 
                          
                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Conhecimento / Desenvolvimento profissional</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Conhece profundamente as atividades inerentes à sua função. Interessa-se em manter-se atualizado sobre os assuntos do seu setor. Participa de cursos, treinamentos e outros eventos de capacitação e atualização necessários à função que exerce.</td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_8" id="competencia_8" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                          <tr>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">Liderança</td>
                            <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;">Capacidade de engajar a equipe. Consegue persuadir e influenciar a equipe na conquista dos objetivos. A equipe a considera um(a) ótimo(a) líder. </td>
                            <td>
                              <div class="form-group mb-3">
                                <select class="form-control" name="competencia_9" id="competencia_9" required>                            
                                <option value="10" selected>10</option>
                                  <option value="9">9</option>
                                  <option value="8">8</option>
                                  <option value="7">7</option>
                                  <option value="6">6</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                                </select>
                              </div>
                            </td>
                          </tr> 

                        </tbody>
                      </table>
                    </div>
                    <!-- FIM DA TABELA -->

                    <div class="mx-auto">
                      <div>
                        <h4 class="card-title mb-4 mt-5">Adicione comentários para esta avaliação:</h4>
                      </div>
                      <div id="full-editor">
                     </div>
                     <textarea name="message" style="display:none" id="hiddenAreaQuill" required></textarea>
                      </div>
                    </div>

                    <div style="text-align:center;">
                    <button type="submit" style="margin: 0px 0px 30px;" class="btn btn-lg btn-primary text-white btn-rounded">REGISTRAR AVALIAÇÃO</button>
                    </div>
                    </form>

                  </div>

                  
                  <div class="mx-auto col-md-10">
                    <hr style="border-top: 1px solid rgb(0 0 0 / 70%)!important;">
                    <div>
                      <h4 class="card-title mb-4 mt-5">Avaliações realizadas:</h4>
                    </div>
                    <div id="full-editor">
                      
                    </div>
                  </div>

                  <div class="mx-auto col-md-10">
                    <div class="row">

                     
                      @if(count($avaliacoes) > 0)

                      @foreach($avaliacoes as $row)
                      <div class="col-md-4">
                        <div class="documento-obs">
                          <div style="text-align:center;">
                            <h4 class="text-primary" style="text-align:center;font-size: 18px;font-weight: bold;">Avaliação de: <span class="documento-obs-nome text-danger">{{date("d/m/Y",  strtotime($row->created_at))}}</span></h4>
                          </div>
                          <div class="texto-observacao">
                            <!-- COMEÇO DA TABELA -->
                              <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                  <thead style="text-align: left;">
                                    <tr>
                                      <th scope="col" style="min-width: 160px;font-size: 16px;">Competência</th>
                                      <th scope="col" style="text-align:center!important;min-width: 90px;font-size: 16px;">Nota</th>
                                    </tr>
                                  </thead>
                                  <tbody style="text-align: center;">
                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Pontualidade / Assiduidade
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_1}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;font-weight: 600;">
                                        Iniciativa / Pró-atividade
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_2}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;font-weight: 600;">
                                        Relacionamento
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_3}}</td>
                                    </tr> 
                                    
                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important; text-decoration: underline;">
                                        Organização
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_4}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Metas
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_5}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Qualidade do serviço / Atenção
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_6}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Postura Profissional 
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_7}}</td>
                                    </tr> 
                                    
                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Conhecimento / Desenvolvimento profissional
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_8}}</td>
                                    </tr> 

                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;text-decoration: underline;font-weight: 600;">
                                        Liderança
                                      </td>
                                      <td style="text-align:center;font-weight: 600;">{{$row->competencia_9}}</td>
                                    </tr> 
                                    
                                    <!-- MÉDIA DAS NOTAS - SOMA TODAS AS NOTAS E DIVIDE POR 9 ITENS/COMPETÊNCIAS -->
                                    <tr>
                                      <td style="text-align:left;border-right: 1px solid rgb(0 0 0 / 10%)!important;font-size: 18px;font-weight: 600;">
                                        Média >>>>>>>
                                      </td>
                                      <td style="text-align:center;font-weight: 600;font-size: 18px;">{{$row->media}}</td>
                                    </tr> 

                                  </tbody>
                                </table>
                              </div>
                              <!-- FIM DA TABELA -->
                              <div>
                                <p style="font-size:12px;">
                                   <span style="font-weight:bold;">Comentário:</span><br>  {!! $row->message !!}    
                                </p>
                              </div>
                          </div>
                        </div>
                      </div>
                      @endforeach

                      @else 
                      <div class="col-md-4">
                        <div class="documento-obs">
                          <div style="text-align:center;">
                            <h4 class="text-primary" style="text-align:center;font-size: 18px;font-weight: bold;"><span>Não há avaliação realizada</span></h4>
                          </div>
                          <div class="texto-observacao">
                            <div>
                              <p style="font-size:12px;margin-bottom: -11px;">
                                 <span style="font-weight:bold;">Realize uma avaliação deste colaborador para que ela apareça aqui.  </span>  
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                    

                    </div>
                  </div>


                  <div class="mx-auto col-md-10">
                    <hr style="border-top: 1px solid rgb(0 0 0 / 70%)!important;">
                    <div>
                      <h4 class="card-title mb-4 mt-5">Nota média das Avaliações realizadas:</h4>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="card mb-4">
                          <div class="card-body">
                            <div class="card-title">Nota Média Geral: <span style="font-weight:bold;">{{$media_geral}}</span></div>
                            @if($avaliacoes->count() >= 1) 
                            <div id="linha" style="width: 1200px; height: 300px;"></div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

              </div>
            </div>

          </div> 
          <!-- end of row -->
        </div>
        <!-- ======= Main content end ======= -->

        <div class="loadscreen">
      <div class="loader">
        <img
          class="logo mb-3"
          src="../../dist-assets/images/point_pro.svg"
          style="display: none"
          alt=""
        />
        <div class="loader-bubble loader-bubble-primary d-block"></div>
      </div>
    </div>




@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
 
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Média", "Média do funcionário",{ role: 'annotation' }],
       
        <?php
 
        foreach($avaliacoes as $avaliacao) {
            $media = $avaliacao->media;
       
         ?>
 
        ["<?php echo $media ?>", <?php echo $media ?>,<?php echo $media ?>],
      
       
 
      <?php  }?>
 
      ]);
 
      
      var options = {
          title: 'Comparação da média do funcionário',
          curveType: 'none',
          legend: { position: 'bottom' }
        };
 
        var chart = new google.visualization.LineChart(document.getElementById('linha'));
 
        chart.draw(data, options);
  }
  </script>
  
    
</script>