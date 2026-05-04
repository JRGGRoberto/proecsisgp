<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

/*
<a href="../projetos/index.php" class="btn btn-primary btn-sm float-right">Meus projetos/propostas</a>
header('location: ../projetos/index.php');
  exit;
*/

$btnDashboard = '';
if ($user['config'] == 3 or $user['adm'] == 1) {
    $btnDashboard = '<p><a href="../dashboard" class="btn btn-primary btn-sm">Dashboard [TESTES]</a></p>';
}

include '../includes/header.php';

include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
