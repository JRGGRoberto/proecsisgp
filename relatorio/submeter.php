<?php

require '../vendor/autoload.php';

use App\Entity\Projeto;
use App\Entity\Relatorio;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$voltarUrl = $_SERVER['HTTP_REFERER'];
echo $voltarUrl;

$id = $_POST['idRel'];

$objRelToSubmit = new Relatorio();
$objRelToSubmit->getId($id);

if ($objRelToSubmit->fase_atual < 0) {
    echo 'não pode submeter! ';
} else {
    $objProj = new Projeto();
    $objProj = $objProj->getProjetoLast($objRelToSubmit->idproj);

    if ($objProj->id_prof == $user['id']) {
        $objRelToSubmit->submeter();
        header('location: index.php?id='.$objProj->id.'&msg=Oksubmit');
    }
}
