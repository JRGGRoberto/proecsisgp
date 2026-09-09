
<main>
  <h2 class="mt-0">Ações de curricularização da extensão</h2>
    <div class="form-group">
        <div class="row">
          <div class="col-2">
            <div class="form-group">
              <label for="ca">Campus</label>
              <select name="id_campus" id="ca" class="form-control" required>
                <?php echo $CAop; ?>
              </select>
            </div> 
          </div>
    
          <div class="col-5">
            <div class="form-group">
              <label for="ce">Centro</label>
              <select name="id_centro"  id="ce" class="form-control" required>
              <?php echo $CEop; ?>
              </select>
            </div> 
          </div>
    
          <div class="col-5">
            <div class="form-group">
              <label for="co">Colegiado</label>
              <select name="id_colegiado" id="co" class="form-control" required>
                <?php echo $Coop; ?>
              </select>
            </div> 
          </div>
        </div>
        <a target="_blank" rel="noopener noreferrer" hidden class="btn btn-sm btn-primary float-right" id="btnGerar">Gerar</a>
    </div>
</main>
<script src="ccc.js"></script>
<?php echo $script; ?>