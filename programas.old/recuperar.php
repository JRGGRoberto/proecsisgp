<?php

if (isset($_GET['erro'])) {
  $alerta = '<div class="alert alert-warning">Dados não encontrados. Entre em contato com o coordenador de curso.</div>';
}

if (isset($_GET['sucesso'])) {
  $alerta = '<div class="alert alert-success">Foi enviado uma nova senha para o email fornecido.</div>';
}


include '../includes/headersCl.php';

?>

<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <!-- LADO ESQUERDO -->
    <div class="col text-center">
        <h2>UNESPAR</h2>
        <img src="https://sistemaproec.unespar.edu.br/sistema/imgs/logo_unespar.png" width="150" height="160">
        <hr>
        <h3>Sistema de ???</h3>
    </div>

    <!-- LADO DIREITO -->
    <div class="col">

      <form method="post" action="./recuperar_valida.php">

        <h2>Recuperar senha</h2>
        <?php echo $alerta; ?>

        <div class="form-group">
          <label>Data de nascimento</label>
          <input id="data_nascimento" type="text"
            class="form-control"
            name="data_nascimento"
            placeholder="dd/mm/aaaa"
            inputmode="numeric"
            maxlength="10"
            required>
        </div>

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
            Informe seu e-mail e data de nascimento para recuperar o acesso.
          </div>
        </div>

      </form>

      <div class="d-flex justify-content-between">
        <a href="./index.php" class="btn btn-primary btn-sm">
          🔑 Voltar ao login
        </a>

        <a href="./cadastrar.php" class="btn btn-primary btn-sm">
          ✏️ Criar conta
        </a>
      </div>

    </div>

  </div>

</div>

<script>
const dataInput = document.getElementById('data_nascimento');

// máscara data
dataInput.addEventListener('input', () => {
  let digits = dataInput.value.replace(/\D/g, '').slice(0, 8);

  if (digits.length >= 5) {
    dataInput.value = digits.replace(/(\d{2})(\d{2})(\d{0,4})/, '$1/$2/$3');
  } else if (digits.length >= 3) {
    dataInput.value = digits.replace(/(\d{2})(\d{0,2})/, '$1/$2');
  } else {
    dataInput.value = digits;
  }
});
</script>

<?php
include '../includes/footer.php';
?>