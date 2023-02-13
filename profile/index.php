<?php

require('../includes/msgAlert.php');

require '../vendor/autoload.php';
use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();


define('TITLE','Dados e usuário');

use \App\Entity\Pessoa;
use \App\Entity\Professor;
use \App\Entity\Campi;

/*
$obPessoa = new Pessoa;
$obProfessor = new Professor;
*/

/*
//VALIDAÇÃO DO ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
  header('location: index.php?status=error');
  exit;
}
*/
$x = Login::getUsuarioLogado();



//CONSULTA AO PROFESSOR
$obProfessor = Professor::getProfessor($x['id']);
$obPessoa = Pessoa::getPessoa($obProfessor->id_pessoa);
$campus = Campi::getRegistro($obProfessor->id_campus);







//VALIDAÇÃO DA TIPO
if(!$obPessoa instanceof Pessoa){
  header('location: index.php?status=error');
  exit;
}

//VALIDAÇÃO DO POST
if(isset($_POST['nome'])){
  
  $obPessoa->nome  = $_POST['nome'];
  $obPessoa->cpf   = $_POST['cpf'];
  $obPessoa->tel   = $_POST['tel'];
  $obPessoa->dt_nasc   = $_POST['dt_nasc'];
  $obPessoa->user   = $x['id'];
  $obPessoa->atualizar();

  $obProfessor->email  = $_POST['email'];
  $obProfessor->ativo   = 1 ; //$_POST['ativo'];
  // $obProfessor->cat_func  = $_POST['cat_func'];
  $obProfessor->user   = $x['id'];
  $obProfessor->atualizar();

  header('location: ../index.php?status=success');
  exit;
}

include '../includes/header.php';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';