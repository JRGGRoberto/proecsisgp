<?php

require '../vendor/autoload.php';

use \App\Session\Login;

// use \App\Entity\Professor;


//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

define('TITLE','Cadastrar projeto');

use \App\Entity\Projeto;
$obProjeto = new Projeto;
$obProjeto->id_prof      =  $user['id'];
$obProjeto->nome_prof    = $user['nome'];

// Quando a ação for para remover anexo
if (isset($_POST['acao']) == 'removeAnexo')
{
    // Recuperando nome do arquivo
    $arquivo = $_POST['arquivo'];
    // Caminho dos uploads
    $caminho = '../upload/uploads/';
    // Verificando se o arquivo realmente existe
    if (file_exists($caminho . $arquivo) and !empty($arquivo))
        // Removendo arquivo
        unlink($caminho . $arquivo);
    // Finaliza a requisição
    exit;
}


use \App\Entity\Area_Cnpq;
$areas_cnpq1 = Area_Cnpq::getRegistros();
$selectAreaCNPQ = '';
foreach($areas_cnpq1 as $ar_cnpq){
  $selectAreaCNPQ .= '<option value="'.$ar_cnpq->id.'" '.$ar_cnpq->sel.'>'.$ar_cnpq->nome.'</option>';
}

use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros();
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->id.'" '.$prop->sel.'>'.$prop->nome.'</option>';
}

use \App\Entity\Area_temat;
$area_tem1 = Area_temat::getRegistros();
$areaOptions = '';
foreach($area_tem1 as $area){
  $areaOptions .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}

use \App\Entity\Area_temat2;
$area_tem2 = Area_temat2::getRegistros();
$areaOptions2 = '';
foreach($area_tem2 as $area){
  $areaOptions2 .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}

use \App\Entity\Area_Extensao;
$area_ext = Area_Extensao::getRegistros();
$area_ext_Opt = '';
foreach($area_ext as $aext){
  $area_ext_Opt .= '<option value="'.$aext->id.'" '.$aext->sel.'>'.$aext->nome.'</option>';
}

/*
$qry = 'select ccc.co_id as id, ccc.colegiado as nome  from ca_ce_co ccc where ccc.ca_id  = "'. $user[ca_id] .'"';
use \App\Entity\Diversos;
$sendColegiado = Diversos::qry($qry);
$coolSelectSend = '';
foreach($sendColegiado as $co){
  $coolSelectSend .= '<option value="'.$co->id.'">'.$co->nome.'</option>';
}

*/


use  \App\Entity\Arquivo;

//VALIDAÇÃO DO POST
if(isset($_POST['titulo'])){
  $obProjeto->id_prof      =  $user['id'];
  $obProjeto->nome_prof    =  $user['nome'];
  $obProjeto->tipo_exten   =  $_POST['tipo_exten'];
  $obProjeto->titulo       =  $_POST['titulo'];
  $obProjeto->tide         =  $_POST['tide'];
  $obProjeto->vigen_ini    =  $_POST['vigen_ini'];
  $obProjeto->vigen_fim    =  $_POST['vigen_fim'];
  if($_POST['ch_semanal'] == null){
    $obProjeto->ch_semanal   =  0;  
  } else{
    $obProjeto->ch_semanal   =  $_POST['ch_semanal'];
  }
  
  if($_POST['ch_total'] == null ){
    $obProjeto->ch_total = 0;
  } else {
    $obProjeto->ch_total     =  $_POST['ch_total'];
  }
  
  // $obProjeto->situacao     =  $_POST['situacao'];

//  $obProjeto->regra    =  '6204ba97-7f1a-499e-a17d-118d305bf7e4';
  $obProjeto->ver    =  $_POST['ver'];
  $obProjeto->area_cnpq    =  $_POST['area_cnpq'];  
  $obProjeto->area_tema1   =  $_POST['area_tema1'];
  $obProjeto->area_tema2   =  $_POST['area_tema2'];
  $obProjeto->area_extensao = $_POST['area_extensao'];
  $obProjeto->linh_ext     =  $_POST['linh_ext'];
  $obProjeto->resumo       =  $_POST['resumo'];
  $obProjeto->descricao    =  $_POST['descricao'];
  $obProjeto->objetivos    =  $_POST['objetivos'];
  $obProjeto->public_alvo  =  $_POST['public_alvo'];
  $obProjeto->metodologia  =  $_POST['metodologia'];
  $obProjeto->prodserv_espe   =  $_POST['prodserv_espe'];
  $obProjeto->contribuicao    =  $_POST['contribuicao'];
  $obProjeto->contrap_nofinac =  $_POST['contrap_nofinac'];
  $obProjeto->municipios_abr  =  $_POST['municipios_abr'];
  $obProjeto->n_cert_prev     =  $_POST['n_cert_prev'];
  $obProjeto->data            =  $_POST['data'];
  $obProjeto->outs_info       =  $_POST['outs_info'];
  // sempre que cadastrar "para avaliar" ficará com o valor de -1.
  $obProjeto->para_avaliar    =  -1;
 // 'created_at' => $this->created_at,
 // 'updated_at' => date("Y-m-d H:i:s"),
  $obProjeto->user = $user['id'];

  $obProjeto->cadastrar();
 /* $arqs = $_POST['anexos'];

  foreach($arqs as $arq){
    $dados = Arquivo::getArquivo($arq);
    $dados->tabela = $_POST['tabela'];
    $dados->id_tab = $id_proj ;
    $dados->user = $user['id'];
    $dados->atualizar();
  } */

  //$municios->atualiza($id_proj, $_POST['id_munic']);

  header('location: index.php?status=success');
  exit;

  
}
$anex = '';

include '../includes/header.php';

include __DIR__.'/includes/formulario.php';

include '../includes/footer.php';


