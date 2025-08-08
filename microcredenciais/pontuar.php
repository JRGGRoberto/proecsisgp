<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();
use App\Entity\MicroCred_pontu;
use App\Entity\MicroCred_proj;

$proj_id = $_GET['p'];
$aval_id = $_GET['a'];

$proj = MicroCred_proj::get($proj_id);

/*
echo '$proj_id: '.$proj_id.'<br>';
echo '$aval_id: '.$aval_id.'<br>';

echo '<pre>';
print_r($proj);
echo '</pre>';
*/
$pontuacao = new MicroCred_pontu();
$pontuacao = (object) MicroCred_pontu::get($proj_id, $aval_id);

if (isset($_POST['qn1'])) {
    $pontuacao->qn1 = $_POST['qn1'];
    $pontuacao->qn2 = $_POST['qn2'];
    $pontuacao->qn3 = $_POST['qn3'];
    $pontuacao->qn4 = $_POST['qn4'];
    $pontuacao->qn5 = $_POST['qn5'];
    $pontuacao->qn6 = $_POST['qn6'];
    $pontuacao->qn7 = $_POST['qn7'];
    $pontuacao->chm = $_POST['chm'];
    $pontuacao->justificativa = $_POST['justificativa'];
    $pontuacao->doit = 1;
    $pontuacao->atualizar();
    header('location: index.php?status=success');
    exit;
}

include '../includes/header.php';
include __DIR__.'/includes/form.php';
include '../includes/footer.php';
