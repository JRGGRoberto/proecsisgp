<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

include './includes/pagAnalisaCadastro.php';

?>