<?php

require '../vendor/autoload.php';

use App\Entity\EmailService;
use App\Entity\Projeto;
use App\Entity\ProjMaster;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();

$user = Login::getUsuarioLogado();

// VALIDAÇÃO DO ID
if (!isset($_POST['modIDprj'], $_POST['modVerPrj'], $_POST['selecOpt'], $_POST['modCreated'])) {
    header('location: index.php?status=error');
    exit;
}

// //CONSULTA REGISTRO
$obProjeto = Projeto::getProjeto($_POST['modIDprj'], $_POST['modVerPrj']);
$obProjetoMaster = Projeto::getProjetoMaster($_POST['modIDprj'], $_POST['modVerPrj']);

$primeiroEnvio = $obProjeto->primeiraSubmit();
$solicAlteracao = $obProjeto->foiReprovado();

echo '<pre>';

// echo '<pre>';
// var_dump($resultado);
// echo '</pre>';

// //print_r
// var_dump([
//     'primeira_submissao' => $primeiroEnvio,
//     'veio_de_reprovacao' => $solicAlteracao,
//     'id_projeto' => $obProjeto->id,
//     'para_Aval' => $obProjeto->para_avaliar,
//     'ver' => $obProjeto->ver,
//     'last_result' => $obProjeto->last_result,
//     'protocolo' => $obProjeto->protocolo
// ]);

// echo '</pre>';
// exit;

$mail = new EmailService();

// VALIDAÇÃO DA Campus
if (!$obProjeto instanceof Projeto) {
    header('location: index.php?status=error');
    exit;
}

// VALIDANDO SE OS DADOS VIERAM REALMENTE PELO LINK
if ($obProjeto->created_at != $_POST['modCreated']) {
    echo 'tentando trapassear....';
    header('location: index.php?status=error');
    exit;
}

// VALIDANDO SE O DONO DO PROJETO É  USUÁRIO
if ($obProjeto->id_prof != $user['id']) {
    echo 'tentando trapassear.... NÃO ÉS O DONO DO PROJETO!!!';
    header('location: index.php?status=error');
    exit;
}

// $obProjeto->regra    =  '6204ba97-7f1a-499e-a17d-118d305bf7e4';
// print_r($_POST);

$resultado = $obProjeto->Submeter($_POST['selecOpt']);

$projMast = ProjMaster::getRegistro($obProjeto->id);

if ($resultado['primeira_submit']) {
    $mail->avaliacaoProposta($projMast, 'n');
}

if ($resultado['foi_reprovado']) {
    $mail->avaliacaoProposta($projMast, 'n');
}

header('location: index.php?status=success');

exit;
