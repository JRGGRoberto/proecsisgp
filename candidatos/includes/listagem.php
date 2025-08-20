<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

$nomeProgSelecionado = '';
if (isset($_POST['acao'])) {
    foreach ($programas as $prog3) {
        if ($prog3->id == $idP) {
            $nomeProgSelecionado = $prog3->prog;
        }
    }
}

?>

<style>
    .alert {
        transition: transform 0.4s ease, opacity 0.4s ease;
    }
    .moving {
        z-index: 1;
    }
    /* Animação ao excluir */
    .fade-out {
           opacity: 0;
           transform: scale(0.95);
    }

    .fade {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }
    
    .fade.show {
        opacity: 1;
        visibility: visible;
    }

    .btn-container {
        display: flex;
        
    }
    .hidden-div {
        display: none;
    }

</style>

<main>
  <h2 class="mt-0">Lista de candidatos <?php echo $nomeProgSelecionado ? ' para o programa <br>'.$nomeProgSelecionado : ' <span class="badge badge-light">Selecione um progrograma.</span> '; ?> </h2>
  <?php echo $btnsProgs; ?>
  <?php echo $btnSalvar; ?>
  <form method="post" name="formSalvaDados" id="formSalvaDados" >
      <input type="hidden" name="altDados" id="altDados">
  </form>

  
  
  <section>
Lista Ranqueada
    <div class="form-group" id="listaRanc">
      <!-- Lista será carregada dinamicamente -->
    </div>
Lista de desclassificados ou não ranqueados
    <div class="form-group" id="listaInscricoes">
      <!-- Lista será carregada dinamicamente -->
    </div>
    
  </section>
</main>



    <!-- The Modal -->
    <div class="modal" id="modalConfirmDesc">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Desclassificar candidato</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
              <p>Para realizar a desclassificação, é obrigatório informar uma justificativa no campo abaixo</p>
              <textarea name="obs" id="obs" rows="5" class="form-control"></textarea>
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" id="btnConfirmar" class="btn btn-danger" disabled>Confirmar cancelamento</button>
              <button type="button" id="btnCancelar" class="btn btn-secondary" data-dismiss="modal">Não alterar</button>
            </div>
            <div id='tp'class="hidden-div"></div>
            <div id='idx'class="hidden-div"></div>
          </div>
        </div>
    </div>
    
  
    <!--  The Modal ADD / EDT Fim-->

<script src="candidatos.js"></script>







