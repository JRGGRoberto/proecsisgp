<?php

require '../vendor/autoload.php';



use \App\Entity\Avaliacoes;
use \App\Entity\Projeto;

use \App\Entity\Form_a;
$form = Form_a::getRegistro($_GET['p'], $_GET['v']);


$cad = false;
if(!$form) {
  $form = new Form_a();
  $cad = true;
}

//VALIDAÇÃO DO POST
if(isset($_POST['resultado'])){

  $ava1 = Avaliacoes::getRegistro($_GET['i']);

  if(($ava1->id_proj == $id_proj) and ($ava1->ver == $ver_proj)) {
    $form->id_proj = $id_proj;
    $form->ver_proj = $ver_proj;
    $form->id_avaliacao = $id_ava;
    $form->id_avaliador = $_POST['a'];
    $form->r3_1 = $_POST['r3_1']; 
    $form->r3_2 = $_POST['r3_2'];
    $form->r3_3 = $_POST['r3_3'];
    $form->r3_4 = $_POST['r3_4'];
    $form->r3_5 = $_POST['r3_5'];
    $form->r3_6 = $_POST['r3_6'];
    $form->r3_7 = $_POST['r3_7'];
    $form->r4_1 = $_POST['r4_1'];
    $form->r4_2 = $_POST['r4_2'];
    $form->r4_3 = $_POST['r4_3'];
    $form->r4_4 = $_POST['r4_4'];
    $form->r4_5 = $_POST['r4_5'];
    $form->solicitacoes = $_POST['solicitacoes'];
    $form->parecer = $_POST['parecer'];
    $form->cidade  = $_POST['cidade'];
    $form->whosigns = $_POST['whosigns'];
    $form->dateAssing = $_POST['dateAssing'];
    $form->resultado  = $_POST['resultado'];
    //$form->$user  = $_POST['a'];

    if($cad){
      $form->cadastrar();
    } else {
      $form->atualizar();
    }
    
    switch($form->resultado) {
      case 'a':
        $ava1->resultado = 'a';
        $ava1->atualizar();
        $proj = Projeto::getProjeto($id_proj, $ver_proj);
        $proj->nextLevel(); 

        break;
      case 'r':
        $ava1->resultado = 'r';
        $ava1->atualizar();
        $proj = Projeto::getProjeto($id_proj, $ver_proj);
        $proj->novaVersao();
        break;
      case 'e':
        echo "Salvo para futuro converencia";
        break;
    }

    header('location: ../avalareal/index.php?status=success');
    exit; 
  }
}
