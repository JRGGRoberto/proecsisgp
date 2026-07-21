<?php

require '../vendor/autoload.php';

use App\Entity\Outros;
use App\Entity\Pibis_pibex_avaliadores;
use App\Session\Login;

// Obriga o usuário a estar logado

Login::requireLogin();
$user = Login::getUsuarioLogado();

$obAvaliador = Pibis_pibex_avaliadores::get($user['id'], 'adm = 1');
if (!$obAvaliador instanceof Pibis_pibex_avaliadores) {
    header('location: ../home/');
    exit;
}

$qry = 'SELECT * from pibixbex_acomp_v ';

$data = Outros::qry($qry);

include '../includes/header.php';
include __DIR__.'/includes/listagem22.php';
include '../includes/footer.php';
