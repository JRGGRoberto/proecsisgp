<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

require '../includes/msgAlert.php';

$qnt1 = 0;
$resultados = '';

foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $estiloD = '';
    $cor = $ava->doit == '1' ? ['success', 'Avaliado', $ava->total] : ['warning', 'Pendente', '-'];

    $resultados .= '
      <div class="card mt-2">
        <div class="card-header">
          <div class="row">
           <!-- <div class="col-sm-4"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->proj_id.'">📃 '.$ava->nomeproj.'</a></div> -->
            <div class="col-sm-9"><a href="./docs/'.$ava->link.'" target="_blank">📃 '.$ava->nomeproj.'</a></div>
<!--            <div class="col-sm-2"><span class="badge badge-info">Nota: '.$cor[2].'</span></div> -->
            <div class="col-sm-2"><span class="badge badge-'.$cor[0].'">'.$cor[1].'</span></div>
            <div class="col-sm-1"><a href="./pontuar.php?p='.$ava->proj_id.'&a='.$ava->aval_id.'"><span class="badge badge-success">Avaliar</span></a></div>
          </div>
        </div>
      <!--  <div id="p'.$ava->proj_id.'" class="collapse">
          <div class="card-body">
            <p></p>
          </div>
        </div> -->
      </div>
    ';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Projetos PIBIS/PIBEX para avaliar</h2>
  
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




