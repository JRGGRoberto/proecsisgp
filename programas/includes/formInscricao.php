
<!--mudar essa bomba para uma página espe´cifica -->
<?php
$msgTitulo = 'PIBIS / PIBEX';
if (strlen($filtro) > 1) {
    $msgTitulo = strtoupper($filtro);
}
?>


<form method="post" id="formInsc">
  <div class="container justify-content-center">
    <div class="row">
      <div class="col">
        <div class="form-group">
          <h2 class="mb-4"><?php echo $msgTitulo; ?></h2>
          
          <label class="mt-5">Projetos [escolha um para mais informações] </label>


          <div>
            <select class="form-control" id="inscricao" name="inscricao" onchange="geraCriterio(this.value);">
              <option value="-1">
                Selecione um projeto ou deixe esta opção para apenas atualizar dados
              </option>
              <?php echo $options; ?>
            </select>
          </div>
          <div id="cont-criterio">
            
          </div>
        </div>
      </div>  
    </div>

    <div class="row mt-3">
      <div class="col">
        <div id="criteriosAvaliacao"></div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="form-group" id="listaInscricoes"></div>
      </div>
    </div>
    <div class="form-group d-flex justify-content-between align-items-center">

        <a href="./home.php" class="btn btn-sm btn-success">
          Voltar
        </a>

        <button type="submit" class="btn btn-sm btn-primary">
          Inscrever
        </button>

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
            Tem certeza remover a inscrição do projeto? 
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

