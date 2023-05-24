<?php

//require '../vendor/autoload.php';
require '../../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
use Dompdf\Dompdf;

$dompdf = new Dompdf(['enable_remote' => true]);

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
  h4 {
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
</style>

</head>
<body>
  <div id="header">
    <table>
      <tr>
        <td class="td1"><img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png"
            width="120px"></td>
      </tr>
    </table>
  </div>
  <div id="footer">
    <div class="page-number"></div>
  </div>';



   $html .= 'hi';



/**
 * $html .= '<p>'..'</p>';
 * Fim conteúdo
 */

  $html .= '</body>
</html>';


$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("AE1.pdf");