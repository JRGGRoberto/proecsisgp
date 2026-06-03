<?php

require '../vendor/autoload.php';

use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();
$id = $_GET['id'];

if ($user['tipo'] == 'prof') {    // echo 'prof';
    $registro = Colegiado::getRegistro($id);
} elseif ($user['tipo'] == 'agente') {    // echo 'agente';
    $registro = Campi::getRegistro($id);
} else {
    return null;
    // error!!!!
}

echo json_encode($registro);
