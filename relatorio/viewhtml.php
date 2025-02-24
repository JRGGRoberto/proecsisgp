<?php

require '../vendor/autoload.php';


use App\Entity\Outros;


// VALIDAÇÃO DO ID
if (!isset($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}
$id = $_GET['id'];
$rel = Outros::q('
select 
    pr.titulo, pr.nome_prof, pr.colegiado,
    pr.campus,
    pr.tipo_exten, rp.periodo_ini, rp.periodo_fim , rp.atvd_per ,
    rp.alteracoes,
    rp.atvd_prox_per 
from 
    rel_parcial rp inner join proj_inf_lv pr  on rp.id_proj  = pr.id 
where rp.id = "'.$id.'" ');


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

 hr {
  page-break-after: always;
  border: 0;
 }

.centralizado {
  text-align: center;
}


.td1 {
  border: 0;
  border-collapse: collapse;
  text-align: center;
}

table, th, td {
  border: 0.5px solid gray;
  border-collapse: collapse;
  padding: 5px;
}
.time {
  width: 100%;
}

.table-bordered {
  width: 100%;
}

.th_cinza {
  background-color: #eeeeee;
  font-weight: lighter;
}

peq {
  font-family: "arial";
  font-size:5px;
}

c {
  text-align: center;
  font-family: "arial";
  font-size:5px;
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
 * Fim cabeçalho.
 */

$count = 0;

$html .= '<h4 class="centralizado">ANEXO IV</h4>';
$html .= '<h5 class="centralizado">RELATÓRIO PARCIAL </h5>';

$html .= '<p><strong>'.++$count.'. Título da proposta:</strong> '.$rel->titulo.'</p>';
$html .= '<p><strong>'.++$count.'. Coordenador(a):</strong> '.$rel->nome_prof.'</p>';

$html .= '<p><strong>'.++$count.'. Colegiado de Curso*/ Setor:</strong> '.$rel->colegiado.'</p>';
$html .= '<p><strong>'.++$count.'. Campus:</strong> '.$rel->campus.'</p>';
$html .= '<p><strong>'.++$count.'. Tipo de proposta:</strong> '.$rel->tipo_exten.'</p>';
$html .= '<p><strong>'.++$count.'. Período que se refere o Relatório</strong></br>';
$html .= '(   ) Inicial:'.$rel->periodo_ini. ' a '.$rel->periodo_fim. '.</p>';
$html .= '<p><strong>'.++$count.'. Atividades realizadas no período:</strong> <br>'.$rel->atvd_per.'</p>';
$html .= '<p><strong>'.++$count.'. Alterações realizadas no período da pesquisa e justificativa:</strong> <br>'.$rel->alteracoes.'</p>';
$html .= '<p><strong>'.++$count.'. Atividades para o próximo período:</strong> <br>'.$rel->atvd_prox_per.'</p>';

$html .= '<p><strong>Local, data:<br>
Assinatura do Coordenador:</strong> </p>';
/*

Local, data:
Assinatura do Coordenador:
*/
/*
   * $html .= '<p>'..'</p>';
   * Fim conteúdo
   */

$html .= '</body>
 </html>';

echo $html;
