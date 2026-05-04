 <?php
$alertaLogin = strlen($alertaLogin) ? '<div class="alert alert-danger">'.$alertaLogin.'</div>' : '';

?>
<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <div class="col text-center">

        <h2>UNESPAR</h2>
        <img src="../imgs/logo_unespar.png" width="150" height="160">
        <hr>
        <h3>Sistema para Gerir Projetos </h3>
        <h4><span style="color: #002661;">PRO</span><span style="color: #007F3D;">EC</span></h4>  
        <span><span style="color: #002661;">Sis</span><span style="color: #007F3D;">PROEC</span></span>

    </div>

    <div class="col">

      <form method="post" enctype="multipart/form-data">

        <h2>Login</h2>
        <?php echo $alertaLogin; ?>

        <div class="form-group">
          <label>E-mail</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>

        <div class="form-group">
          
            
          <button type="submit"  class="btn btn-primary">🔑 Entrar</button>
          <div>&nbsp;</div>
          <div class="alert alert-info col">Usuário = <strong>nome.sobrenome + @unespar.edu.br</strong><br>
          Senha = (senha do Domínio da Rede Local)</div>

        </div> 
      
      </form>
      <a href="./recuperar.php" class="btn btn-primary btn-sm float-right">📑 Recuperar senha</a>
<!-- name="acao" value="logar"
      <br>
      <a href="../projetostb/" class="btn btn-success" id="projEfet">📑 Propostas efetivadas</a>
      <label for="projEfet">Acessar projetos que já passaram por todos os crivos estabelecidos</label>
-->

    </div>

  </div>

</div>