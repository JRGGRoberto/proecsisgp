<main>

  <h2 class="mt-3">Excluir arquivo</h2>

  <form method="post">

    <div class="form-group">
      <p>Você deseja realmente excluir o arquivo <strong>
      <a href="../upload/uploads/<?php echo $objArquivo->nome_rand; ?>" target="_blank"><?php echo $objArquivo->nome_orig; ?></a> 
      
        </strong>?</p>
    </div>
    
    <div class="form-group">
      <button type="button" class="btn btn-success btn-sm" onclick="history.back()">Cancelar</button>
      <input type="hidden" name="backWay" value=<?php echo $_SERVER['HTTP_REFERER']; ?> >
      <button type="submit" name="excluir" class="btn btn-danger btn-sm">🗑️ Excluir</button>

    </div>

  </form>

</main>