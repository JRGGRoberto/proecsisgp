<?php

use App\Session\Login;

$user = Login::getUsuarioLogado();

?>

<style>
    .alert {
        transition: transform 0.4s ease, opacity 0.4s ease;
    }
    .moving {
        z-index: 1;
    }
    /* Animação ao excluir */
    .fade-out {
           opacity: 0;
           transform: scale(0.95);
    }

    .fade-in {
           opacity: 1;
    }

</style>

<main>
  <h2 class="mt-0">Lista de candidatos </h2>
  <?php echo $btnsProgs ;?>
  <?php echo $btnSalvar ;?>
  <form method="post" name="formSalvaDados" id="formSalvaDados" >
      <input type="hidden" name="altDados" id="altDados">
  </form>
  <section>
Lista Ranqueada
    <div class="form-group" id="listaRanc">
      <!-- Lista será carregada dinamicamente -->
    </div>
Lista de desclassificados ou não ranqueados
    <div class="form-group" id="listaInscricoes">
      <!-- Lista será carregada dinamicamente -->
    </div>
    
  </section>

  <script src="candidatos.js"></script>

</main>








