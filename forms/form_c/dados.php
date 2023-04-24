<?php

require '../vendor/autoload.php';

use \App\Entity\Avaliacoes;
use \App\Entity\Projeto;
use \App\Entity\Arquivo;
use \App\Entity\Form_c;

$form = Form_c::getRegistro($_GET['p'], $_GET['v']);

$anexados = Arquivo::getAnexados('forms', $id_ava);
$anex = '<ul id="anexos_edt">';
foreach($anexados as $att){
  $anex .= 
  '<li>
      <a href="/home/sistemaproec/www/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
      <a href="../arquiv/index.php?tab='.$att->tabela. '&id='.$att->id_tab. '&arq='.$att->nome_rand.'" >  
        <span class="badge badge-danger">🗑️ Excluir</span>
      </a>
  </li> ';
}
$anex .= '</ul>';

$cad = false;
if(!$form) {
  $form = new Form_c();
  $cad = true;
}

define('TITLE','FORM C');

//VALIDAÇÃO DO POST
if(isset($_POST['resultado'])){

  $ava1 = Avaliacoes::getRegistro($_GET['i']);
  
  if(($ava1->id_proj == $id_proj) and ($ava1->ver == $ver_proj)) {
    $form->id_proj = $id_proj;
    $form->ver_proj = $ver_proj;
    $form->id_avaliacao = $id_ava;
    $form->id_avaliador = $_POST['a'];
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

    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
      $dados = Arquivo::getArquivo($anx);
      $dados->tabela = 'forms';
      $dados->id_tab = $ava1->id;
      $dados->user = $obProjeto->user;
      $dados->atualizar();
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
