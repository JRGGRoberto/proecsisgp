<?php

require '../../vendor/autoload.php';



use \App\Entity\RegrasDef;
$where = 'id_reg = "6204ba97-7f1a-499e-a17d-118d305bf7e4"';
$order = 'sequencia';
$rules = RegrasDef::getRegistros($where, $order);

foreach($rules as $r){
    echo $r->sequencia . ' | ' .$r->nome . ' | ' . $r->tp_avaliador . ' | ' . $r->form .'<br>';
}


include '../../includes/header.php';

?>


<br><br>

<div class="container">

  <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:33%"></div>
    <div class="progress-bar bg-warning" style="width:16%">Aguardando avaliação</div>
  </div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-justified" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Chefe de divisão</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Sel. parecerista</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
    <p>aaaa.</p>  
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
  </div>
</div>

</body>
</html>
