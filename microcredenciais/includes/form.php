<hr>
<h4>Avaliação - Microcredenciais [<?php echo $proj->programa; ?>]: <?php echo ucfirst($proj->nome); ?>

<a href="."                                               class="btn btn-warning btn-sm float-right" > ↩️ Voltar</button>  <a href="./docs/<?php echo $proj->link; ?>" target="_blank" class="btn btn-success btn-sm float-right">📃</a>

</h4>
  

<form method="post">
    <table class="table table-striped">
      
        <tr>
            <th>1</th>
            <td><strong>Convergência com a PECTI e ODS </strong> <span style="float: right;">(Pontuação máxima: 10)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>O projeto se alinha às diretrizes da Política Estadual de Ciência, Tecnologia e Inovação (PECTI)? 
                        <!-- <p>a) Sobre as diretrizes:  -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Identificar se a proposta atende às áreas descritas no edital: <br>
                                    <p><u>Áreas prioritárias</u>: (Agricultura e Agronegócios; Biotecnologia e saúde; Energias sustentáveis/renováveis; Cidades inteligentes; Sociedade, educação e economia); </p>
                                    <p><u>Áreas transversais</u>: transformação digital e desenvolvimento sustentável.</p></li>
                                <li>Verificar se a proposta busca fortalecer a formação do capital humano, a modernização da gestão pública ou a ampliação da qualificação profissional, contribuindo para o desenvolvimento econômico e social do estado</li>
                            </ul>
                        </div>
                        <!-- </p>                       -->
                    </li>
                    
                    <li>O projeto contribui para indicadores e metas dos Objetivos de Desenvolvimento Sustentável (ODS)? 
                        <div class="alert alert-info col">
                          Clique <a href="./resumo-ods.pdf" target="_blank" class=" ">📃</a>  para ver resumido os objetivos, indicadores e metas da ODS (os destacados são os que contribuem diretamente para atender à EG do edital interno)
                        </div>                        
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn1" name="qn1" min="0" max="10" step="1" value="<?php echo $pontuacao->qn1; ?>" onchange="atualizarValor(this)"> <label for="qn1"><?php echo $pontuacao->qn1; ?></label>
                </div>
            </td>
        </tr>
        
        <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>2</th>
            <td><strong>Relevância e impacto do projeto </strong> <span style="float: right;">(Pontuação máxima: 25)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>O projeto se alinha às diretrizes da Política Estadual de Ciência, Tecnologia e Inovação (PECTI)? 
                        <div class="alert alert-info col">
                            <ul>
                                <li>Identificar se a proposta atende às áreas descritas no edital: <br>
                                    <p><u>Geral</u> - Fomentar a qualificação e requalificação profissional, visando a empregabilidade, o desenvolvimento socioeconômico do Paraná, o aprimoramento da gestão pública e a inovação. </p>
                                    <p><u>Específicos</u> -  qualificar para a modernização da gestão pública e para o fortalecimento do setor produtivo; uso de metodologias inovadoras; capacitação contínua. </p></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li>Há evidências da relevância do projeto para o desenvolvimento regional e/ou a modernização da gestão pública? 
                        <!-- <p>b) Quanto à relevância -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>A proposta aponta para possíveis impactos educacionais, sociais ou econômicos para o Estado?</li>
                                <li>Sua implementação:  Impulsiona a formação de capital humano mais qualificado?; (e/ou) Fortalece a inovação?;  (e/ou)  Promove o desenvolvimento mais sustentável?</li>
                            </ul>
                        </div>    
                        </div><!-- </p>                       -->                    
                    </li>
                    <li>A proposta apresenta indicadores mensuráveis de impacto e melhoria na qualificação profissional? 
                        <!-- <p>c) Os indicadores devem permitir verificar, por exemplo: -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Número de participantes capacitados (antes e depois da ação);</li>
                                <li>Melhoria no desempenho técnico ou prático dos envolvidos (medido por avaliações, testes ou relatórios);</li>
                                <li>Possibilidade inserção ou reinserção no mercado de trabalho ou qualificação da atuação profissional;</li>
                                <li>Competências ou reconhecimentos obtidos;</li>
                                <li>Qualidade do trabalho ou qualidade social/ambiental pelos participantes após o projeto;</li>
                                <li>Feedback dos participantes sobre a utilidade da formação recebida;</li>
                                <li>Dê atenção especial à existência de métodos de coleta de dados (questionários, entrevistas, registros, etc.) que comprovem esses indicadores e à coerência entre os objetivos do projeto e os resultados esperados.</li>
                            </ul>
                            
                        </div><!-- </p>                       -->
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn2" name="qn2" min="0" max="25" step="1" value="<?php echo $pontuacao->qn2; ?>" onchange="atualizarValor(this)"> <label for="qn2"><?php echo $pontuacao->qn2; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>3</td>
            <td><strong>Clareza dos objetivos e metas </strong> <span style="float: right;">(Pontuação máxima: 15)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>Os objetivos do projeto são claros, mensuráveis e alcançáveis? 
                        <!-- <p>a) Quanto aos objetivos:  -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Estão formulados de maneira clara e compreensível?</li>
                                <li>São específicos e direcionados para a qualificação profissional?</li>
                                <li>Permitem avaliar seu alcance por meio de dados concretos?</li>
                                <li>São alcançáveis dentro do tempo estabelecido no projeto?</li>
                            </ul>
                        </div><!-- </p>                       -->
                    </li>
                    
                    <li>As metas e indicadores propostos são adequados para avaliar o sucesso do projeto? 
                        <!-- <p>b) No tocante às metas e indicadores:  -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>As metas propostas estão bem definidas e relacionadas diretamente aos objetivos?</li>
                                <li>Os indicadores apresentados são adequados para prever o sucesso do projeto?</li>
                                <li>Os indicadores permitem verificar impacto e melhoria na qualificação profissional?</li>
                                <li>Há clareza sobre os meios de verificação e a metodologia para coleta dos indicadores?</li>
                            </ul>
                        </div><!-- </p>                       -->                          
                    </li>

                    <li>Há coerência entre os objetivos, atividades e os resultados esperados? 
                        <!-- <p>c) Sobre a coerência:  -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>As atividades previstas são coerentes com os objetivos estabelecidos?</li>
                                <li>O curso e ações de formação propostos contribuem diretamente para os objetivos do projeto?</li>
                                <li>Os resultados esperados estão alinhados com os objetivos e com as ações planejadas?</li>
                            </ul>
                        </div><!-- </p>                       -->                   
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn3" name="qn3" min="0" max="15" step="1" value="<?php echo $pontuacao->qn3; ?>" onchange="atualizarValor(this)"> <label for="qn3"><?php echo $pontuacao->qn3; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>4</th>
            <td><strong>Viabilidade técnica e organizacional </strong> <span style="float: right;">(Pontuação máxima: 15)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>O plano de implementação detalha o curso, carga horária, cronograma e estratégias de oferta do curso? 
                        <!-- <p>a) A respeito da implementação, carga horária e cronograma:  -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>O plano de implementação apresenta de forma clara o curso pretendido?</li>
                                <li>A carga horária do curso está definida e é compatível com os objetivos?</li>
                                <li>A carga horária proposta pode ser diminuída sem prejudicar o atendimento dos objetivos? <div >Se sim, sugira uma carga horária menor compatível: <input type="number" maxlength="3" class="col-1" name="chm" value="<?php echo $pontuacao->chm; ?>"></div></li>
                                <li>O cronograma de execução está bem estruturado e viável?</li>
                                <li>As estratégias de oferta do curso (carga horária, flexibilização, público-alvo, etc) estão adequadamente descritas e justificadas?</li>
                            </ul>
                        </div><!-- </p>                       -->                                           
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn4" name="qn4" min="0" max="15" step="1" value="<?php echo $pontuacao->qn4; ?>" onchange="atualizarValor(this)"> <label for="qn4"><?php echo $pontuacao->qn4; ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>5</th>
            <td><strong>Metodologia e execução </strong> <span style="float: right;">(Pontuação máxima: 15)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>A proposta está alinhada a uma abordagem participativa e dialógica? 
                        <!-- <p>a) A respeito da metodologia:   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Há valorização dos saberes prévios dos participantes, promovendo trocas entre universidade e comunidade?</li>
                                <li>Há compromisso com a inclusão digital, com a promoção da cidadania e/ou com o desenvolvimento local/regional?</li>
                                <li>Faz uso de metodologias ativas que estimulem a participação, como rodas de conversa, oficinas práticas, estudos de caso, dinâmicas em grupo e projetos colaborativos?</li>
                                <li>Há abordagens que conectem teoria e prática, com foco em possíveis situações reais vivenciadas pelos participantes?</li>
                                <li>Prevê uso de recursos didáticos diversos: vídeos, textos acessíveis, tecnologias digitais, materiais impressos e/ou interativos?</li>
                            </ul>
                        </div><!-- </p>                       -->                       
                    </li>
                    
                    <li>O projeto prevê mecanismos de monitoramento e avaliação de desempenho e resultados? 
                        <!-- <p>b) No tocante ao monitoramento e à avaliação   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>O projeto apresenta mecanismos de monitoramento ao longo da execução?</li>
                                <li>Há estratégias para avaliação de desempenho e resultados dos cursos?</li>
                                <li>Estão previstas formas de coleta e análise de dados durante e após a execução do projeto?</li>
                            </ul>
                        </p>                        
                    </li>

                    <li>O plano de implementação está apresentado de forma clara e com etapas bem definidas?
                        <!-- <p>c) No que diz respeito à implementação   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Está descrito de forma clara e objetiva?</li>
                                <li>As etapas de execução estão bem definidas e organizadas cronologicamente?</li>
                                <li>As ações previstas são compatíveis com os objetivos, metas e prazos estabelecidos?</li>
                            </ul>
                        </p>
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn5" name="qn5" min="0" max="15" step="1" value="<?php echo $pontuacao->qn5; ?>" onchange="atualizarValor(this)"> <label for="qn5"><?php echo $pontuacao->qn5; ?></label>
                </div>
            </td>
        </tr>
        
        <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>6</th>
            <td><strong>Foco na Estruturação de Microcredenciais</strong> <span style="float: right;">(Pontuação máxima: 10)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>Há uma definição clara de competências e habilidades desenvolvidas em cada microcredencial? 
                        <!-- <p>a) Definição de Competências e Habilidades   -->
                        <div class="alert alert-info col"> 
                            <ul>
                                <li>Há correspondência entre os conteúdos propostos e as competências/habilidades esperadas?</li>
                                <li>As competências estão alinhadas a demandas formativas e/ou profissionais concretas?</li>
                            </ul>
                        </p>                        
                    </li>
                    
                    <li>O formato dos cursos contempla flexibilidade e acessibilidade para os diferentes perfis de público? 
                        <!-- <p>b) Sobre o formato   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>O formato dos cursos (modalidade, duração, materiais, linguagem) contempla diferentes perfis de público (ex: trabalhadores, jovens, pessoas com baixa escolaridade, pessoas com deficiência)?</li>
                                <li>A proposta adota estratégias pedagógicas que favorecem a flexibilidade de tempo, ritmo e forma de participação dos cursistas?</li>
                                <li>Há uso de recursos acessíveis (tecnologias assistivas, linguagem simples, materiais adaptados)?</li>
                            </ul>
                        </p>                        
                    </li>

                    <li>A proposta define critérios para certificação das microcredenciais?
                        <!-- <p>c) Critérios para Certificação   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Há  critérios objetivos para a certificação dos participantes (ex: carga horária mínima, atividades obrigatórias, avaliação de aprendizagem)?</li>
                                <li>Os critérios de certificação estão alinhados às competências e habilidades descritas?</li>
                            </ul>
                        </p>
                    </li>

                    <li>O projeto prevê a emissão de certificado considerando as competências e habilidades adquiridas?
                        <!-- <p>d) No tocante à certificação:   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>Há clareza sobre os processos de acompanhamento e validação da participação e do desempenho?</li>
                                <li>Os certificados mencionam as competências e habilidades adquiridas pelos participantes?</li>
                            </ul>
                        </p>
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn6" name="qn6" min="0" max="10" step="1" value="<?php echo $pontuacao->qn6; ?>" onchange="atualizarValor(this)"> <label for="qn6"><?php echo $pontuacao->qn6; ?></label>
                </div>
            </td>
        </tr>
         <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>7</th>
            <td><strong>Sustentabilidade e replicabilidade </strong> <span style="float: right;">(Pontuação máxima: 10)</span><hr>
                <ol style="list-style-type:lower-alpha">
                    <li>O projeto prevê estratégias para continuidade após o período de financiamento? 
                        <!-- <p>a) Sobre a continuidade e replicabilidade:    -->
                        <div class="alert alert-info col">
                            <ul>                               
                               <li>A proposta apresenta possibilidade de reaplicação e/ou estratégias para continuidade mesmo após o término deste edital?</li>
                               <li>Pode ser aproveitado em uma área distinta da estabelecida/prevista  na proposta ou em contexto diferenciado?</li>
                            </ul>
                        </p>                        
                    </li>
                    
                    <li>O projeto tem potencial de expansão ou replicação em outras áreas? 
                        <!-- <p>b) Sobre a continuidade e replicabilidade:   -->
                        <div class="alert alert-info col">
                            <ul>
                                <li>A proposta apresenta possibilidade de reaplicação e/ou estratégias para continuidade mesmo após o término deste edital?</li>
                                <li>Pode ser aproveitado em uma área distinta da estabelecida/prevista  na proposta ou em contexto diferenciado?</li>
                            </ul>
                        </p>                       
                    </li>
                </ol>
                <hr>
                <div class="float-right">
                    <input type="range" id="qn7" name="qn7" min="0" max="10" step="1" value="<?php echo $pontuacao->qn7; ?>" onchange="atualizarValor(this)"> <label for="qn7"><?php echo $pontuacao->qn7; ?></label>
                </div>
            </td>
        </tr>
         <tr>
            <th colspan="2"></th>
        </tr>

        <tr>
            <th>8</th>
            <td><strong>Justificativas</strong><hr>
               <textarea name="justificativa" id="justificativa" maxlength="1500" name="vincobs" id="vincobs" cols="30" class="form-control" rows="8"><?php echo $pontuacao->justificativa; ?></textarea>
            </td>
        </tr>

    </table>
      <button type="submit" class="btn btn-success">Salvar</button>
    </form>
    

<script>
    function soma() {
      const qn1 = parseInt(document.getElementById('qn1').value);
      const qn2 = parseInt(document.getElementById('qn2').value);
      const qn3 = parseInt(document.getElementById('qn3').value);
      const qn4 = parseInt(document.getElementById('qn4').value);
      const qn5 = parseInt(document.getElementById('qn5').value);
      const qn6 = parseInt(document.getElementById('qn6').value);
      const qn7 = parseInt(document.getElementById('qn7').value);

      const total = qn1 + qn2 + qn3 + qn4 + qn5 + qn6 + qn7;
      
    }
    
    function atualizarValor(input) {
      const label = document.querySelector(`label[for="${input.id}"]`);
      
      if (label) {
        label.innerHTML = input.value;
      }
    //  soma();
    }
    

   
  </script>



