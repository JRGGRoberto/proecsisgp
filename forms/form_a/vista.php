<?php
require '../../vendor/autoload.php';

use \App\Entity\Projeto;
use \App\Entity\Form_a;

$prj = Projeto::getProjetoView($_GET['p'], $_GET['v']);
$form = Form_a::getRegistro($_GET['p'], $_GET['v']);


include '../../includes/headers.php';

?>

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
                        <?=$form->r3_1 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a participação de estudantes como equipe executora da ação de extensão?</div>
                    <div class="col">
                        <?=$form->r3_2 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a participação da Comunidade externa?</div>
                    <div class="col">
                       <?=$form->r3_3 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os princípios da extensão na UNESPAR?</div>
                    <div class="col">
                       <?=$form->r3_4 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Está de acordo com os objetivos da extensão na UNESPAR?</div>
                    <div class="col">
                        <?=$form->r3_5 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê parcerias com outras instituições (públicas ou privadas)?</div>
                    <div class="col">
                       <?=$form->r3_6 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Prevê a difusão dos resultados alcançados?</div>
                    <div class="col">
                        <?=$form->r3_7 == '1'? "🆗" : "❌" ?>
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
              <?=$form->r4_1 == '1'? "🆗" : "❌" ?>
            </div>
          </div>
          <hr>


          <div class="row mb-3">
            <div class="col">Interdisciplinaridade e interprofissionalidade
              (A proposta deve explicitar de que maneira a ação busca materializar a combinação de especialização e visão holista na interação de modelos, conceitos e metodologias oriundos de várias disciplinas e áreas do conhecimento, assim como pela construção de alianças intersetoriais, interorganizacionais e interprofissionais.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como:
              É possível integrar modelos, conceitos e metodologias de diversas áreas do conhecimento? Este projeto pode favorecer a construção de alianças interorganizacionais e interprofissionais? Este projeto pode envolver estudantes e servidores de diversas áreas da nossa instituição?</i></div>
            
              <div class="col-2">
                <?=$form->r4_2 == '1'? "🆗" : "❌" ?>
            </div>
          </div>
          <hr>


          <div class="row mb-3">
            <div class="col">Indissociabilidade entre ensino, pesquisa e extensão
              (Para que se atinja essa diretriz, deve haver um esforço em vincular ações de extensão ao processo de formação de pessoas (ensino) e de geração de conhecimento (pesquisa). Isso permite que se alcance maior unidade entre teoria e prática.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              O projeto prevê o envolvimento de alunos de vários períodos do mesmo curso ou de outros cursos? Envolve aluno da residência ou pós-graduação? Com objetivo de fortalecer a produção acadêmica, relaciona prática com teoria? Do projeto de extensão é possível gerar trabalho de conclusão de curso ou associação com a iniciação científica?</i></div>
              <div class="col-2">
                <?=$form->r4_3 == '1'? "🆗" : "❌" ?>
            </div>
          </div>

          <hr>
          <div class="row mb-3">
            <div class="col">Impacto na formação discente
              (A proposta deve considerar o envolvimento dos estudantes nas ações de extensão, como prática essencial na formação acadêmica e cidadã, através do fortalecimento do sentido ético e do comprometimento com a sociedade; potencializando a formação para o trabalho e para a vida em sociedade; e a formação de cidadãos críticos e comprometidos com o desenvolvimento local e regional sustentável.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              As atividades previstas possibilitam reforçar o papel das/dos estudantes na comunidade promovendo sua formação como profissional e como cidadã/cidadão? As/Os estudantes conseguirão desempenhar bem seu papel como agentes de transformação da sociedade, aplicando os conhecimentos adquiridos?</i></div>
              <div class="col-2">
                <?=$form->r4_4 == '1'? "🆗" : "❌" ?>
            </div>
          </div>
          <hr>
          <div class="row mb-3">
            <div class="col">Impacto e transformação social
              (A proposta evidencia e reafirma o mecanismo de inter-relação da universidade com os demais setores da sociedade com vistas à atuação transformadora, voltada para interesses e demandas da maioria da população e causadora de desenvolvimento social e regional como também aprimoramento de políticas públicas.)</div>
            <div class="col"><i>Para observar se a proposta submetida atende a essa diretriz, faça perguntas como: 
              O projeto consegue apresentar contribuições significativas de mudanças na comunidade local, produzindo soluções efetivas na resolução de problemas? A proposta do projeto visa promover também mudanças na Universidade, na medida em que ela se envolve com a comunidade local?</i></div>
              <div class="col-2">
                <?=$form->r4_2 == '1'? "🆗" : "❌" ?>
              </div>
            </div>

        </li>

        <li class="mb-4">
          <h5>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="solicitacoes" rows="10" 
                placeholder="(Descrever quais adequações devem ser realizadas para que o projeto ultrapasse esta etapa) 10 linhas máximo"><?=$form->solicitacoes?></textarea>
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
                placeholder="(Informar o parecer do projeto) 10 linhas máximo"><?=$form->parecer?></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>
    </ol>

    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="cidade"  value="<?=$form->cidade?>" readonly></div>
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly value="<?=$form->dateAssing?>"> </div>
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="whosigns"  value="<?=$form->whosigns?>" readonly>
    </div>

</div>


<?php


include '../../includes/footer.php';