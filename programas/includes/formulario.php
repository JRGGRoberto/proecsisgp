<main>

  
  <h2 class="mt-3">Dados </h2>
  <div class="row">
    <div class="col-9"> <hr>
    </div>
    <div class="col">
        <span class="alert alert-info ">IP de acesso: <strong><?php echo $ip; ?></strong></span>
    </div>
  </div>

  <div class="row">
    <div class="col-9">&nbsp;
    </div>
  </div>
  
  <form method="post" id="formprof">
    
    <div class="row">
                          
      <div class="col-6">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" class="form-control" name="nome" maxlength="60"  value="<?php echo $cand->nome; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>CPF</label>
          <input type="text" class="form-control" name="cpf" id="cpf" maxlength="11" value="<?php echo $cpf; ?>" readonly>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>RG</label>
          <input type="text" class="form-control" name="rg" maxlength="20"  value="<?php echo $cand->rg; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Data de nascimento</label>
          <input type="date" class="form-control" name="dt_nasc" value="<?php echo $cand->dt_nasc; ?>" required>
        </div>
      </div>

    </div>

    <div class="row">
                          
      <div class="col-4">
        <div class="form-group">
          <label>Endereço</label>
          <input type="text" class="form-control" name="ender" maxlength="45"  value="<?php echo $cand->ender; ?>" required>
        </div>
      </div>


      <div class="col">
        <div class="form-group">
          <label>Bairro</label>
          <input type="text" class="form-control" name="bairro" maxlength="40"  value="<?php echo $cand->bairro; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Cidade</label>
          <input type="text" class="form-control" name="cidade" maxlength="40"  value="<?php echo $cand->cidade; ?>" required>
        </div>
      </div>

      <div class="col-1">
        <div class="form-group">
          <label>UF</label>
          <input type="text" class="form-control" name="uf" maxlength="2"  value="<?php echo $cand->uf; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>CEP</label>
          <input type="text" class="form-control" name="cep" maxlength="9"  value="<?php echo $cand->cep; ?>" required>
        </div>
      </div>

    </div>

    <div class="row">
                          
      <div class="col">
        <div class="form-group">
          <label>Telefone</label>
          <input type="text" class="form-control" name="tel1" maxlength="15"  value="<?php echo $cand->tel1; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Telefone</label>
          <input type="text" class="form-control" name="tel2" maxlength="15"  value="<?php echo $cand->tel2; ?>" >
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>eMail</label>
          <input type="email" class="form-control" name="email" maxlength="45"  value="<?php echo $cand->email; ?>" required>
        </div>
      </div>

    </div>

    <div class="row">
                          
      <div class="col">
        <div class="form-group">
          <label>Curso</label>
          <input type="text" class="form-control" name="curso" maxlength="38"  value="<?php echo $cand->curso; ?>" required>
        </div>
      </div>

      <div class="col-1">
        <div class="form-group">
          <label>Série</label>
          <input type="text" class="form-control" name="serie" maxlength="1"  value="<?php echo $cand->serie; ?>" required>
        </div>
      </div>

    </div>
    <hr>
    
    

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
        <div class="form-group" id="listaInscricoes">
        </div>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button>

    </div>

  </form>

</main>


<!-- Modal de Confirmação -->
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


<script src="dados.js"></script>
