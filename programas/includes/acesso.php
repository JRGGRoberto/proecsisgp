<p></p>
<div class="jumbotron text-dark">

  <div class="row">

    <div class="col">

        <h2 class="text-center"><img src="https://sistemaproec.unespar.edu.br/sistema/imgs/logo_unespar.png" class="d-inline-block align-top" alt="" loading="lazy" width="64" height="68">UNESPAR</h2>
        
        <hr>
        <h4>Programas</h4>
        <?php echo $txt; ?>


        

    </div>

    <div class="col">

      <form method="post" enctype="multipart/form-data"  action="./valida.php">

        <h2>Cadastrar</h2>
        <!-- ?php echo $alertaLogin; ? -->

        <div class="form-group">
          <label>CPF<sub>[Digite apenas os números]</sub></label>
          <input type="text" class="form-control" name="cpf" id="cpf" maxlength="11" value="" onfocusout="valCPF()" required>
        </div>

        
        <div class="form-group">
          
            
          <button type="submit"  class="btn btn-primary">🔑 Entrar</button>
          <div>&nbsp;</div>
          <div class="alert alert-info col"></div>

        </div> 
      
      </form>


    </div>

  </div>

</div>

<script>

function valCPF(){
  var cpf = document.getElementById('cpf').value;
  console.log(cpf);
  cpf = cpf.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
  cpf = cpf.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
  //de novo (para o segundo bloco de números)
  cpf = cpf.replace( /(\d{3})(\d{1,2})$/ , "$1-$2"); //Coloca um hífen entre o terceiro e o quarto dígitos
  document.getElementById('cpf').value = cpf;
}

</script>