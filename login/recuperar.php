<?php

if (isset($_GET['erro'])) {
    if ($_GET['erro'] == 1) {
        $alerta = '<div class="alert alert-warning">Dados não encontrados. Entre em contato com o coordenador de curso.</div>';
    } elseif ($_GET['erro'] == 2) {
        $alerta = '<div class="alert alert-warning">Conta inativa, favor entre em contato com o coordenador de curso.</div>';
    } else {
        $alerta = '<div class="alert alert-danger">!?</div>';
    }
}

if (isset($_GET['sucesso'])) {
    $alerta = '<div class="alert alert-success">Foi enviado uma nova senha para o email fornecido.</div>';
}

include '../includes/headers.php';

?>

<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <!-- LADO ESQUERDO -->
    <div class="col text-center">
        <h2>UNESPAR</h2>
        <img src="../imgs/logo_unespar.png" width="150" height="160">
        <hr>
        <h3>Sistema para Gerir Projetos </h3>
        <h4><span style="color: #002661;">PRO</span><span style="color: #007F3D;">EC</span></h4>  
        <span><span style="color: #002661;">Sis</span><span style="color: #007F3D;">PROEC</span></span>
    </div>

    <!-- LADO DIREITO -->
    <div class="col">

      <form method="post" action="./recuperar_valida.php">

        <h2>Recuperar senha</h2>
        <?php echo $alerta; ?>

        <div class="form-group">
          <label>Email</label>
          <input type="email"
          class="form-control"
          name="email"
            placeholder="seu@email.com"
            required>
        </div>

        <div class="form-group">
          <button type="submit" id="btnOk" class="btn btn-primary">
            📩 Enviar
          </button>

          <div>&nbsp;</div>

          <div class="alert alert-info col">
            Informe seu e-mail para recuperar o acesso.
          </div>
        </div>

      </form>

      <div class="d-flex justify-content-between">
        <a href="./login.php" class="btn btn-primary btn-sm">
          🔑 Voltar ao login
        </a>
      </div>

    </div>

  </div>

</div>

<?php
include '../includes/footer.php';
?>