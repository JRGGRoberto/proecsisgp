<?php
  
  use \App\Entity\Colegiado;
  use \App\Session\Login;
  $user = Login::getUsuarioLogado();

  require('../includes/msgAlert.php');

  define('TITLE','Avaliações realizadas');

  $qnt1 = 0;
  $resultados = '';
  foreach($avaliados as $prof){
    $qnt1++;
    $resultados .=   $prof->id_av .' |  '. $prof->titulo .'   | '.$prof->resultado.'<br>';
  }
  
  
  $qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


  //GETS
  unset($_GET['status']);
  unset($_GET['pagina']);
  $gets = http_build_query($_GET);


?>
<main>
  <h2 class="mt-0">Avaliações realizadas</h2>
  
  <?=$msg?> 

  <section>

   <section>

    
    <?=$resultados?>
    
  </section>

  
</main>






