<?php

$formX = '
<div class="container">
<h2>ANEXO A - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h2>
    <h3>Divisão de Extensão e Cultura dos Campi</h3>

    

<form action="">
    <ol>
        <li class="mb-4"><h4>Tipo de Proposta</h4>

            <div class="form-group">
                <input type="text" class="form-control" name="tp_proposta"  value="Programa" readonly>
            </div>
            
        </li>

        <li class="mb-4"><h4>Identificação da Proposta</h4>

<div class="form-group">
  <label>Título</label>
  <input type="text" class="form-control" name="coordNome" readonly value="">
</div>

<div class="form-group">
  <label>Proponente</label>
  <input type="text" class="form-control" name="coordNome" readonly value="">
</div>


<div class="form-group">
  <label>Colegiado de Curso</label>
  <input type="text" class="form-control" name="coordNome" readonly value="">
</div>



<div class="row">

  <div class="col">
    <div class="form-group">
      <label for="area_extensao">Área de extensão</label>
      <select name="area_extensao" class="form-control" readonly>
        <?=$area_ext_Opt?>
      </select>
    </div>
  </div>


  <div class="col">
    <div class="form-group">
      <label for="linh_ext">Linha de  extensão</label>
      <select name="linh_ext" class="form-control" readonly>
        <?=$area_ext_Opt?>
      </select>
    </div>
  </div>
</div>
        </li>
        <li class="mb-4"><h4>Atendimento ao Regulamento de Extensão da Unespar</h4>
            <div>
                <div class="row mb-3">
                    <div class="col-6">Contém toda a documentação necessária?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a participação de estudantes como equipe executora da ação de extensão?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <ed pela página incluída, considere usar o buffer de saída:div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>
                 
                <div class="row mb-3">
                    <div class="col-6">Prevê a participação da Comunidade externa?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os princípios da extensão na UNESPAR?</div>
                    <div class="col">
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>


                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os objetivos da extensão na UNESPAR?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê parcerias com outras instituições (públicas ou privadas)?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a difusão dos resultados alcançados?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                            </label>
                          </div>
                    </div>
                </div>

            </div>
        
        </li>
        <li class="mb-4"><h4>Quanto às Diretrizes da Extensão</h4>

          <div class="row mb-2">
            <div class="col"><strong>Descrição</strong></div>
            <div class="col"><strong>Orientações</strong></div>
            <div class="col-2"></div>
          </div>
          <hr class="m-1">

          
          <div class="row mb-3">
            <div class="col">Interação dialógica (A proposta deve explicitar o desenvolvimento de relações entre Universidade e setores sociais marcadas pelo diálogo e troca de saberes, com vistas à produção de um conhecimento novo, que contribua para a superação da desigualdade e da exclusão social)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              Como surgiu este projeto? Por qual demanda? De que forma a execução deste projeto promove transformação entre a universidade e a sociedade?</i></div>
            <div class="col-2">
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                </label>
              </div>
            </div>
          </div>
          <hr>


          <div class="row mb-3">
            <div class="col">Interdisciplinaridade e interprofissionalidade
              (A proposta deve explicitar de que maneira a ação busca materializar a combinação de especialização e visão holista na interação de modelos, conceitos e metodologias oriundos de várias disciplinas e áreas do conhecimento, assim como pela construção de alianças intersetoriais, interorganizacionais e interprofissionais.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como:
              É possível integrar modelos, conceitos e metodologias de diversas áreas do conhecimento? Este projeto pode favorecer a construção de alianças interorganizacionais e interprofissionais? Este projeto pode envolver estudantes e servidores de diversas áreas da nossa instituição?</i></div>
            
              <div class="col-2">
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
                </div>
                


                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
                </div>
            </div>
          </div>
          <hr>


          <div class="row mb-3">
            <div class="col">Indissociabilidade entre ensino, pesquisa e extensão
              (Para que se atinja essa diretriz, deve haver um esforço em vincular ações de extensão ao processo de formação de pessoas (ensino) e de geração de conhecimento (pesquisa). Isso permite que se alcance maior unidade entre teoria e prática.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              O projeto prevê o envolvimento de alunos de vários períodos do mesmo curso ou de outros cursos? Envolve aluno da residência ou pós-graduação? Com objetivo de fortalecer a produção acadêmica, relaciona prática com teoria? Do projeto de extensão é possível gerar trabalho de conclusão de curso ou associação com a iniciação científica?</i></div>
              <div class="col-2">
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                </label>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mb-3">
            <div class="col">Impacto na formação discente
              (A proposta deve considerar o envolvimento dos estudantes nas ações de extensão, como prática essencial na formação acadêmica e cidadã, através do fortalecimento do sentido ético e do comprometimento com a sociedade; potencializando a formação para o trabalho e para a vida em sociedade; e a formação de cidadãos críticos e comprometidos com o desenvolvimento local e regional sustentável.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              As atividades previstas possibilitam reforçar o papel das/dos estudantes na comunidade promovendo sua formação como profissional e como cidadã/cidadão? As/Os estudantes conseguirão desempenhar bem seu papel como agentes de transformação da sociedade, aplicando os conhecimentos adquiridos?</i></div>
              <div class="col-2">
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                </label>
              </div>
            </div>
          </div>
          <hr>
          <div class="row mb-3">
            <div class="col">Impacto e transformação social
              (A proposta evidencia e reafirma o mecanismo de inter-relação da universidade com os demais setores da sociedade com vistas à atuação transformadora, voltada para interesses e demandas da maioria da população e causadora de desenvolvimento social e regional como também aprimoramento de políticas públicas.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              O projeto consegue apresentar contribuições significativas de mudanças na comunidade local, produzindo soluções efetivas na resolução de problemas? A proposta do projeto visa promover também mudanças na Universidade, na medida em que ela se envolve com a comunidade local?</i></div>
              <div class="col-2">
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                </label>
              </div>
            </div>
          </div>

        </li>

        <li class="mb-4"><h4>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h4>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="contrap_nofinac" rows="10" 
                placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>


        <li class="mb-4"><h4>Parecer</h4>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="contrap_nofinac" rows="10" 
                placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>
    </ol>


    <div class="form-group">
      <div class="row">
        <div class="col-2"><input type="text" class="form-control" name="tp_proposta"  value="Cidade"></div>
        <div class="col-2"> <input type="date" class="form-control" name="" id="dateAssing" readonly> </div>
      </div>



      
    </div>

    <div class="form-group">
      <input type="text" class="form-control" name="tp_proposta"  value="Programa" readonly>
      Chefe da Divisão de Extensão e Cultura
    </div>
    

    <div class="form-group">
      <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
    </div>
    

</form>

</div>

<script>
  document.getElementById("dateAssing").valueAsDate = new Date();
</script>
';