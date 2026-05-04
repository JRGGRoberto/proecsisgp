<?php


if (isset($_GET['erro'])) {
  if($_GET['erro'] == 'cpf_invalido') {
    $alertaLogin = 'CPF inválido.';
  } elseif ($_GET['erro'] == '1'){
    $alertaLogin = 'Já existe um usuário com esse CPF cadastrado no sistema.';
  }
}

$alertaLogin = strlen($alertaLogin ?? '') ? '<div class="alert alert-danger">'.$alertaLogin.'</div>' : '';


include '../includes/headersCl.php';
?>

<p></p>
<div class="jumbotron text-dark">

  <div class="row">
    <div class="col text-center">

        <h2>UNESPAR</h2>
        <img src="https://sistemaproec.unespar.edu.br/sistema/imgs/logo_unespar.png" width="150" height="160">
        <hr>
        <h3>Sistema de ???</h3>
    </div>

    <div class="col">
      <form method="post" action="./cadastrar_valida.php">
        <h2>Cadastro</h2>
        <?php echo $alertaLogin; ?>

        <div class="form-group">
          <label>CPF</label>
          <input id="cpf" type="text" name="cpf" class="form-control"
            placeholder="000.000.000-00"
            maxlength="14"
            inputmode="numeric"
            autocomplete="off"
            required>
        </div>

        <div class="form-group">
          <button type="submit" id="btnOk" class="btn btn-primary">
            📝 Enviar 
          </button>

          <div>&nbsp;</div>
          <div class="alert alert-info col">
            Insira seu CPF para iniciar o processo de cadastro.
          </div>

        </div>

      </form>

      <a href="./index.php" class="btn btn-primary btn-sm">
        🔑 Já tenho conta
      </a>

    </div>

  </div>

</div>

<script>
const cpfInput = document.getElementById('cpf');

// bloqueia letras
cpfInput.addEventListener('keydown', (e) => {
  const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete'];
  if (allowed.includes(e.key) || e.ctrlKey || e.metaKey) return;
  if (!/^[0-9]$/.test(e.key)) e.preventDefault();
});

// máscara
cpfInput.addEventListener('input', () => {
  const digits = cpfInput.value.replace(/\D/g, '').slice(0, 11);
  cpfInput.value = formatCPF(digits);
});

function formatCPF(digits) {
  if (digits.length <= 3) return digits;
  if (digits.length <= 6) return digits.slice(0,3) + '.' + digits.slice(3);
  if (digits.length <= 9) return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6);
  return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6,9) + '-' + digits.slice(9,11);
}


function validaCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');

  if (cpf.length !== 11) return false;

  // elimina CPFs tipo 11111111111
  if (/^(\d)\1+$/.test(cpf)) return false;

  let soma = 0;
  let resto;

  // 1º dígito
  for (let i = 1; i <= 9; i++) {
    soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(9, 10))) return false;

  // 2º dígito
  soma = 0;
  for (let i = 1; i <= 10; i++) {
    soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(10, 11))) return false;

  return true;
}

const form = document.querySelector('form');

form.addEventListener('submit', (e) => {
  const cpf = cpfInput.value;

  if (!validaCPF(cpf)) {
    e.preventDefault();
    window.location.href = 'cadastrar.php?erro=cpf_invalido';
    cpfInput.focus();
  }
});

</script>

<?php


include '../includes/footer.php';
?>