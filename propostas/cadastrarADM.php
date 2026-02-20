<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Outros;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

if(!$user['adm'] == 1){
  header('location: ../');
  exit;
}

$anexoIV    = [1, 2];
$anexoIII   = [3, 4, 5];

$t = $_GET['t'];

$palav1 ='';
$palav2 ='';
$palav3 ='';

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
// $obProjeto->id_prof    = $user['id'];
// $obProjeto->nome_prof  = $user['nome'];
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



$telefone = '';
$email = '';

use \App\Entity\Professor;
use \App\Entity\Agente;


          

use \App\Entity\Palavras;
use \App\Entity\Equipe;


use  \App\Entity\Arquivo;

//VALIDAÇÃO DO POST
if(isset($_POST['titulo'])){
 // $obProjeto->ver          =  $_POST['ver'];
  $obProjeto->id_prof      =  $_POST['id_prof'];
  $obProjeto->nome_prof    =  $_POST['coordNome'];
  $obProjeto->tipo_exten   =  $t;
  $obProjeto->titulo       =  $_POST['titulo'];
  $obProjeto->tide         =  $_POST['tide'];
  $obProjeto->vigen_ini    =  $_POST['vigen_ini'];
  $obProjeto->vigen_fim    =  $_POST['vigen_fim'];

  
  $obProjeto->regras = "e341e624-0715-11ef-b2c8-0266ad9885af";

  $obProjeto->last_result = 'a';
  $obProjeto->edt = 0;
  $obProjeto->para_avaliar = 0;
  
  if (in_array($t, $anexoIII)) {
    if($_POST['ch_semanal'] == null){
      $obProjeto->ch_semanal   =  0;  
    } else{
      $obProjeto->ch_semanal   =  $_POST['ch_semanal'];
    }

    $obProjeto->referencia    = $_POST['referencia'];

    $obProjeto->cnpq_garea    = $_POST['cnpq_garea'];
    $obProjeto->cnpq_area     = $_POST['cnpq_area'];
    $obProjeto->cnpq_sarea    = $_POST['cnpq_sarea'];

    $obProjeto->area_extensao = $_POST['area_extensao'];
    $obProjeto->linh_ext      = $_POST['linh_ext'];
  }

  $obProjeto->contribuicao  = $_POST['contribuicao'];

  if (in_array($t, $anexoIV)) {
    if($_POST['ch_total'] == null ){
      $obProjeto->ch_total = 0;
    } else {
      $obProjeto->ch_total     =  $_POST['ch_total'];
    }
    
  }

  $obProjeto->resumo       =  $_POST['resumo'];
  // $obProjeto->descricao    =  $_POST['descricao'];
  $obProjeto->objetivos    =  $_POST['objetivos'];
  $obProjeto->public_alvo  =  $_POST['public_alvo'];
  $obProjeto->metodologia  =  $_POST['metodologia'];
  // $obProjeto->prodserv_espe   =  $_POST['prodserv_espe'];

  //$obProjeto->contrap_nofinac =  $_POST['contrap_nofinac'];
  $obProjeto->municipios_abr  =  $_POST['municipios_abr'];
  //$obProjeto->n_cert_prev     =  $_POST['n_cert_prev'];
  $obProjeto->data            =  $_POST['data'];
  //$obProjeto->outs_info       =  $_POST['outs_info'];
  $obProjeto->acec            =  $_POST['acec'];
  $obProjeto->vinculo         =  $_POST['vinculo'];

  if($obProjeto->vinculo == 'S'){
    $obProjeto->tituloprogvinc  =  $_POST['tituloprogvinc'];
  }
  

  $obProjeto->finac            =  $_POST['finac'];
  if($obProjeto->finac == 'S'){
    $obProjeto->finacorgao = $_POST['finacorgao'];
    $obProjeto->finacval   = $_POST['finacval'];
  }
  

  $obProjeto->justificativa    =  $_POST['justificativa'];
  $obProjeto->cronograma       =  $_POST['cronograma'];

  if (in_array($t, $anexoIII)) {
    $obProjeto->referencia       =  $_POST['referencia'];
  }

  /*
  $obProjeto->parceria       =  $_POST['parceria'];
  if($obProjeto->parceria == 'S'){
    $obProjeto->parcaatribuic  =  $_POST['parcaatribuic'];
    $obProjeto->parcanomes     =  $_POST['parcanomes'];
  }
*/ 

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
  

  $equipeJS =  $_POST['equipeJS'];
  $arrEq = json_decode($equipeJS , true);
  $index = 1;
  foreach($arrEq as $key => $memb) {
    $objMembro = new Equipe();
    $objMembro->incluir(
      $index,
      $idprjP,
      $memb['nome'],
      $memb['instituicao'],
      $memb['formacao'],
      $memb['funcao'],
      $memb['tel']
    );
    $index++;
  }

  $anexosJS = json_decode($_POST['anexosJS']);
  foreach ($anexosJS as &$anx) {
    $dados = Arquivo::getArquivo($anx);
    $dados->tabela = $_POST['tabela'];
    $dados->id_tab = $idprjP;
    $dados->user = $obProjeto->user;
    $dados->atualizar();
  }

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

$sqlListaUSUA = 
"
select 
  u.id as id,
  CONCAT(u.nome, ' [', u.tipo , '] | ', u.lota_nome, ' - ',u.ce_cod, ' - ',u.co_nome) as nome  
from 
  usuarios u
where u.ativo = 1
order by 2 
" ;
 $listaUsuarios = Outros::qry($sqlListaUSUA);
 $id_profLIsta ='<select name="id_prof" id="id_prof" class="form-control"  onchange="justName()" >';

foreach($listaUsuarios as  $e){
  $id_profLIsta .=  "<option value=".$e->id.">".$e->nome."</option>";
}

$id_profLIsta .=  "</select>

<script>
function justName() {
  var idProf    = document.getElementById('id_prof');
  var coordNome = document.getElementById('coordNome');
  var nomeC = idProf.options[idProf.selectedIndex].text;
  var nomeA = nomeC.split(' [');
  coordNome.value = nomeA[0];
  }
</script>

";


include '../includes/header.php';

if(in_array($t, $anexoIII)){
  include __DIR__.'/includes/formAnexoIIIADM.php';

  echo ('<script src="cnpq.js"></script>');

  echo ( '<script>

var ga = document.querySelector("#cnpq_garea");
var ar = document.querySelector("#cnpq_area");
var sa = document.querySelector("#cnpq_sarea");
pegarGA();
  
</script>');



} elseif (in_array($t, $anexoIV)){
  include __DIR__.'/includes/formAnexoIVADM.php';
} else {
  header('location: index.php?status=error');
  exit;
}

$id_regra = $user['tipo'] == 'agente' ? 'a45daba2-12ec-11ef-b2c8-0266ad9885af': '6204ba97-7f1a-499e-a17d-118d305bf7e4';

$sqlEtapas = 
"
select 
  rd.nome as nome,
  case tp_avaliador 
     when 'ca' then 'Chefe de Divisão'
     when 'ce' then 'Diretor(ª) de Centro de Área'
     when 'co' then 'Coordenador(ª) de colegiado'
     when 'pf' then 'Professor(ª)'
     else 'Agente' end as avaliador,
  rd.sequencia , form 
from regras_defin rd  
where 
 id_reg = '". $id_regra . "' order by sequencia  " ;
 $etapas = Outros::qry($sqlEtapas);


$etapsTabele ='';

foreach($etapas as  $e){
  $etapsTabele .= 
     "<tr>
        <td>". $e->avaliador ."</td>
        <td>". $e->nome ." </td>
      </tr>
  ";
}



echo  '
<!-- The Modal -->
<div class="modal fade" id="modelEtapasAvala">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ordem de tramitação</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        *O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão
        <table class="table table-bordered">
  <thead class="thead-light">
    <tr>
      <th>Quem avalia</th>
      <th>Formulário</th>
    </tr>
  </thead>
  <tbody>'.
  $etapsTabele 
  .'</tbody>
</table>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<script>
$("#modelEtapasAvala").modal("show");
</script>

';

include '../includes/footer.php';

