<?php
require '../vendor/autoload.php';




// use \App\Session\Login;
use \App\Entity\Projeto;
//Login::requireLogin();
//$user = Login::getUsuarioLogado();
use Dompdf\Dompdf;


$mensagem = '';
$jan = 'sem';

//VALIDAÇÃO DO ID
if(!isset($_GET['id'], $_GET['v'])){
  header('location: index.php?status=error');
  exit;
}
$id = $_GET['id'];
$ver = $_GET['v'];
$jan = $_GET['w'];

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

use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros($obProjeto->id);
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->id.'" '.$prop->sel.'>'.$prop->nome.'</option>';
}

use \App\Entity\Arquivo;
$anexados = Arquivo::getAnexados('projetos', $obProjeto->id);
$anex = '<ul id="anexos_edt">';
$conutAnexo = 0;
foreach($anexados as $att){
  $anex .= 
  '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a>    
  </li> ';
  $conutAnexo++;
}
if ($conutAnexo == 0) {
  $anex = 'Sem anexos';
} else {
  $anex .= '</ul>';
}

$t = $obProjeto->tipo_exten;

switch($t) {
  case 1: 
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE CURSO';
    break;
  case 2:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE EVENTO';
    break;
  case 3:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PRESTAÇÃO DE SERVIÇO';
    break;
  case 4:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMA';
    break;
  case 5:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROJETO';
    break;
  default:
    header('location: index.php?status=error');
    exit;
}

$anexoII = [3, 4, 5];
$anexoIII = [1, 2];
if (in_array($t, $anexoII)) { 
  $title = 'ANEXO II';
} else {
  $title = 'ANEXO III';
}


/*
if ($jan == 'nw') {
  include '../includes/headers.php';
} else {
  include '../includes/header.php';
}
include __DIR__.'/includes/formreadonly.php';
include '../includes/footer.php';
*/

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="pt-Br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-Br">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Doc</title>
  <style type="text/css">
  @page {
    margin: 1cm 2cm;
  }

  body {
    font-family: sans-serif;
    margin: 4.5cm 0 1.5cm 0;
    text-align: justify;
  }

  #header,
  #footer {
    position: fixed;
    left: 0;
    right: 0;

    font-size: 0.9em;
  }

  #header {
    top: 0;
    height: 100px;
  }

  #footer {
    bottom: 0;
    border-top: 0.1pt solid #aaa;
  }

  #header table,
  #footer table {
    width: 100%;
    border-collapse: collapse;
    border: 1px;
    border-color: black;
  }

  #header td,
  #footer td {
    padding: 0;
    width: 50%;
  }

  .page-number {
    text-align: center;
  }

  .page-number:before {
    content: "Página " counter(page);
  }

  .page-number::after {
    content: " de " counter(page);
  }

  hr {
    page-break-after: always;
    border: 0;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    text-align: center;
  }

  p {
    text-align: left;
  }

.td1 {
  border: 0;
  border-collapse: collapse;
  text-align: center;
}

.time, th, td {
  border: 0.5px solid gray;
  border-collapse: collapse;
  padding: 5px;
}
.time {
  width: 100%;
}
th {
  background-color: #eeeeee;
  font-weight: lighter;
}


c {
  text-align: center;
}
</style>

</head>
<body>
  <div id="header">
    <table>
      <tr>
        <td class="td1"><img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png" width="120px"></td>
      </tr>
    </table>
  </div>
  <div id="footer">
    <div class="page-number"></div>
  </div>';

/**
 * Fim cabeçalho
 */

   $html .= '<h4>'. $title .'</h4>';
   $html .= '<h5>'. $title2 .'</h5>';
   $html .= '<p class="c">*O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão Tramitação: Coordenador → Divisão de Extensão e Cultura → Colegiado de Curso → Conselho de Centro de Área → Divisão de Extensão e Cultura.</p>';


   $html .= 'Título da proposta: '. $obProjeto->titulo .'<br>';
   $html .= 'Coordenador: '. $obProjeto->nome_prof .'<br>';



/**
 * $html .= '<p>'..'</p>';
 * Fim conteúdo
 */

  $html .= '</body>
</html>';
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("PDF__.pdf");
