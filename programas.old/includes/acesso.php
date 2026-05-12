<?php
$alertaLogin = strlen($alertaLogin ?? '') ? '<div class="alert alert-danger">'.$alertaLogin.'</div>' : '';
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

    <div class="col">

      <form method="post" action="./valida.php">

        <h2>Acessar</h2>
        <?php echo $alertaLogin; ?>

        <div class="form-group">
          <label>CPF</label>
          <input id="cpf" type="text" name="cpf" class="form-control"
            placeholder="000.000.000-00" maxlength="14"
            inputmode="numeric" autocomplete="off" required>
        </div>

        <div class="form-group">
          <label>Senha</label>
          <input id="senha" type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>

        <div class="form-group ">
          <button type="submit" id="btnOk" class="btn btn-primary ">
            🔑 Entrar
          </button>
          <div>&nbsp;</div>
          <div class="alert alert-info col">
            Se não tiver cadastro ou esqueceu a senha:
          </div>
        </div>

      </form>
      <div class="d-flex justify-content-between">
        <a href="./cadastrar.php" class="btn btn-primary btn-sm float-right">
          ✏️ Cadastro 
        </a>
        <a href="./recuperar.php" class="btn btn-primary btn-sm float-right">
          📑 Recuperar senha
        </a>
      </div>
    </div>
  </div>
</div>

<script>
const cpfInput = document.getElementById('cpf');

// máscara CPF
cpfInput.addEventListener('input', () => {
  const onlyDigits = cpfInput.value.replace(/\D/g, '').slice(0, 11);
  cpfInput.value = formatCPF(onlyDigits);
});

function formatCPF(digits) {
  if (digits.length <= 3) return digits;
  if (digits.length <= 6) return digits.slice(0,3) + '.' + digits.slice(3);
  if (digits.length <= 9) return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6);
  return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6,9) + '-' + digits.slice(9,11);
}
</script> 