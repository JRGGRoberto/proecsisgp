<?php

use App\Entity\Avaliacoes;
use App\Entity\ProjMaster;
use App\Entity\Relatorio;

require '../includes/header.php';
require '../includes/funcoes/func_mudaAbreviacao.php';
require '../includes/funcoes/func_formatDateHour.php';
require '../includes/funcoes/func_proxAvaliador.php';

$id = $_GET['id'];

//flag pra definir se o projeto veio de eprotocolo
$eProtocolo = false;

$obProjeto = new ProjMaster();
$proj = $obProjeto->getRegistro($id);
$projTipo = mudaAbreviacaoTipoPropostas($proj->tipo_exten);
$dataAtual = date('d/m/Y');

//avaliação só ocorre se ele não tiver vindo do eprotocolo
if ($proj->aprov_auto == 0) {
    // echo 'Isso não veio do eprotocolo';
    $obAval = new Avaliacoes();
    $aval = $obAval->getRegistrosByProj("id_proj = '".$id."'");

    $dataSubmissao = $aval[0]->created_at ?? '';
    $dataFormatSubmit = formatarData($dataSubmissao);


    $lastAval = $obAval->getLastAvaliacao($id);
    $instancia = mudaAbreviacaoInstancias($lastAval->tp_instancia);
} else {
    $eProtocolo = true;
}

$avaliador = getProximoAvaliador($id);


$estado = mudaAbreviacaoEstadoProp($proj->estado);


$obRelatorios = new Relatorio();

$relatorio = $obRelatorios->getAll('idproj = "'.$id.'"');




// echo '<pre>';
// print_r($avaliador);
// echo '</pre>';

$dataFormatVigenIni = formatarData($proj->vigen_ini);
$dataFormatVigenFim = formatarData($proj->vigen_fim);

    
//só pega o tipo do relatório se existir um relatório referente ao projeto
if (!empty($relatorio)){
    // echo '<pre>';
    // print_r($relatorio);
    // echo '</pre>';
    $relTipo = mudaAbreviacaoTipoRel($relatorio[0]->tipo);
    // echo 'reltipo = '.$relTipo;
} 

$mensagemEstado = '';
if ($estado == 'em avaliação') {
    $mensagemEstado = '
        Fases de avaliação: <strong>'.$lastAval->fase_seq.'/'.$aval[0]->etapas.'</strong>
        <br>
        Instância responsável:
        <strong>'.$instancia.' - '.$avaliador->nome.'</strong>
        <br>
    ';
} elseif ($estado == 'não iniciado') {
    $mensagemEstado = '
        Proposta aprovada em todas as instâncias, aguardando início de vigência.
        <br>
    ';
} elseif ($estado == 'em execução' && $relatorio) {
    if ($relatorio[0]->publicado !== '1') {
        $mensagemEstado = '
            Existe um <strong>relatório '.$relTipo.'</strong> em avaliação.
            <br>
        ';
    } else {
        $mensagemEstado = '
        Relatório parcial já publicado.
        <br>
    ';
    }
} elseif ($estado == 'finalizado' && $relatorio) {
    if ($relatorio->publicado !== '1') {
        $mensagemEstado = '
            Existe um <strong>relatório '.$relTipo.'</strong> em avaliação.
            <br>
        ';
    } else {
        $mensagemEstado = '
            Existe um <strong>relatório '.$relTipo.'</strong> em avaliação.
            <br>
        ';
    }
} elseif ($estado == 'aguardando relatório final') {
    if ($eProtocolo == true) {
        $mensagemEstado = ''.$projTipo.' aprovado via <strong>e-Protocolo</strong>.
        <br>
        ';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaração</title>
</head>
<style>
@media print {

    .no-print {
        display: none !important;
    }
}
</style>


<body class="bg-light">
    <div class="container my-5">
        <div class="bg-white shadow rounded p-5 ">
            <div class="row mb-5">
                <div class="col text-center">
                    <h1 class="fw-bold display-6 text-uppercase">
                        Declaração
                    </h1> 
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p class="fs-5 lh-lg text-justify" style="text-indent: 50px;">
                        Declaramos, para os devidos fins, que a proposta intitulada
                        <strong>"<?php echo $proj->titulo; ?>"</strong>,
                        do tipo <strong><?php echo $projTipo; ?></strong>,
                        coordenado por <strong><?php echo $proj->coord; ?></strong>,
                        encontra-se no estado de 
                        <strong><?php echo $estado; ?></strong> no Sistema PROEC.
                    </p>

                    <p class="fs-5 lh-lg text-justify" >
                        <?php if($eProtocolo == false):?>
                            Informamos ainda que a proposta foi submetida para avaliação
                            em <strong><?php echo $dataFormatSubmit; ?></strong>.
                            <br>
                        <?endif ?>
                        
                        <?php echo $mensagemEstado; ?>

                        Protocolo:
                        <strong><?php echo $proj->protocolo; ?></strong>
                        <br>
                        Período de vigência:
                        <strong><?php echo $dataFormatVigenIni; ?></strong>
                        até 
                        <strong><?php echo $dataFormatVigenFim; ?></strong>
                    </p>
                </div>
            </div>

            <div class="row mt-5 pt-5">
                <div class="col text-center">
                    <p class="mb-0 fw-bold">
                        Sistema PROEC
                    </p>

                    <small class="text-muted">
                        Universidade Estadual do Paraná - UNESPAR
                    </small>
                    <p class="fs-5 lh-lg text-justify text-center" s>
                        <small>Documento emitido em
                        <?php echo $dataAtual; ?> por meio do Sistema PROEC/UNESPAR,</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>