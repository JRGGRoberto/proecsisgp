<?php
require '../vendor/autoload.php';
use \App\Session\Login;
use \App\Entity\Projeto;

Login::requireLogin();
$user = Login::getUsuarioLogado();



$mensagem = '';
if(isset($_GET['status'])){
  switch ($_GET['status']) {
    case 'success':
      $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
      break;

    case 'error':
      $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
      break;
  }
}


//VALIDAÇÃO DO ID
if(!isset($_GET['id'], $_GET['v'])){
  header('location: index.php?status=error');
  exit;
}
$id = $_GET['id'];
$ver = $_GET['v'];


//CONSULTA AO PROJETO
$obProjeto = new Projeto();
$where = '(id, ver) = ("' .$id.'", '.$ver.') ';
$obProjeto = Projeto::getRegistros($where);
$obProjeto = $obProjeto[0];

//VALIDAÇÃO DA TIPO
if(!$obProjeto instanceof Projeto){
  header('location: ../index.php?status=error');
  exit;
}

use \App\Entity\Area_Cnpq;
$areas_cnpq1 = Area_Cnpq::getRegistros($obProjeto->id);
$selectAreaCNPQ = '';
foreach($areas_cnpq1 as $ar_cnpq){
  $selectAreaCNPQ .= '<option value="'.$ar_cnpq->id.'" '.$ar_cnpq->sel.'>'.$ar_cnpq->nome.'</option>';
}


use \App\Entity\Area_temat;
$area_tem1 = Area_temat::getRegistros($obProjeto->id);
$areaOptions = '';
foreach($area_tem1 as $area){
  $areaOptions .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}

use \App\Entity\Area_temat2;
$area_tem2 = Area_temat2::getRegistros($obProjeto->id);
$areaOptions2 = '';
foreach($area_tem2 as $area){
  $areaOptions2 .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}

use \App\Entity\Area_Extensao;
$area_ext = Area_Extensao::getRegistros($obProjeto->id);
$area_ext_Opt = '';
foreach($area_ext as $aext){
  $area_ext_Opt .= '<option value="'.$aext->id.'" '.$aext->sel.'>'.$aext->nome.'</option>';
}

use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros($obProjeto->id);
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->id.'" '.$prop->sel.'>'.$prop->nome.'</option>';
}

use \App\Entity\Arquivo;
/*
use \App\Entity\Arquivo;
$anexados = Arquivo::getAnexados('projetos', $obProjeto->id);
$anex = '<ul id="anexos_edt">';
foreach($anexados as $att){
  $anex .= 
  '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
      <a href="../arquiv/index.php?tab='.$att->tabela. '&id='.$att->id_tab. '&arq='.$att->nome_rand.'" >  
        <span class="badge badge-danger">Excluir</span>
      </a>
  </li> ';
}
$anex .= '</ul>';
*/


define('TITLE','Editar informações do projeto');

include '../includes/header.php';
include __DIR__.'/includes/formreadonly.php';
include '../includes/footer.php';
