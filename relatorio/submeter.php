<?php

require '../vendor/autoload.php';

use App\Entity\Projeto;
use App\Entity\Relatorio;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

echo '<pre>';
print_r($user);
echo '</pre>';

$voltarUrl = $_SERVER['HTTP_REFERER'];
echo $voltarUrl;

$id = $_POST['idRel'];

echo '<br>';

echo $id;

$objRelToSubmit = new Relatorio();
$objRelToSubmit = $objRelToSubmit->getById($id);

echo '<pre>';
print_r($objRelToSubmit);
echo '</pre>';

if ($objRelToSubmit->fase_atual < 0) {
    echo 'não pode submeter! ';
} else {
    $objProj = new Projeto();
    $objProj = $objProj->getProjetoLast($objRelToSubmit->idproj);

    echo '<pre>';
    print_r($objProj);
    echo '</pre>';

    if ($objProj->id_prof == $user['id']) {
        $objRelToSubmit->submeter();
        header('location: index.php?id='.$objProj->id.'&msg=Oksubmit');
    }
}
