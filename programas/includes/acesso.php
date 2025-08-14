<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <div class="col-6">

        <h2 class="text-center"><img src="https://sistemaproec.unespar.edu.br/sistema/imgs/logo_unespar.png" class="d-inline-block align-top" alt="" loading="lazy" width="64" height="68">UNESPAR</h2>
        
        <hr>
        <h4>Programas</h4>
        <?php echo $txt; ?>


        

    </div>

    <div class="col">

      <form method="post" enctype="multipart/form-data"  action="./valida.php">

        <h2>Cadastrar / Acessar</h2>
        <!-- ?php echo $alertaLogin; ? -->

        <div class="form-group">
            <label>CPF <sub> [Digite apenas os números]</sub></label>
            <div class="row">
              <div class="col-4">
                <input id="cpf" type="text" class="form-control " name="cpf" maxlength="14" value="" inputmode="numeric" autocomplete="off" placeholder="000.000.000-00" required  />
              </div>
              <div class="col">
                <button type="submit"  class="btn btn-primary">🔑 Entrar</button>
              </div>
            </div>
        </div>
        <div class="alert alert-info col-6">IP de acesso: <?php echo $ip; ?></div>
      </form>
    </div>
  </div>
</div>

<script>

const cpfInput = document.getElementById('cpf');

    // Bloqueia teclas que não são dígitos (permite controles: backspace, setas, ctrl/cmd, delete, tab)
    cpfInput.addEventListener('keydown', (e) => {
      const allowedControls = [
        'Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End'
      ];
      if (allowedControls.includes(e.key) || e.ctrlKey || e.metaKey) return;
      // se não for dígito, previne
      if (!/^[0-9]$/.test(e.key)) e.preventDefault();
    });

    // Formata no evento input (inclui digitação e remoção)
    cpfInput.addEventListener('input', onInput);

    // Trata colar (paste) para aceitar só dígitos
    cpfInput.addEventListener('paste', (e) => {
      e.preventDefault();
      const pasted = (e.clipboardData || window.clipboardData).getData('text');
      const digits = pasted.replace(/\D/g, '').slice(0, 11);
      cpfInput.value = formatCPF(digits);
    });

    function onInput() {
      // Remove qualquer caractere não-dígito e limita a 11 dígitos
      const onlyDigits = cpfInput.value.replace(/\D/g, '').slice(0, 11);
      cpfInput.value = formatCPF(onlyDigits);
      // colocar o cursor no fim (simples e robusto)
      cpfInput.setSelectionRange(cpfInput.value.length, cpfInput.value.length);
    }

    function formatCPF(digits) {
      if (!digits) return '';
      if (digits.length <= 3) return digits;
      if (digits.length <= 6) return digits.slice(0,3) + '.' + digits.slice(3);
      if (digits.length <= 9) return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6);
      return digits.slice(0,3) + '.' + digits.slice(3,6) + '.' + digits.slice(6,9) + '-' + digits.slice(9,11);
    }

</script>