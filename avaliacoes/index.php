<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

if (!isset($_GET['tpAva'])) {
    $tpAvaliacao = 'p1';
} else {
    $tpAvaliacao = $_GET['tpAva'];
}

/*
echo '<pre>';
print_r($_SERVER['QUERY_STRING']);
echo '</pre>';
*/

$tituloB = filter_input(INPUT_GET, 'tituloB', FILTER_SANITIZE_STRING);
$nome_profB = filter_input(INPUT_GET, 'nome_profB', FILTER_SANITIZE_STRING);
$protocoloB = filter_input(INPUT_GET, 'protocoloB', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($tituloB) ? 'titulo LIKE "%'.str_replace(' ', '%', $tituloB).'%"' : null,
    strlen($nome_profB) ? 'nome_prof LIKE "%'.str_replace(' ', '%', $nome_profB).'%"' : null,
    strlen($protocoloB) ? 'protocolo = "'.$protocoloB.'"' : null,
];

include '../includes/header.php';
include __DIR__.'/includes/listageSelect.php';
include '../includes/footer.php';
