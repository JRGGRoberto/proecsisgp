<?php
require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Projeto;

use \App\Entity\Equipe;

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
$obProjeto = Projeto::getProjeto($id, $ver);


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


use \App\Entity\Professor;
$dadosProf = Professor::getDadosProf($obProjeto->id_prof);

// $x = Login::getUsuarioLogado();

/*

use \App\Entity\Colegiado;
$coolSe = Colegiado::getRegistrosSelect($obProjeto->id, $x['co_id']);
$coolSelectSend = '';
foreach($coolSe as $co){
  $coolSelectSend .= '<option value="'.$co->id.'" '.$co->sel.'>'.$co->nome.'</option>';
}

*/
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


/*CONSULTA AO PROFESSOR
$obProfessor = Professor::getProfessor($obProjeto->id_prof);
echo '<pre>';
print_r($obProjeto);
echo '<hr>';
print_r($obProfessor);
echo '</pre>';
*/

$t = $obProjeto->tipo_exten;
$anexoIII  = [1, 2];
$anexoII   = [3, 4, 5];

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


//VALIDAÇÃO DO POST
if(isset( $_POST['titulo']) ) {

  // $obProjeto->id           =  $_POST['id'];
  // $obProjeto->id_prof      =  $obProfessor['id'];
  $obProjeto->tipo_exten   =  $t;
  $obProjeto->titulo       =  $_POST['titulo'];
  $obProjeto->tide         =  $_POST['tide'];
  $obProjeto->vigen_ini    =  $_POST['vigen_ini'];
  $obProjeto->vigen_fim    =  $_POST['vigen_fim'];
  $obProjeto->ch_semanal   =  $_POST['ch_semanal'];
  $obProjeto->ch_total     =  $_POST['ch_total'];
  // $obProjeto->situacao     =  $_POST['situacao'];
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

  $obProjeto->finac           =  $_POST['finac'];
  $obProjeto->finacorgao      =  $_POST['finacorgao'];
  $obProjeto->finacval        =  $_POST['finacval'];


  $obProjeto->justificativa    =  $_POST['justificativa'];
  $obProjeto->cronograma       =  $_POST['cronograma'];
  $obProjeto->referencia       =  $_POST['referencia'];


  //$obProjeto->para_avaliar    =  $_POST['para_avaliar'];
  $obProjeto->updated_at = date("Y-m-d H:i:s");
  $obProjeto->user = $user['id'];
  $obProjeto->last_result = 'n';

  $obProjeto->atualizar();
  /*  $arqs = $_POST['anexos'];

  foreach($arqs as $arq){
    $dados = Arquivo::getArquivo($arq);
    $dados->tabela = $_POST['tabela'];
    $dados->id_tab = $obProjeto->id; 
    $dados->user = $obProjeto->user;
    $dados->atualizar();
  }
  */
  header('location: ./index.php?status=success');
  exit;
}

$equipe = Equipe::getMembProj($obProjeto->id);

$scriptVars  = 
'<script>
    let equipe = '. json_encode($equipe, JSON_NUMERIC_CHECK) . '
</script>';
// echo json_encode($equipe);


include '../includes/header.php';

// verifica se o usuário é dono do projeto
if ($user['id'] == $obProjeto->id_prof){
  if( $obProjeto->edt == 0){
    echo '<div class="container">
    <hr>
    <div class="container p-3 my-3 bg-danger text-white rounded p-5">
        <h1><span class="badge badge-light"> 🚧 </span> Atenção! </h1>
  
        
        <hr>
        <p><span class="badge badge-light"> 🚨 </span> Edição não permitida.</p>

      </div>
    </div>';
  
  } else {
   
    if(in_array($t, $anexoII)){
      include __DIR__.'/includes/formAnexoII.php';
    } elseif (in_array($t, $anexoIII)){
      include __DIR__.'/includes/formAnexoIII.php';
    } else {
      header('location: index.php?status=error');
      exit;
    }
  }
} else {

  echo '<div class="container">
          <hr>
          <div class="container p-3 my-3 bg-danger text-white rounded p-5">
            <h1><span class="badge badge-light"> 🚧 </span> Atenção! </h1>
            <hr>
            <p><span class="badge badge-light"> 🚨 </span> Operação não permitida.</p>
          </div>
        ';

  echo 'Evento log:  <br>';
  echo 'User ID: '. $user['id'] .'<br>';
  echo 'URI: '. $_SERVER["REQUEST_URI"].'<br>';
  date_default_timezone_set("America/Sao_Paulo");
  echo 'Data time: '.date("d-m-Y h:i:sa").'<br>';
  echo '</div>';
}

include '../includes/footer.php';

