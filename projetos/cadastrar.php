<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$anexoIII  = [1, 2];
$anexoII   = [3, 4, 5];

$t = $_GET['t'];


switch($t) {
  case 1: 
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE CURSO');
    break;
  case 2:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE EVENTO');
    break;
  case 3:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PRESTAÇÃO DE SERVIÇO');
    break;
  case 4:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMA');
    break;
  case 5:
    define('TITLE','FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROJETO');
    break;
  default:
    header('location: index.php?status=error');
    exit;
}

use \App\Entity\Projeto;

$obProjeto = new Projeto;
$obProjeto->id_prof    = $user['id'];
$obProjeto->nome_prof  = $user['nome'];
$obProjeto->tipo_exten = $t;

// Quando a ação for para remover anexo
if (isset($_POST['acao']) == 'removeAnexo'){
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

/*
use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros($obProjeto->id);
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->id.'" '.$prop->sel.'>'.$prop->nome.'</option>';
}
*/
use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistro($obProjeto->id);


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

use \App\Entity\Professor;
$dadosProf = Professor::getDadosProf($obProjeto->id_prof);

use \App\Entity\Palavras;
use \App\Entity\Equipe;


use  \App\Entity\Arquivo;

//VALIDAÇÃO DO POST
if(isset($_POST['titulo'])){
  $obProjeto->id_prof      =  $user['id'];
  $obProjeto->nome_prof    =  $user['nome'];
  $obProjeto->tipo_exten   =  $t;
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
  $obProjeto->ver          =  $_POST['ver'];
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

  $obProjeto->acec            =  $_POST['acec'];
  $obProjeto->vinculo         =  $_POST['vinculo'];
  $obProjeto->tituloprogvinc  =  $_POST['tituloprogvinc'];

  $obProjeto->finac            =  $_POST['finac'];
  $obProjeto->finacorgao       =  $_POST['finacorgao'];
  $obProjeto->finacval         =  $_POST['finacval'];

  $obProjeto->justificativa         =  $_POST['justificativa'];
  $obProjeto->cronograma       =  $_POST['cronograma'];
  $obProjeto->referencia       =  $_POST['referencia'];


  $obProjeto->parceria       =  $_POST['parceria'];
  $obProjeto->parcaatribuic  =  $_POST['parcaatribuic'];
  $obProjeto->parcanomes     =  $_POST['parcanomes'];

  $palav1 = $_POST['palav1'];
  $palav2 = $_POST['palav2'];
  $palav3 = $_POST['palav3'];

  
  // sempre que cadastrar "para avaliar" ficará com o valor de -1.
  $obProjeto->para_avaliar    =  -1;
 // 'created_at' => $this->created_at,
 // 'updated_at' => date("Y-m-d H:i:s"),
  $obProjeto->user = $user['id'];

  $idprjP =  $obProjeto->cadastrar();


  if(strlen($palav1) > 0 ){
    $ObjPalav1 = new Palavras();   
    $ObjPalav1->incluir($idprjP, $palav1);
  }
  if(strlen($palav2) > 0 ){
    $ObjPalav2 = new Palavras();
    $ObjPalav2->incluir($idprjP, $palav2);
  }
  if(strlen($palav3) > 0 ){
    $ObjPalav3 = new Palavras();
    $ObjPalav3->incluir($idprjP, $palav3);
  }


  Equipe::excluir($obProjeto->id);
  $equipeJS =  $_POST['equipeJS'];
  $arrEq = json_decode($equipeJS , true);
  $index = 1;
  foreach($arrEq as $key => $memb) {
    $objMembro = new Equipe();
    $objMembro->incluir(
      $index,
      $obProjeto->id,
      $memb['nome'],
      $memb['instituicao'],
      $memb['formacao'],
      $memb['funcao'],
      $memb['tel']
    );
    $index++;
  }



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

$scriptVars  = 
"<script>
  let equipe = []; 
  let dataAtual = new Date();
  document.getElementById('vigen_ini').valueAsDate = dataAtual;
  document.getElementById('dateAssing').valueAsDate = dataAtual;
  dataAtual.setFullYear(dataAtual.getFullYear() + 1);
  document.getElementById('vigen_fim').valueAsDate = dataAtual;
  
</script>";

include '../includes/header.php';

if(in_array($t, $anexoII)){
  include __DIR__.'/includes/formAnexoII.php';
} elseif (in_array($t, $anexoIII)){
  include __DIR__.'/includes/formAnexoIII.php';
} else {
  header('location: index.php?status=error');
  exit;
}



include '../includes/footer.php';

?>
<script>

  alert('*O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão \n Tramitação:\n ➡️ Coordenador (Preencher o formulário e depois submete-lo)\n ➡️ Divisão de Extensão e Cultura\n ➡️ Colegiado de Curso\n ➡️ Conselho de Centro de Área\n ➡️ Divisão de Extensão e Cultura.');

</script>


