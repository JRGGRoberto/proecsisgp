<?php
  
  use \App\Entity\Colegiado;
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  $qnt1 = 0;
  $resultados = '';
  foreach($avaliacoes as $ava){
    $qnt1++;
    $estiloD = '';
    $cor = '';

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
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'. $ava->id_ava .'">📃 '. $titulo .'</a></div>
        <div class="col-sm-7">
           '. 
           $progresso
           .'

            <div class="d-flex flex-row-reverse ">
              <div class="p-1"></div>
              <a href="../forms/'. $ava->form .'/vista.php?p='. $ava->id_proj . '&v='. $ava->ver . '" target="_blank"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Ver avaliação</button></a>
              <div class="p-1"></div>
              <a href="../projetos/visualizar.php?id='. $ava->id_proj . '&v='. $ava->ver . '&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
              <div class="p-1"></div>
            </div>
           

        </div>
     </div>
  </div>
</div>    

          
';

  }

  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


  //GETS
  unset($_GET['status']);
  unset($_GET['pagina']);
  $gets = http_build_query($_GET);

  //Paginação
  $paginacao = '';
  $paginas   = $obPagination->getPages();
  $paginacao .= '<nav aria-label="Page navigation" >
                  <ul class="pagination pagination-sm">'; 
  foreach($paginas as $key=>$pagina){
    $class = $pagina['atual'] ? 'page-item active': 'page-item';
    $paginacao .= 
      '<li class="'.$class.'">
        <a class="page-link" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'
        .$pagina['pagina']
      .'</a>
       </li>';
  }

  $paginacao .= '</ul>
  </nav>
  ';

?>
<main>
  <h2 class="mt-0">Avaliações realizadas</h2>
  
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


    if(titulo.length > 0 ) {
      btnX.hidden = true;
    }
  }

  showLimpar();
  
</script>


