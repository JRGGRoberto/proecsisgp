<?php

require '../vendor/autoload.php';

use \App\Session\Login;
Login::requireLogin();

$user = Login::getUsuarioLogado();


header('location: ../projetos/index.php');
  exit;

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 