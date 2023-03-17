<?php
require '../../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \App\Entity\Projeto;
use \App\Entity\Form_b;

$prj = Projeto::getProjetoView($_GET['p'], $_GET['v']);
$form = Form_b::getRegistro($_GET['p'], $_GET['v']);





include '../../includes/headers.php';

?>

<div class="container mt-4">
  <h3>ANEXO B - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h3>
  <h5>(Parecer) Colegiado de Curso</h5>
      
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
                    <div class="col-6">O título condiz com a proposta apresentada?</div>
                    <div class="col">
                        <?=$form->r3_1 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Há coerência entre a justificativa e os objetivos propostos?</div>
                    <div class="col">
                        <?=$form->r3_2 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Há coerência entre os objetivos e a metodologia proposta?</div>
                    <div class="col">
                       <?=$form->r3_3 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">A proposta apresenta exequibilidade?</div>
                    <div class="col">
                       <?=$form->r3_4 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">A proposta é relevante para a área de conhecimento?</div>
                    <div class="col">
                        <?=$form->r3_5 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">A proposta articula-se com o PPC do curso?</div>
                    <div class="col">
                       <?=$form->r3_6 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Há correspondência entre os objetivos propostos, a metodologia e os resultados esperados?</div>
                    <div class="col">
                        <?=$form->r3_7 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">A proposta apresenta relevância social, com possibilidade de ampliação de acesso e de inserção da Universidade junto à Comunidade?</div>
                    <div class="col">
                        <?=$form->r3_8 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">Os resultados esperados favorecem a reflexão sobre a formação do estudante?</div>
                    <div class="col">
                        <?=$form->r3_9 == '1'? "🆗" : "❌" ?>
                    </div>
                </div>


          </div>
        
        </li>

        <li class="mb-4">
          <h5>Parecer</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="parecer" rows="10" readonly
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
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly value="<?=substr($form->dateAssing,0,10)?>"> </div>
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="whosigns"  value="<?=$form->whosigns?>" readonly>
    </div>

</div>


<?php


include '../../includes/footer.php';