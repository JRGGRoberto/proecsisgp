<?php

require '../vendor/autoload.php';


use \App\Session\Login;
use \App\Entity\Projeto;

//Obriga o usuário a estar logado
Login::requireLogin();

$user = Login::getUsuarioLogado();

//VALIDAÇÃO DO ID
if(!isset($_GET['id'], $_GET['v'])){
   echo "get id get v";
  header('location: index.php?status=error');
  exit;
}

//CONSULTA REGISTRO
$obProjeto = Projeto::getProjeto($_GET['id'], 0);


//VALIDAÇÃO DA Campus
if(!$obProjeto instanceof Projeto){
  echo 'Não é uma instancia do projeto';
  header('location: index.php?status=error');
  exit;
}

//VALIDANDO SE OS DADOS VIERAM REALMENTE PELO LINK
if($obProjeto->created_at != $_GET['v']){
  echo 'tentando trapassear....';
  header('location: index.php?status=error');
  exit;
}


//VALIDANDO SE O DONO DO PROJETO É  USUÁRIO
if($obProjeto->id_prof != $user['id']){
  echo 'tentando trapassear.... NÃO ÉS O DONO DO PROJETO!!!';
 // header('location: index.php?status=error');
  exit;
}


$obProjeto->excluir();
header('location: index.php?status=success');
exit;
