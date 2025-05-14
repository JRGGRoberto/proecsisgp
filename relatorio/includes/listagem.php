<?php

  require('../includes/msgAlert.php');

  $resultados = '';

  foreach($RelFinal as $relf){
    $titulo ='';
    $msgPublicadoFinal = '';

    if($relf->tramitar == 1){
      if($relf->atvd_prox_per1 == 'r' or  $relf->atvd_prox_per2 == 'r') {
        $msgPublicadoFinal = ' <span class="badge badge-danger">Solicitações de alterações</span>';
      } elseif ($relf->atvd_prox_per1 == 'a' and  $relf->atvd_prox_per2 == 'a'){
        $msgPublicadoFinal = ' <span class="badge badge-success">Publicado</span>';
      } else {
        $msgPublicadoFinal = ' <span class="badge badge-warning">Em análise</span>';
      }
    } else {
      $msgPublicadoFinal = ' <span class="badge badge-warning">Não posto em analise (tramitar)</span>';
    }
    
    switch(($relf->tipo))
    {
      case 'f':
        $titulo =  'Final - Período: ' . formatData($obProjeto->vigen_ini).' à '. formatData($obProjeto->vigen_fim) ;
        break; 
      case 'p': 
        $titulo =  'Final com pedido de prorrogação - Período: ' . formatData($obProjeto->vigen_ini).' à '. formatData($obProjeto->vigen_fim) .' - Prorrogado até: '. formatData($relf->periodo_prorroga_fim);
        break; 
      case 'r': 
        $titulo =  'Final com pedido de renovação';
        break; 
      default: 
        $titulo =  'não definido';
        break;
    }

    $resultados .= '<div class="card">';
    $resultados .= '<div class="card-body">';
    $resultados .= $msgPublicadoFinal;
    $resultados .= '<h5 class="card-title">Relatório '. $titulo .'</h5>';
    $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades realizadas</h6>';
    $resultados .= '<p class="card-text">'.$relf->atividades.'</p>';
    $resultados .= '<a href="editar2.php?id='.$relf->id.'" class="card-link">Visualizar</a> ';
    $resultados .= '</div>';
    $resultados .= '</div>'; 
  }

  foreach($relParcial as $rel){
    $msg_orBTN = '';
    $editar = '';
    $msgPublicadoParcial = ' <span class="badge badge-warning">Não posto em analise (tramitar)</span>';
      
    
    if($rel->tramitar == 1){
      $msg_orBTN = ' <a id=  href="editar1.php?id='.$rel->id.'" class="card-link">Visualizar</a> ';
      switch($rel->last_result)
      {
        case 'a':
          $msgPublicadoParcial = ' <span class="badge badge-success">Publicado</span>';
          break; 
        case 'r': 
          $msgPublicadoParcial = ' <span class="badge badge-danger">Solicitações de alterações</span>';
          break; 
        default: 
          $msgPublicadoParcial = ' <span class="badge badge-warning">Em análise</span>';
          break;
      }

    } else {
      if($rel->tramitar == 0){
        
        $msg_orBTN = '<a id="p'.$rel->id.'" href="#" onclick="printDel(event)">Excluir</a> ';
        $msg_orBTN .=' <a href="editar1.php?id='.$rel->id.'" class="card-link">Editar</a>';
    } else {
      if(strlen((string)$rel->ava_comentario) > 0){
          $msg_orBTN .= ' Há uma solicitação de ajusto no relatório. ';
        } else {
          $msg_orBTN .= '<a href="editar1.php?id='.$rel->id.'" class="card-link">Visualizar</a> Relatório a espera do aceite da Divisão de Extensao e Cultura do Campus. ';
        }
      }
    }
    $resultados .= '<div class="card">';
    $resultados .= '<div class="card-body">';
    $resultados .= $msgPublicadoParcial;
    $resultados .= '<h5 class="card-title">Relatório Parcial referente '. formatData($rel->periodo_ini).' à '. formatData($rel->periodo_fim).'</h5>';
    $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades realizadas</h6>';
    $resultados .= '<p class="card-text">'.$rel->atvd_per.'</p>';
    $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Alterações</h6>';
    $resultados .= '<p class="card-text">'.$rel->alteracoes.'</p>';
    $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades para o próximo período</h6>';
    $resultados .= '<p class="card-text">'.$rel->atvd_prox_per.'</p>';
    $resultados .= '<p class="card-text"><small class="text-muted">Cadastrado em '.formatData($rel->created_at).'</small></p>';
    $resultados .= $msg_orBTN; 
    $resultados .= '</div>';
    $resultados .= '</div>';
  }
 
?>


<main>
  <h2 class="mt-0">Relatórios</h2>
  <hr>
 

  
  <div class="form-group">
    <div>
      <h5>Título da proposta</h5>
      <input type="text" class="form-control" value="<?=$obProjeto->titulo; ?>" readonly><br>
    </div>
    <div class="row">

          <div class="col-3">
            <div class="form-group">
              <label>Modalidade</label>
              <input type="text" class="form-control" value="<?=$tipo; ?>" readonly>
              
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_ini, 0, 10); ?>" readonly>
            </div>
          </div>
          
          <div class="col-2">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_fim, 0, 10); ?>" readonly>
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
               <label>Projeto</label><br>
                <a href="../projetos/visualizar.php?id=<?=$obProjeto->id; ?>&amp;v=<?=$obProjeto->ver; ?>&amp;w=1" target="_blank">
                  <button class="btn btn-success btn-sm mb-2">Visualizar</button>
                </a>
            </div>
          </div>

         </div>
         <hr>
         
  </div>
  
  <?=$msgAlert?> 

  <section>
    
    <?=$resultados?>
    
  </section>

<?= $novoBTNs?>
  <div class="form-group">
    <a href="../projetos/" class="btn btn-success btn-sm mb-2">Voltar</a>
  </div>

</main>

  <!-- The Modal -->
  <div class="modal fade" id="modalSub">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Título</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="modalBody">

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id="modalFooter">
          
        </div>
        
      </div>
    </div>
  </div>
  <!-- The Modal -->

<script>

function printDel(event){
    event.preventDefault(); 
    console.log(event.target.id);
    // excluir1.php
    modalTitle.innerText = 'Confirmação de exclusão';
    modalBody.innerHTML =  `<h4>Tem certeza que deseja apagar o registro de relatório?</h4><p class="justify-content-center"></p><span class="badge badge-warning float-right" ><span class="badge badge-light">⚠️</span>Atenção! O processo não pode ser revertido</span>`;
    modalFooter.innerHTML = `
            <a href="excluir1.php?id=${event.target.id}" class="btn btn-danger    btn-sm mb-2">🗑  Excluir</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }


</script>







