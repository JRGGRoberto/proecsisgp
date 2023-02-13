<?php

include '../includes/header.php';

?>


<br><br>

<div class="container">

  <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:33%"></div>
    <div class="progress-bar bg-warning" style="width:16.666666666667%">Aguardando avaliação</div>
  </div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs nav-justified" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Chefe de divisão</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Sel. parecerista</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Parecer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#ata">Ata de Reunião</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" data-toggle="tab" href="#menu3">Centro de área</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" data-toggle="tab" href="#menu4">Chefe de divisão</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
        <?php include 'formA.php'; ?>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>

    <div id="ata" class="container tab-pane fade"><br>
      <h3>Ata 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>

    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Aguarde o parecer</h3>
      <p>Um professor do colegiado <colegiado> irá realizar um parecer para o seu projeto, favor aguarde.</p>
      <?php include 'formB.php'; ?>
    </div>
    <div id="menu3" class="container tab-pane fade"><br>
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu4" class="container tab-pane fade"><br>
    <?php include 'formA.php'; ?>
    </div>
  </div>
</div>

</body>
</html>
