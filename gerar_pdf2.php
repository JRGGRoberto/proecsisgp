<?php

// Carregar o Composer
require './vendor/autoload.php';

  //define o estilo da página pdf
  $style=
"<!DOCTYPE html>
<html lang='pt-br'>
  <head>
  </head><body>
  
  <style>
  .pagenum:before {content: counter(page);}
  footer .pagenum:before {content: counter(page);}
  </style> 
  ";

    //define o cabeçalho da página
    $head="<div id='head'>Lista de Compras</div>
    <div id='corpo'>";

    //recebendo os dados do Formulário
    $quant      = 22;
    $tipo       = 'Unidade';
    $produto    = 'Garrafa PET';
    $obs        = 'Sem Obs';

    //define o corpo do documento
    $body='
        <table border="1px">
            <thead>
            <tr bgcolor="#ccc">
                <td>Quantidade</td>
                <td>Tipo</td>
                <td>Produto</td>
                <td>Obs.</td>
            </tr></thead><tbody>';


    $cont = '';
    for ($i = 0; $i < 130; $i++) {
        $tmp='<tr>
            <td width="15%">'.$i.'</td>
            <td width="15%">'.$tipo.'</td>
            <td width="40%">'.$produto.'</td>
            <td width="30%"> '.$obs.'</td>';   
        $cont .= $tmp;
    }


    //define o rodapé da página
    $footer='</tbody>
        </table>
        </div>
        <div id="footer">
            <p class="page">Página </p>
            <div class="pagenum-container">Página <span class="pagenum"></span></div> 
        </div></body></html>  ';

    //concatenando as variáveis
    $html=$style.$head.$body.$cont.$footer;

    //gerando o pdf
    
use Dompdf\Dompdf;
$dompdf = new Dompdf(['enable_remote' => true]);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream();