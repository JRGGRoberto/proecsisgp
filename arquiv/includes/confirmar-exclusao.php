<main>

  <h2 class="mt-3">Excluir arquivo</h2>

  <form method="post">

    <div class="form-group">
      <p>Você deseja realmente excluir o arquivo <strong>
      <a href="../upload/uploads/<?=$objArquivo->nome_rand ?>" target="_blank"><?=$objArquivo->nome_orig ?></a> 
      
        </strong>?</p>
    </div>
    
    <div class="form-group">
      <a href="../<?=$objArquivo->tabela?>/editar.php?id=<?=$id_tab?>">
        <button type="button" class="btn btn-success">Cancelar</button>
      </a>

      <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
    </div>

  </form>

</main>