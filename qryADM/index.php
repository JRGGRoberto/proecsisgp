<?php

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Entity\Outros;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = (object) Login::getUsuarioLogado();

if ($user->adm != 1) {
    header('location: ../index.php?status=error');
    exit;
}
$permssao = [
    '2bebba9e-226a-11ef-b2c8-0266ad9885af',
    'b8fa555f-cedb-47cf-91cc-7581736aac88',
    'bfd757a5-4f2d-4a10-87a8-a872ae69f1fd'];

if (!in_array($user->id, $permssao)) {
    header('location: ../index.php?status=error');
    exit;
}

if (isset($_POST['qry'])) {
    $resultado = $_POST['qry'];
    $reg = Outros::qry($resultado);
    $reg = Outros::qry($resultado);
    $resultado = json_encode($reg);
} else {
    $resultado = '';
    $questao = '';
}

include '../includes/header.php';

include './includes/listagem.php';

include '../includes/footer.php';
