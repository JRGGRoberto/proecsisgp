<?php
  
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  function msgAprovReprov($nota) {
     $titulo = '';
    switch($nota){
      case 'a':
        $titulo = '<span class="badge badge-sicess">Publicado</span>';
        break;
      case 'r':
        $titulo = '<span class="badge badge-danger">Solicitação de alteração</span>';
        break;
      default:
        $titulo = '<span class="badge badge-warning">Não definido</span>';
    }
    return $titulo;
  }
  


  $qnt1 = 0;
  $resultados = '<div id="accordion">';
  foreach($relatorios as $rel){
    $qnt1++;


    $resultados .=  '
<div class="card mt-2">
  <div class="card-header" >
     <div class="row">
        <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'. $rel->id .'">📄 Relatório parcial '. msgAprovReprov($rel->resultado) .'</a></div>';

   $resultados .= '        
     </div>
  </div>
    <div id="p'. $rel->id .'" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>'. $rel->ava_comentario .'</p>
      </div>
    </div>
  </div>';

  }
  $resultados .= '</div>';
  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

  include '../includes/paginacao.php';
  /*
echo '<pre>';
print_r($relatorios);
echo '</pre>';
/*/
?>
<main>
  <h2 class="mt-0">Relatórios realizados</h2>
  
  <?=$msgAlert?> 

  <section>

    <form method="get">

      <div class="row my-2">
<!--
        <div class="col">
          <label>Buscar por Nome</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?=$busca?>"  id="resultado]"  onchange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="<?=$colegiado?>" id="colegiado" onchange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="<?=$centro?>" id="centro" onchange="showLimpar();">
        </div>

        
        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>
-->
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
      <div class="col" >
      <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a>
      </div>
    </div>
  </section>
</main>


  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Confirmação de exclusão</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Não é possível excluir este registro.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- The Modal -->



<script>
  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  const btnLimpar = document.getElementById('limpar');

  btnOpen.onclick = function(){
    modal.showModal();
  }


  btnLimpar.hidden = true;

  
  function showLimpar(){
    var resultado]      = document.getElementById('resultado]').value;
    var campus    = document.getElementById('campus').value;
    var centro    = document.getElementById('centro').value;
    var colegiado = document.getElementById('colegiado').value;

    if((resultado].length > 0 ) | (campus.length > 0)| (centro.length > 0)| (colegiado.length > 0) ) {
      btnLimpar.hidden = false;
    }
  }

  showLimpar();
  
</script>


