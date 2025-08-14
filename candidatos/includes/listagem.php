<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$qnt1 = 0;
$resultados = '';
foreach ($candidatos as $cand) {
    ++$qnt1;
    $resultados .= '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-2"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$cand->prog.'">📃 '.$cand->prog.'</a></div>
        <div class="col-sm-4">'.$cand->nome.'</div>
        <div class="col-sm-2">'.$cand->cidade.'</div>
        <div class="col-sm-2">'.$cand->curso.'</div>
        <div class="col-sm-2">'.$cand->dt_insc.'</div>
         

     
     </div>
  </div>
</div>    

          
';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

?>
<main>
  <h2 class="mt-0">Lista de candidatos </h2>
  


  <section>

    <form method="get">

      <div class="row my-2">
<!--
        <div class="col">
          <label>Buscar por titulo</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?php echo $busca; ?>"  id="titulo"  onchange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="< ?=$colegiado?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="< ?=$centro?>" id="centro" onChange="showLimpar();">
        </div>


        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>

      </div>

    </form>
-->
  </section>

  <section>

    
    <?php echo $resultados; ?>
    
  </section>


</main>








