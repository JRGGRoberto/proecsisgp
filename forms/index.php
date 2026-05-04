<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

$tipoAvalicao = [
    'p' => 'idxProj.php',
    'r' => 'idxRelat.php',
];

if (!isset($_GET['tp'])) {
    header('location: ../index.php?status=error');
    exit;
}
$toWhere = $_GET['tp'];

include './'.$tipoAvalicao[$toWhere];
