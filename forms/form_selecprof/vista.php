<?php
require '../../vendor/autoload.php';

use \App\Entity\Projeto;
use \App\Entity\Form_Selecprof;
use \App\Entity\Professor;
use \App\Entity\Arquivo;

$prj = Projeto::getProjetoView($_GET['p'], $_GET['v']);
$form = Form_Selecprof::getRegistro($_GET['p'], $_GET['v']);
$nomeProf = Professor::getProfessor($form->id_parecerista);

$anexados = Arquivo::getAnexados('forms', $form->id_avaliacao);
$x = 0;
$anex = '<ul id="anexos_edt" >';
foreach($anexados as $att){
  $x++;
  $anex .= 
  ' <li>
      <a href="/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
    </li> ';
}
$anex .= '</ul>';
if($x == 0) {
  $anex = 'Sem arquivos';
}


include '../../includes/headers.php';

?>

<div class="container mt-4">
   <h3>SELEÇÃO DE PROFESSOR PARA REALIZAR O PARECER</h3>
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
          <h5>O professor selecionado como parecerista</h5>
              <h4><span class="badge badge-secondary"><?=$nomeProf->nome?></span></h4>
        </li>

 
        <li class="mb-4">
          <h5>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="solicitacoes" rows="10" readonly
                placeholder="(Descrever quais adequações devem ser realizadas para que o projeto ultrapasse esta etapa) 10 linhas máximo"><?=$form->solicitacoes?></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>

        <li class="mb-4">
          <h5>Anexos</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <ul id="anexos"></ul>
                <?=$anex?>
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

<a href="../../projetos" class="btn btn-primary btn-sm mr-2">Voltar</a>
<?php


include '../../includes/footer.php';