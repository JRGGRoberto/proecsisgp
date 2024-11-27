<?php
require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Vinculo;
use \App\Entity\Professor;
Login::requireLogin();
$user = Login::getUsuarioLogado();


//VALIDAÇÃO DO ID
if(!isset($_GET['id']) ){
    header('location: index.php?status=error');
    exit;
}


//CONSULTA AO vinculo
$vinculo = new Vinculo();
$vinculo = $vinculo::get($_GET['id']);

$obProfessor = Professor::getProfessor($vinculo->id_prof);


//VALIDAÇÃO DA TIPO
if(!$vinculo instanceof Vinculo){
  header('location: ../index.php?status=error');
  exit;
}

if (!$user['adm'] == 1){
  header('location: ../index.php?status=error');
  exit;
}




define('TITLE','Editar dados do vinculo de '. $vinculo->ano);
$readonly = '';


if(isset($_POST['nome'])){

  $vinculo->rt              = $_POST['rt'];
  $vinculo->dt_obtn_tit     = $_POST['dt_obtn_tit'];
  $vinculo->tempo_cc        = $_POST['tempo_cc'];
  $vinculo->tempo_esu       = $_POST['tempo_esu'];
  $vinculo->area_concurso   = $_POST['area_concurso'];
  $vinculo->user            = $user['id'];
 
  $vinculo->atualizar();

  header('location: ../professor/index.php?status=success');
    
  exit;
}

include '../includes/header.php';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';
  