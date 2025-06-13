<?php
  
  use \App\Entity\Colegiado;
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

function tipoRelatori($tp){
  switch ($tp){
    case 'fi':
      return "Final";
      break;
    case 're':
      return "Final com renovação";
      break;
    case 'pr':
      return "Final com prorrogação";
      break;
    case 'pa':
      return "Parcial";
      break;
    default:
      return "??";
      break;
  }
}


  $qnt1 = 0;
  $resultados = '  
  <div class="panel-group" id="accordion">';

  foreach($avaliacoes as $ava){
    $qnt1++;
    $estiloD = '';
    $cor = '';

    if($ava->resultado == 'r'){
      $cor = 'warning';
      $progresso =  '<span class="badge badge-warning"> ↩️ Adequação</span>';
    } elseif ($ava->resultado == 'a'){
      $progresso =  '<span class="badge badge-success"> 🆗 Aceite</span>';
      $cor = 'success';
    } else {
      $progresso =  '<span class="badge badge-danger">Error</span>';
      $cor = 'danger';
    }
      
    /*------------------*/
    $titulo = $ava->titulo;
    if($ava->ver >0 ){
      $titulo .= ' [Versão: '.($ava->ver + 1).']';
    }

$resultados .=  '
<div class="card mt-2">
  <div class="card-header">
     <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#'. $ava->id .'">👤'.$titulo.'</a></div>
  </div>
  <div id="'. $ava->id .'" class="collapse" data-parent="#accordion">
      <div class="card-body">
         AAAAAAAAAAAAAAAAAA
      </div>
  </div>
</div>

      
    
';

  }

$resultados .= '
</div>';
  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


  include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Avaliações de relatórios realizados</h2>
  
  <?=$msgAlert?>

  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col">
          <label>Buscar por titulo</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?=$busca?>"  id="titulo"  onchange="showLimpar();">
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

    
    <?=$resultados?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?=$paginacao?>
      </div>
    </div>
  </section>
</main>

