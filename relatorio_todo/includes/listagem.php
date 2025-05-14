<?php

  require '../vendor/autoload.php';
  // use \App\Entity\Colegiado;

  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  $qnt1 = 0;
  $resultados = '<div id="accordion">';
  foreach($dadosToAvaliar as $ava){
    $qnt1++;
    $estiloD = '';

      
    

    $resultados .=  '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'. $ava->id .'">📃 '. $ava->titulo .'</a></div>
        
        <div class="col-sm-5">
        Relatório '. $ava->tp .'
        </div>
        <div class="col-sm-2">
        '. $ava->created_at .'
        </div>

     </div>
  </div>
    <div id="p'. $ava->id .'" class="collapse" data-parent="#accordion">
      <div class="card-body">


        <h5>Tipo de Proposta</h5>

        <div class="form-group">
            <input type="text" class="form-control" name="tp_proposta" value="'. $ava->tipo_exten  .'" readonly>
        </div>
      
  
        <h5>Identificação da Proposta</h5>
     
        <div class="form-group">
          <label>Título</label>
          <input type="text" class="form-control" name="coordNome" value="'. $ava->titulo.'" readonly="">
        </div>
      
        <div class="form-group">
          <label>Proponente</label>
          <input type="text" class="form-control" name="coordNome" value="'. $ava->nome_prof .'" readonly="">
        </div>
      

        
        <div class="row my-2">
        
        <div class="col">
         
        </div>
      </div>

        <hr>
          <div class="d-flex flex-row-reverse ">
            <div class="p-1"></div>
            <a href="./avaliar1.php?id='. $ava->id. '"><button class="btn btn-primary btn-sm mb-2"> Ver/Aprovar relatório</button></a>
            <div class="p-1"></div>
            <a href="../projetos/visualizar.php?id='. $ava->idproj . '&v='. $ava->ver. '&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar Projeto</button></a>
            <div class="p-1"></div>
          </div>
          
          
      </div>
    </div>
           
        </div>';

  }
  $resultados .= '</div>';
  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

  // include '../includes/paginacao.php';

?>
<main>
  <h2 class="mt-0">Relatórios para aprovação</h2>
  
  <?=$msgAlert?>

  <section>

    <form method="get">

      <div class="row my-2">
<!--
        <div class="col">
          <label>Buscar por titulo</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?=$busca?>"  id="titulo"  onchange="showLimpar();">
        </div>
-->
<!--
        <div class="col">
          <label>Buscar Colegiado</label>
          <input type="text" name="colegiado" class="form-control form-control-sm" value="<?=$colegiado?>" id="colegiado" onChange="showLimpar();">
        </div>

        <div class="col">
          <label>Buscar por Centro</label>
          <input type="text" name="centro" class="form-control form-control-sm" value="<?=$centro?>" id="centro" onChange="showLimpar();">
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
         <?='a'; ?>
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


