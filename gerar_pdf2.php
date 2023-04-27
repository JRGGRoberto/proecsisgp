<?php

// Carregar o Composer
require './vendor/autoload.php';


// Referenciar o namespace Dompdf
use Dompdf\Dompdf;


     //define o estilo da página pdf
     $style='<html><head>
        <style type="text/css">
       @page {
            margin: 120px 50px 80px 50px;
        }
        #head{
            background-image: url("fad.jpg");
            background-repeat: no-repeat;
            font-size: 25px;
            text-align: center;
            height: 110px;
            width: 100%;
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            margin: auto;
        }
        #corpo{
            width: 600px;
            position: relative;
            margin: auto;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            position: relative;
        }
        td{
            padding: 3px;
        }
        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            border-top: 1px solid gray;
        }
        #footer .page:after{ 
            content: counter(page); 
        }
        </style></head><body>';

    //define o cabeçalho da página
    $head='<div id="head">Lista de Compras</div>
           <div id="corpo">';

    //inclui a biblioteca do dompdf
    require_once("dompdf/dompdf_config.inc.php");

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

    for ($i = 0; $i < 130; $i++) {
        $tmp='<tr>
            <td width="15%">'.$quant.'</td>
            <td width="15%">'.$tipo.'</td>
            <td width="40%">'.$produto.'</td>
            <td width="30%"> '.$obs.'</td>';   
        $body = $body.$tmp;
    }


    //define o rodapé da página
    $footer='</tbody>
        </table>
        </div>dompdf
        <div id="footer">
            <p class="page">Página </p>
        </div></body></html>  ';

    //concatenando as variáveis
    $html=$head.$style.$body.$footer;

    //gerando o pdf
    $html = utf8_decode($html);
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("compras.pdf");
