<?php
  
  use \App\Entity\Colegiado;
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  $qnt1 = 0;
  $resultados = '';
  // echo "<pre>";
  // print_r($avaliacoes);
  // echo "</pre>";


  foreach($avaliacoes as $ava){
    $qnt1++;
    $estiloD = '';
    $cor = $ava->resultado == 'r' ? 'danger' : 'success';

    if($ava->resultado == 'r'){
      $cor = 'warning';
      $progresso =  '<span class="badge badge-warning"> ↩️ Solicitação de revisão</span>';
    } elseif ($ava->resultado == 'a'){
      $progresso =  '<span class="badge badge-success"> 🆗 Favorável</span>';
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
          <div class="row">
            <div class="col-sm-4">
              <a class="collapsed card-link" data-toggle="collapse" href="#p'. $ava->id .'">📃 '. $ava->titulo .'</a>
            </div>
            <div class="col-sm-2">
              '. $ava->titulo .' 
            </div>
            <div class="col-sm-2">
              '. $ava->nome_prof .' 
            </div>
            <div class="col-sm-2">
              '. $ava->tipo .' 
            </div>
            <div class="col-sm-2">
              <span class="badge badge-'.$cor.' ">'. $ava->etapa .'/'. $ava->etapas .'</span> 
            </div>
            <div class="col-sm-2">
              '. $ava->created_at .' 
            </div>

            <div class="col-sm-7">
              <div class="d-flex flex-row-reverse ">
                <div class="p-1"></div>
              </div>
            </div>
          </div>
        </div>


        <div id="p'. $ava->id .'" class="collapse">
          <div class="card-body">
            <p>dsfdsdf</p>
          </div>
        </div>
      </div>
    '; 
  }

  
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





