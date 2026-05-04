<?php

use App\Entity\Avaliacoes;
use App\Entity\Projeto;

// VALIDAÇÃO DO ID
if (!isset($_GET['i'], $_GET['p'], $_GET['v'])) {
    header('location: /avaliacoes/index.php?tpAva=p1&status=error');
    exit;
}

$id_ava = $_GET['i'];
$id_proj = $_GET['p'];
$ver_proj = $_GET['v'];

$avaliacao = Avaliacoes::getRegistroView($id_ava);

if ($avaliacao->id_user != $user['id']) {
    header('location: ../avaliacoes/index.php?tpAva=p1&status=error');
    exit;
}

if ($avaliacao->id_proj != $id_proj) {
    header('location: ../avaliacoes/index.php?tpAva=p1&status=error');
    exit;
}

if ($avaliacao->ver != $ver_proj) {
    header('location: /avaliacoes/index.php?tpAva=p1&status=error');
    exit;
}

$prj = Projeto::getProjetoView($avaliacao->id_proj, $avaliacao->ver);

$cima = '<hr>
Etapa '.$avaliacao->fase_seq.' de '.$avaliacao->etapas.'
<a href="../propostas/visualizar.php?id='.$avaliacao->id_proj.'&v='.$avaliacao->ver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2 float-right" > Visualizar</button></a>';

include './'.$avaliacao->form.'/dados.php';

include '../includes/header.php';
echo $cima;
include './'.$avaliacao->form.'/form.php';

include '../includes/footer.php';
