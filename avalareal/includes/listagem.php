<?php
  
  use \App\Entity\Colegiado;
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  $qnt1 = 0;
  $resultados = '<div id="accordion">';
  foreach($avaliacoes as $ava){
    $qnt1++;
    $estiloD = '';

    $resultados .=  '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'. $ava->id_ava .'">📃 '. $ava->titulo .'</a></div>
        <div class="col-sm-6"> Submetido para o colegidado de <span class="badge badge-success">'.$ava->colegiado.'</span></div>
     </div>
  </div>
    <div id="p'. $ava->id_ava .'" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>'. $ava->nome_prof .'</p>
        <p>'. $ava->tipo_exten .'</p>
        <p>'. $ava->area_extensao .'</p>
        <p>'. $ava->linha .'</p>
        <p>'. $ava->form .'</p>

        Alocado em:
        <ul class="breadcrumb p-1 mb-2"">
          <li class="breadcrumb-item"><a href="#">a</a></li>
          <li class="breadcrumb-item"><a href="#">2/a></li>
          <li class="breadcrumb-item"><a href="#">3</a></li>

          <span class="badge badge-light">Processo<br>
          <div class="btn-group">
            <button type="button" class="btn btn-success" disabled></button>
            <button type="button" class="btn btn-warning" disabled></button>
            <button type="button" class="btn btn-secondary" disabled></button>
            <button type="button" class="btn btn-secondary" disabled></button>
            <button type="button" class="btn btn-secondary" disabled></button>
            <button type="button" class="btn btn-secondary" disabled></button>
        </span>

        </ul>
      </div>
    </div>
  </div>';

  }
  $resultados .= '</div>';
  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


  //GETS
  unset($_GET['status']);
  unset($_GET['pagina']);
  $gets = http_build_query($_GET);

  //Paginação
  $paginacao = '';
  $paginas   = $obPagination->getPages();
  $paginacao .= '<nav aria-label="Page navigation >
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
  <h2 class="mt-0">Avaliaçõs a serem realizadas</h2>
  
  <?=$msg?> 

  <section>

    <form method="get">

      <div class="row my-2">

        <div class="col">
          <label>Buscar por Nome</label> 
          <input type="text" name="busca" class="form-control form-control-sm" value="<?=$busca?>"  id="nome"  onchange="showLimpar();">
        </div>

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
  const modal = document.querySelector("dialog")

  btnOpen.onclick = function(){
    modal.showModa();
  }


  document.getElementById('limpar').hidden = true;

  
  function showLimpar(){
    var nome      = document.getElementById('nome').value;
    var campus    = document.getElementById('campus').value;
    var centro     = document.getElementById('centro').value;
    var colegiado = document.getElementById('colegiado').value;

    if((nome.length > 0 ) | (campus.length > 0)| (centro.length > 0)| (colegiado.length > 0) ) {

      document.getElementById('limpar').hidden = false;
    }
  }

  showLimpar();
  
</script>


