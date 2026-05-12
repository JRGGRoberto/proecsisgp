<?php

require '../vendor/autoload.php';

use App\Entity\Projeto;
use App\Entity\Relatorio;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$voltarUrl = $_SERVER['HTTP_REFERER'];

$id = $_GET['id'];
$objRelToDEL = new Relatorio();
$objRelToDEL = $objRelToDEL->getById($id);

if ($objRelToDEL->fase_atual > 0) {
    echo 'não pode excluir! ';
    header('location: index.php?id='.$objProj->id.'&status=error');
} else {
    $objProj = new Projeto();
    $objProj = $objProj->getProjetoLast($objRelToDEL->idproj);

    if ($objProj->id_prof == $user['id']) {
        $objRelToDEL->excluir();
        header('location: index.php?id='.$objProj->id.'&status=success');
    } else {
        header('location: index.php?id='.$objProj->id.'&status=error');
    }
}
