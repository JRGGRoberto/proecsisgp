<?php

require '../vendor/autoload.php';
use App\Session\Login;

$user = Login::getUsuarioLogado();

function dt($dt)
{
    return substr($dt, 8, 2).'/'.substr($dt, 5, 2).'/'.substr($dt, 0, 4).'<br>'.substr($dt, -9);
}

require '../includes/msgAlert.php';

$qnt1 = 0;
$resultados = '<div id="accordion">';
foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $estiloD = '';
    $num = $ava->tipo == 'pa' ? 'p' : 'f';

    $resultados .= '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id.'">📃 '.$ava->titulo.'</a></div>
        <div class="col-sm-4">'.$ava->nome_prof.'</div>
        <div class="col-sm-1"><span class="badge badge-info">'.tipoRelatori($ava->tipo).'</span> </div>
        <div class="col-sm-1"><span class="badge badge-warning ">'.$ava->etapa.'/'.$ava->etapas.'</span>
        </div>
        
     </div>
  </div>
    <div id="p'.$ava->id.'" class="collapse" data-parent="#accordion">
       
          <div class="d-flex flex-row-reverse ">
            <div class="p-1"></div>
<!-- <a href="../forms/index.php?i='.$ava->idproj.'"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Avaliar</button></a>    -->
            <div class="p-1"></div>
            <a href="./avaliar.php?id='.$ava->id.'&t='.$num.'" target=""><button class="btn btn-success btn-sm mb-2"> Visualizar/Avaliar relatorio</button></a>
            <div class="p-1"></div>
            <a href="../projetos/visualizar.php?id='.$ava->idproj.'&v='.$ava->ver.'&w=nw" target=""><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
            <div class="p-1"></div>
          </div>
          

          
      </div>
    </div>
           
        </div>';
}
$resultados .= '</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

?>
<main>
  <h2 class="mt-0">Relatórios a serem homologados</h2>
  
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
          <input type="text" name="colegiado" class="form-control form-control-sm" value="<?php echo $colegiado; ?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="<?php echo $centro; ?>" id="centro" onChange="showLimpar();">
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

  
</main>


<script>
  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  const btnX = document.getElementById("limpar");

  btnOpen.onclick = function(){
    modal.showModa();
  }


  btnX.hidden = true;
  
  function showLimpar(){
    var titulo      = document.getElementById('titulo').value;
  //  var campus    = document.getElementById('campus').value;
  //  var centro     = document.getElementById('centro').value;
  //  var colegiado = document.getElementById('colegiado').value;

  //  if((titulo.length > 0 ) | (campus.length > 0)| (centro.length > 0)| (colegiado.length > 0) ) {
  if( titulo.length > 0 ) {
      btnX.hidden = true;
    }
  }

  showLimpar();
  
</script>


