<main>

  <section>
    <a href="../index.php">
      <button class="btn btn-success">Voltar</button>
    </a>
  </section>
  

  

  <h2 class="mt-3"><?=TITLE?></h2>

  <form method="post">
    <div class="form-group">
      <label>Nome</label>
      <input type="text" class="form-control" name="nome" value="<?=$obPessoa->nome?>">
    </div>

    <div class="row">

      <div class="col">

        <div class="form-group">
          <label>CPF</label>
          <input type="text" class="form-control" name="cpf" value="<?=$obPessoa->cpf?>">
        </div>

      </div>

      <div class="col">
        
        <div class="form-group">
          <label>E-mail</label>
          <input type="email" class="form-control" name="email" value="<?=$obProfessor->email?>">
        </div>

      </div>

      <div class="col">
        
        <div class="form-group">
          <label>Telefone</label>
          <input type="tel" class="form-control" name="tel" value="<?=$obPessoa->tel?>">
        </div>

      </div>

    </div>

 <!--   <div class="row">

      <div class="col-4">

        <div class="form-group">
          <label>Data de nascimento</label>
          <input type="date" class="form-control" name="dt_nasc" value="<?=$obPessoa->dt_nasc?>">
        </div>

      </div>
    </div>
-->
    <div >

      

        <div class="form-group">
          <label for="campus">Campus</label>
          <input type="text" class="form-control" name="$campus" disabled value="<?= $campus->nome ?>">
        </div>
        
      
    <div class="row">
      <div class="col">
        

      
        <div class="form-group">
          <label>Categoria funcional</label>
          <div>
              <div class="form-check form-check-inline">
                <label class="form-control">
                  <input type="radio" name="cat_func" value="e" checked disabled> Efetivo
                </label>
              </div>
    
              <div class="form-check form-check-inline">
                <label class="form-control">
                  <input type="radio" name="cat_func" disabled value="c" <?=$obProfessor->cat_func == 'c' ? 'checked' : ''?>> Colaborador
                </label>
              </div>
          </div>
        </div>
      </div>
      
      
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button>
      <button type="reset" class="btn btn-success">Limpar</button>
    </div>

  </form>

</main>


    
