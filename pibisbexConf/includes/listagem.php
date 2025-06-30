<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

require '../includes/msgAlert.php';

$qnt1 = 0;
$resultados = '<div id="accordion">';

foreach ($ProjPIbisBex as $ava) {
    ++$qnt1;
    $estiloD = '';
    // $cor = $ava->resultado == 'r' ? 'danger' : 'success';
    $link = '';

    $resultados .= '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id.'">📃 '.$ava->nome.'</a></div>
        <div class="col-sm-4">aaaaa</div>
        <div class="col-sm-1"><span class="badge badge-info">bbbb</span> </div>
        <div class="col-sm-1"><span class="badge badge-warning ">'.$ava->programa.'</span>
        </div>
        
     </div>
  </div>
    <div id="p'.$ava->id.'" class="collapse" data-parent="#accordion">
       
          <div class="d-flex flex-row-reverse ">
            <div class="p-1"></div>
            <div class="p-1"></div>
            <a href="./avaliar.php?id='.$ava->link.'" target=""><button class="btn btn-success btn-sm mb-2"> Visualizar/Avaliar relatorio</button></a>
            <div class="p-1"></div>
            <a href="../projetos/visualizar.php?id='.$ava->link.'&w=nw" target=""><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
            <div class="p-1"></div>
          </div>
          

          
      </div>
    </div>
           
        </div>';
}
$resultados .= '</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Lista de projetos PIBIS / PIBEX</h2>
  
  <?php echo $msgAlert; ?>

  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col">
          <label>Buscar por titulo</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?php echo $busca; ?>"  id="titulo"  onchange="showLimpar();">
        </div>
<!--
        <div class="col">
          <label>Buscar Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="< ?=$colegiado?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="< ?=$centro?>" id="centro" onChange="showLimpar();">
        </div>

-->
        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>

      </div>

    </form>

  </section>

  <section>

    
    <?php echo $resultados; ?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?php echo $paginacao; ?>
      </div>
    </div>
  </section>
</main>




