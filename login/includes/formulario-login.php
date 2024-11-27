<?php 
  $alertaLogin  = strlen($alertaLogin) ? '<div class="alert alert-danger">'.$alertaLogin.'</div>': '';
  $alertaCadastro = strlen($alertaCadastro) ? '<div class="alert alert-danger">'.$alertaCadastro.'</div>': '';
?>
<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <div class="col text-center">

        <img src="../imgs/logo_unespar.png" width="150" height="160">
        <hr>
        <h3>Sistema de Gestão de Projetos de Extensão</h3>
        
        <h2>PROEC</h2>

    </div>

    <div class="col">

      <form method="post">

        <h2>Login</h2>
        <?=$alertaLogin?>

        <div class="form-group">
          <label>E-mail</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>

        <div class="form-group">
          <button type="submit" name="acao" value="logar" class="btn btn-primary">🔑 Entrar</button>
        </div>

      </form>
      <a href="./recupera.php" class="btn btn-light btn-sm float-right">📑 Recuperar senha</a>


    </div>

  </div>

</div>