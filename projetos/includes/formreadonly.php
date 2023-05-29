<?php

// require '../vendor/autoload.php';
// require '../../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
use Dompdf\Dompdf;
use \App\Entity\Projeto;


$obProjeto = new Projeto();
$id = "0e1294e4-cf2b-4750-8b65-25330e729610";
$ver =  0;
$obProjeto = Projeto::getProjeto($id, $ver);
$t = $obProjeto->tipo_exten;

$title = '';
$title2 = '';
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



$anexoII = [3, 4, 5];
$anexoIII = [1, 2];
$t = $obProjeto->tipo_exten;


$dompdf = new Dompdf(['enable_remote' => true]);

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

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("PDF__.pdf");
