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
     
    $progresso = 
      '<span class="badge badge-light">Processo<br>
        <div class="btn-group">';
     
    for($i = 1; $i <= $ava->etapas; $i++){
      if($i < $ava->fase_seq){
        $cor = 'success';
      } elseif ($i == $ava->fase_seq){
        if($ava->resultado == 'e') {
          $cor = 'warning';
        } else{
          $cor = 'danger';
        }
      } else {
        $cor = 'secondary';
      }
      $progresso .= '<button type="button" class="btn btn-'. $cor .'" disabled></button>';
    }
    $progresso .= 
      '  </div>
      </span>';
    /*------------------*/

    $resultados .=  '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'. $ava->id_ava .'">📃 '. $ava->titulo .'</a></div>
        <div class="col-sm-5">Submetido para o colegidado de <span class="badge badge-success">'.$ava->colegiado.'</span></div>
        <div class="col-sm-2">
           '. 
           $progresso
           .'
        </div>
     </div>
  </div>
    <div id="p'. $ava->id_ava .'" class="collapse" data-parent="#accordion">
      <div class="card-body">


        <h5>Tipo de Proposta</h5>

        <div class="form-group">
            <input type="text" class="form-control" name="tp_proposta" value="'. $ava->tipo_exten .'" readonly>
        </div>
      
  
        <h5>Identificação da Proposta</h5>
     
        <div class="form-group">
          <label>Título</label>
          <input type="text" class="form-control" name="coordNome" value="'.$ava->titulo.'" readonly="">
        </div>
      
        <div class="form-group">
          <label>Proponente</label>
          <input type="text" class="form-control" name="coordNome" value="'. $ava->nome_prof .'" readonly="">
        </div>
      
        <div class="form-group">
          <label>Colegiado de Curso</label>
          <input type="text" class="form-control" name="coordNome" value="'.$ava->colegiado.'" readonly="">
        </div>
        
        <div class="row">
        
          <div class="col">
            <div class="form-group">
              <label for="area_extensao">Área de extensão</label>
              <input type="text" class="form-control" value="'. $ava->area_extensao .'" readonly>
            </div>
          </div>
        
          <div class="col">
            <div class="form-group">
              <label for="linh_ext">Linha de  extensão</label>
              <input type="text" class="form-control" value="'. $ava->linh_ext .'" readonly>
            </div>
          </div>
    
        </div>    
        <hr>
          <div class="d-flex flex-row-reverse ">
            <div class="p-1"></div>
            <a href="../forms/index.php?i='. $ava->id_ava . '&p='. $ava->id_proj . '&v='. $ava->ver . '"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Avaliar</button></a>
            <div class="p-1"></div>
            <a href="../projetos/visualizar.php?id='. $ava->id_proj . '&v='. $ava->ver . '&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> 👀 Visualizar</button></a>
            <div class="p-1"></div>
          </div>
          
          
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
  <h2 class="mt-0">Avaliaçõs realizadas</h2>
  
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
  const modal = document.querySelector("dialog");
  const btnX = document.getElementById("limpar");

  btnOpen.onclick = function(){
    modal.showModa();
  }


  

  btnX.hidden = true;
  
  function showLimpar(){
    var nome      = document.getElementById('nome').value;
    var campus    = document.getElementById('campus').value;
    var centro     = document.getElementById('centro').value;
    var colegiado = document.getElementById('colegiado').value;

    if((nome.length > 0 ) | (campus.length > 0)| (centro.length > 0)| (colegiado.length > 0) ) {

      btnX.hidden = true;
    }
  }

  showLimpar();
  
</script>


