<?php
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use \App\Session\Login;
use \App\Entity\Projeto;
Login::requireLogin();
$user = Login::getUsuarioLogado();
use \App\Entity\Avaliacoes;


//VALIDAÇÃO DO ID
if(!isset($_GET['i'], $_GET['p'], $_GET['v'])){
  header('location: ../avalareal/index.php?status=error');
  exit;
}

$id_ava  = $_GET['i'];
$id_proj = $_GET['p'];
$ver_proj = $_GET['v'];

$avaliacao = Avaliacoes::getRegistroView($id_ava);

if ($avaliacao->id_user != $user['id']){
  header('location: ../avalareal/index.php?status=error');
  exit;
}

if ($avaliacao->id_proj != $id_proj){
    header('location: ../avalareal/index.php?status=error');
    exit;
}


if ($avaliacao->ver != $ver_proj){
    header('location: ../avalareal/index.php?status=error');
    exit;
}

$prj = Projeto::getProjetoView($avaliacao->id_proj, $avaliacao->ver);

$cima = '<hr>
Etapa '. $avaliacao->fase_seq. ' de '. $avaliacao->etapas. '
<a href="../projetos/visualizar.php?id='. $avaliacao->id_proj . '&v='. $avaliacao->ver . '&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2 float-right" > 👀 Visualizar</button></a>';

include './'. $avaliacao->form .'/dados.php';

include '../includes/header.php';
echo $cima; 
include './'. $avaliacao->form .'/form.php';

include '../includes/footer.php';
