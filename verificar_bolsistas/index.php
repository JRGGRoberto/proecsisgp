<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

include '../includes/header.php';
include 'includes/verificar.php';
include '../includes/footer.php'; 
