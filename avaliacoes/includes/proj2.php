<?php

require '../includes/msgAlert.php';

$qnt1 = 0;
$resultados = '';
foreach ($avaliacoes as $ava) {
    ++$qnt1;
    $estiloD = '';
    $cor = '';

    if ($ava->resultado == 'r') {
        $cor = 'warning';
        $progresso = '<span class="badge badge-warning"> ↩️ Solicitação de revisão</span>';
    } elseif ($ava->resultado == 'a') {
        $progresso = '<span class="badge badge-success"> 🆗 Favorável</span>';
        $cor = 'success';
    } else {
        $progresso = '<span class="badge badge-danger">Error</span>';
        $cor = 'danger';
    }

    /* ------------------ */
    $titulo = $ava->titulo;
    if ($ava->ver > 0) {
        $titulo .= ' [Versão: '.($ava->ver + 1).']';
    }

    $resultados .= '
<div class="card mt-2">
  <div class="card-header">
     <div class="row">
        <div class="col-sm-5"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$ava->id_ava.'">📃 '.$titulo.'</a></div>
        <div class="col-sm-7">
           '.
           $progresso
           .'

            <div class="d-flex flex-row-reverse ">
              <div class="p-1"></div>
              <a href="../forms/'.$ava->form.'/vista.php?p='.$ava->id_proj.'&v='.$ava->ver.'" target="_blank"><button class="btn btn-primary btn-sm mb-2"> ⚖️ Ver avaliação</button></a>
              <div class="p-1"></div>
              <a href="../propostas/visualizar.php?id='.$ava->id_proj.'&v='.$ava->ver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2"> Visualizar projeto</button></a>
              <div class="p-1"></div>
            </div>
           

        </div>
     </div>
  </div>
</div>    

          
';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

$resultados .=
'<section>
    <div class="row mt-2 align-bottom">
      <div class="col">'
        .$paginacao.
'      </div>
    </div>
  </section>';

?>

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


