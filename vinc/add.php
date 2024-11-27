<?php
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \App\Session\Login;
use \App\Entity\Professor;
use \App\Entity\Vinculo;
Login::requireLogin();
$user = Login::getUsuarioLogado();

/*
//VALIDAÇÃO DO ID
if(!isset($_GET['id']) ){
    header('location: index.php?status=error');
    exit;
}
    */


$id_prof = substr( $id =$_GET['id'],4,36);
$ano = substr( $id =$_GET['id'],0,4);

//CONSULTA AO PROJETO
$obProfessor = new Professor();
$obProfessor = $obProfessor::getProfessor($id_prof);



//VALIDAÇÃO DA TIPO
if(!$obProfessor instanceof Professor){
  header('location: ../index.php?status=error');
  exit;
}
if (!$user['adm'] == 1){
  header('location: ../index.php?status=error');
  exit;
}



define('TITLE','Adicionar vinculo de '. $ano);
$vinculo = new Vinculo();
$readonly = '';

if(isset($_POST['nome'])){

  $vinculo->id_prof         = $obProfessor->id;
  $vinculo->rt              = $_POST['rt'];
  $vinculo->dt_obtn_tit     = $_POST['dt_obtn_tit'];
  $vinculo->tempo_cc        = $_POST['tempo_cc'];
  $vinculo->tempo_esu       = $_POST['tempo_esu'];
  $vinculo->area_concurso   = $_POST['area_concurso'];
  $vinculo->ano = $ano;
  $vinculo->user            = $user['id'];
 
  $vinculo-> cadastrar();

  header('location: ../professor/index.php?status=success');
    
  exit;
}

include '../includes/header.php';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';
  