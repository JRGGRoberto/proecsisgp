<?php

require __DIR__.'/../../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Form_d;
use App\Entity\Projeto;

$pGET = $pGET ?? $p ?? ($_GET['p'] ?? '');
$vGET = $vGET ?? $v ?? ($_GET['v'] ?? '');

$prj = Projeto::getProjetoView($pGET, $vGET);
$form = Form_d::getRegistro($pGET, $vGET);

$anexados = Arquivo::getAnexados('forms', $form->id_avaliacao);
$x = 0;
$anex = '<ul id="anexos_edt" >';
foreach ($anexados as $att) {
    ++$x;
    $anex .=
    ' <li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
    </li> ';
}
$anex .= '</ul>';
if ($x == 0) {
    $anex = 'Sem arquivos';
}

include __DIR__.'/../../includes/headers.php';

?>

<div class="container mt-4">
   <h3>FORM D</h3>
   <h4>Divisão de Extensão e Cultura dos Campi</h4>
      
  <form name="myform" id="myform" method="post" enctype="multipart/form-data">
       <ol>
        <li class="mb-4">
          <h5>Tipo de Proposta</h5>

            <div class="form-group">
                <input type="text" class="form-control" name="tp_proposta"  value="<?php echo $prj->tipo_exten; ?>" readonly>
            </div>
            
        </li>

        <li class="mb-4">
          <h5>Identificação da Proposta</h5>
            
            <div class="form-group">
              <label>Título</label>
              <input type="text" class="form-control" name="titulo" value="<?php echo $prj->titulo; ?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Proponente</label>
              <input type="text" class="form-control" name="coordNome" value="<?php echo $prj->nome_prof; ?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Colegiado de Curso</label>
              <input type="text" class="form-control" name="colegiado" value="<?php echo $prj->colegiado; ?>" readonly>
            </div>
            
            <div class="row">
            
              <div class="col">
                <div class="form-group">
                  <label for="area_extensao">Área de extensão</label>
                  <input type="text" class="form-control"  name="area_exten" value="<?php echo $prj->area_extensao; ?>" readonly>
                </div>
              </div>
            
              <div class="col">
                <div class="form-group">
                  <label for="linh_ext">Linha de  extensão</label>
                  <input type="text" class="form-control"  value="<?php echo $prj->linh_ext; ?>" readonly>
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
                placeholder="(Informar o parecer do projeto) 10 linhas máximo"><?php echo $form->parecer; ?></textarea>
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
                <?php echo $anex; ?>
              </div>
            </div>
          </div>
        </li>

    </ol>

    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="cidade"  value="<?php echo $form->cidade; ?>" readonly></div>
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly value="<?php echo substr($form->dateAssing, 0, 10); ?>"> </div>
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="whosigns"  value="<?php echo $form->whosigns; ?>" readonly>
    </div>

</div>
<a href="../../projetos" class="btn btn-primary btn-sm mr-2">Voltar</a>

<?php

include __DIR__.'/../../includes/footer.php';
