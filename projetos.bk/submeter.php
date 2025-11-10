<?php

require '../vendor/autoload.php';


use \App\Session\Login;
use \App\Entity\Projeto;

//Obriga o usuário a estar logado
Login::requireLogin();

$user = Login::getUsuarioLogado();



//VALIDAÇÃO DO ID
if(!isset($_POST['modIDprj'], $_POST['modVerPrj'], $_POST['selecOpt'], $_POST['modCreated'])){
   header('location: index.php?status=error');
  exit;
}

//CONSULTA REGISTRO
$obProjeto = Projeto::getProjeto($_POST['modIDprj'],  $_POST['modVerPrj']);


//VALIDAÇÃO DA Campus
if(!$obProjeto instanceof Projeto){
  header('location: index.php?status=error');
  exit;
}

//VALIDANDO SE OS DADOS VIERAM REALMENTE PELO LINK
if($obProjeto->created_at != $_POST['modCreated']){
  echo 'tentando trapassear....';
  header('location: index.php?status=error');
  exit;
}


//VALIDANDO SE O DONO DO PROJETO É  USUÁRIO
if($obProjeto->id_prof != $user['id']){
  echo 'tentando trapassear.... NÃO ÉS O DONO DO PROJETO!!!';
  header('location: index.php?status=error');
  exit;
}

// $obProjeto->regra    =  '6204ba97-7f1a-499e-a17d-118d305bf7e4';

$obProjeto->Submeter($_POST['selecOpt']);

header('location: index.php?status=success');

exit;






