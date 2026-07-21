
<!--mudar essa bomba para uma página espe´cifica -->
<form method="post" id="formInsc">
  <div class="container justify-content-center">
    <div class="row">
      <div class="col">
        <div class="form-group">
          <label>Projeto [escolha uma para se inscrever]</label>
          <select name="inscricao"  class="form-control" id="inscricao">
            <option value="-1">Selecione uma opção ou deste esta apenas para atualizar dados</option>
            <?php echo $options; ?>
          </select>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col">
        <div class="form-group" id="listaInscricoes"></div>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button>
    </div>
  </div>
</form>

    <div class="modal fade" id="confirmModalOpen" tabindex="-1" aria-labelledby="confirmCloseLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="confirmCloseLabel">Confirmar ação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            Tem certeza remover a inscrição do programa? 
            <p><strong id="alertIdLabel"></strong></p>
            <form method="post" id="frmdelInscr">
              <input type="hidden" name="id_cand_del" id="id_cand_del" value="<?php echo ''; ?>">
              <input type="hidden" name="id_prog_del" id="id_prog_del" value="<?php echo ''; ?>">
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" id="btnNao" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            <button type="button" id="btnSim" class="btn btn-danger">Sim</button>
          </div>

        </div>
      </div>
    </div>
<script src="./dados.js"></script>

