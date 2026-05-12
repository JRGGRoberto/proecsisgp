<?php
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

?>
<script src="./jquery.mask.min.js"></script>    
<script src="./ccc.js"></script>
<main>

  <section>
    <a href="index.php">
      <button class="btn btn-sm btn-success float-right">Voltar</button>
    </a>
  </section>

  <h2 class="mt-3"><?php echo TITLE; ?></h2>

  <form method="post" id="formprof">
    
    <div class="row">
                          
     <input id="idprf" name="idprf" type="text" hidden value="<?php echo $obAgente->id; ?>">

      <div class="col-8">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" class="form-control" name="nome" maxlength="60"  value="<?php echo $obAgente->nome; ?>" required>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>CPF</label>
          <a href="#" data-toggle="tooltip" title="Informe apenas os números" 
          style="text-decoration:none;"><input type="text" class="form-control" name="cpf" id="cpf" maxlength="11" value="<?php echo $obAgente->cpf; ?>" onfocusout="valCPF()" ></a>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="form-group">
          <label>E-mail <?php echo $infoMail[0]; ?></label>
          <input type="email" class="form-control" name="email" id="email" maxlength="40" value="<?php echo $obAgente->email; ?>" onfocusout="valEmail()" required <?php echo $infoMail[1]; ?>>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="ca">Campus</label>
          <select name="lotacao" id="ca" class="form-control" required>
             <option value="">Selecione</option>
             <?php echo $opts; ?>
          </select>
        </div> 
      </div>


      <?php
echo "<script>
  let campusId = document.getElementById('ca'); 
  campusId.value = '".$obAgente->lotacao."';
</script>";
?>

    </div>

  
    <div class="row">
      <div class="col">
        
        <div class="form-group">
          <label>Categoria funcional</label>
          <div>
              <div class="form-check form-check-inline">
                <label class="form-control">
                  <input type="radio" name="cat_func" value="e" <?php echo $obAgente->cat_func == 'e' ? 'checked' : ''; ?>> Efetivo
                </label>
              </div>
    
              <div class="form-check form-check-inline">
                <label class="form-control">
                  <input type="radio" name="cat_func" value="c" <?php echo $obAgente->cat_func == 'c' ? 'checked' : ''; ?>> Colaborador
                </label>
              </div>
          </div>
        </div>
      </div>

      <div class="col-2">
        <div class="form-group">

        <label>Estado da conta 
                    <label for="ativo" class="form-control">Ativa
                        <input type="checkbox" 

                        name="ativo" value="1" checked>
                    </label>
               </label>
        </div>
      </div>

      


     <div class="col">
       <div class="form-group">
         <label>Senha <?php echo TITLE != 'Cadastrar professor' ? '<span class="badge badge-warning">Não mexa para não alterá-la</span>' : null; ?> </label>
         <input type="password" class="form-control" name="senha" >
       </div>
     </div>
     <div class="col">
       <!--
        <div class="form-group">
         <label>.</label>
         <input type="password" class="form-control" name="csenha" disabled>
       </div>-->
     </div> 
      
      
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button>
      <button type="reset" class="btn btn-success">Limpar</button>
    </div>

  </form>
</main>
