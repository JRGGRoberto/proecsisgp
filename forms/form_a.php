
<div class="container mt-4">
   <h3>ANEXO A - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h3>
   <h4>Divisão de Extensão e Cultura dos Campi</h4>
      
  <form name="myform" id="myform" method="post" enctype="multipart/form-data">
       <ol>
        <li class="mb-4">
          <h5>Tipo de Proposta</h5>

            <div class="form-group">
                <input type="text" class="form-control" name="tp_proposta"  value="<?=$prj->tipo_exten?>" readonly>
            </div>
            
        </li>

        <li class="mb-4">
          <h5>Identificação da Proposta</h5>
            
            <div class="form-group">
              <label>Título</label>
              <input type="text" class="form-control" name="titulo" value="<?=$prj->titulo?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Proponente</label>
              <input type="text" class="form-control" name="coordNome" value="<?=$prj->nome_prof?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Colegiado de Curso</label>
              <input type="text" class="form-control" name="colegiado" value="<?=$prj->colegiado?>" readonly>
            </div>
            
            <div class="row">
            
              <div class="col">
                <div class="form-group">
                  <label for="area_extensao">Área de extensão</label>
                  <input type="text" class="form-control"  name="area_exten" value="<?=$prj->area_extensao?>" readonly>
                </div>
              </div>
            
              <div class="col">
                <div class="form-group">
                  <label for="linh_ext">Linha de  extensão</label>
                  <input type="text" class="form-control"  value="<?=$prj->linh_ext?>" readonly>
                </div>
              </div>

            </div>
        </li>

        <li class="mb-4">
          <h5>Atendimento ao Regulamento de Extensão da Unespar</h5>

          <div>
                <div class="row mb-3">
                    <div class="col-6">Contém toda a documentação necessária?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_1" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_1" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a participação de estudantes como equipe executora da ação de extensão?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_2" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_2" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a participação da Comunidade externa?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_3" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_3" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os princípios da extensão na UNESPAR?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_4" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_4" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os objetivos da extensão na UNESPAR?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_5" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_5" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê parcerias com outras instituições (públicas ou privadas)?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_6" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_6" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a difusão dos resultados alcançados?</div>
                    <div class="col">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                              <input type="radio" class="form-check-input" id="radio1" name="r3_7" value="sim"> Sim
                            </label>
                          </div>
                          
                          <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                              <input type="radio" class="form-check-input" id="radio2" name="r3_7" value="nao"> Não
                            </label>
                          </div>
                    </div>
                </div>



          </div>

           

        
        </li>

        <li class="mb-4">
          <h5>Quanto às Diretrizes da Extensão</h5>

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
                  <input type="radio" class="form-check-input" id="radio1" name="r4_1" value="sim"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="r4_1" value="nao"> Não
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
                    <input type="radio" class="form-check-input" id="radio1" name="r4_2" value="sim"> Sim
                  </label>
                </div>
                
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r4_2" value="nao"> Não
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
                  <input type="radio" class="form-check-input" id="radio1" name="r4_3" value="sim"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="r4_3" value="nao"> Não
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
                  <input type="radio" class="form-check-input" id="radio1" name="r4_4" value="sim"> Sim
                </label>
              </div>
              
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="r4_4" value="nao"> Não
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
                  <input type="radio" class="form-check-input" id="radio1" name="r4_5" value="sim"> Sim
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="radio2" name="r4_5" value="nao"> Não
                </label>
              </div>
            </div>
          </div>

        </li>

        <li class="mb-4">
          <h5>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="sol_adq" rows="10" 
                placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>

        <li class="mb-4">
          <h5>Parecer</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="parecer" rows="10" 
                placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>
    </ol>

    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="cideade"  value="<?=$user['campus']?>"></div>
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly> </div>
      </div>
    </div>
    
    <div class="form-group">
      <input type="text" class="form-control" name="parecerista_nome"  value="<?=$user['nome']?> - <?=$user['nivel']?>" readonly>
    </div>
<p> </p><hr><p> </p>
    <div class="form-group form-group d-flex justify-content-around">
      <a href="javascript: submitSolicAlterac()" class="btn btn-warning" >Solicitar alterações ↩️</a>
      <a href="javascript: submitSave()" class="btn btn-secondary" >Avaliar mais tarde ⌛</a>
      <a href="javascript: submitAprova()" class="btn btn-success" >✔️ Enviar para próxima instância</a>
    </div>

    <div class="form-group form-group d-flex justify-content-around">
      <div class="col-4">
        <p><span class="badge badge-warning">↩️</span><small> Ao Solicitar alterações, esta avalização fica anexa a esta versão e uma nova versão do projeto é disponibilizada ao proponente, para que este realiza as alterações necessárias e volte a submeter a uma nova avaliação.</small></p>
      </div>
      <div class="col-4">
        <p><span class="badge badge-secondary">⌛</span><small> Os dados da avalização ficam salvos para outros acesso e alterações até que se chegue há um veredito.</small></p>
      </div>
      <div class="col-4">
        <p><span class="badge badge-success">✔️</span><small> O projeto não necessita de alterações, esta completamente atentendo os requisitos e será avaliado para a próxima instância ou registro/publicação.</small></p>
      </div>
      
    </div>
    <input type="hidden" id="resultado" name="resultado">
  </form>

</div>

<script>

document.getElementById("dateAssing").valueAsDate = new Date();

function submitSolicAlterac()
{
  const name = document.getElementById('resultado');
  name.value = 'rejeitado';
  document.myform.submit();
}

function submitSave()
{
  const name = document.getElementById('resultado');
  name.value = '2';
  document.myform.submit();
}

function submitAprova()
{
  const name = document.getElementById('resultado');
  name.value = 'aprovado';
  document.myform.submit();
}
</script>

