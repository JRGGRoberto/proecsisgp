<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Colegiado;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\RelParcial;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$t = $_GET['t'];
$id = $_GET['i'];

if ($t != 1) {
    header('location: index.php?status=error');
    exit;
}

$obProjeto = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = (object) Professor::getProfessor($obProjeto->id_prof);

if ($obProjeto->id_prof != $user['id']) {
    header('location: ../index.php?status=errorOwner');
    exit;
}

$cursosetor = '';
if ($obProjeto->para_avaliar == -1) {
    $cursosetor = $user['ca_nome'];
} else {
    $cursosetor = Colegiado::getRegistro($obProjeto->para_avaliar)->nome;
}

$relatorio = new RelParcial();
// VALIDAÇÃO DO POST
if (isset($_POST['atvd_per'])) {
    $relatorio->idproj = $obProjeto->id;
    $relatorio->periodo_ini = $_POST['periodo_ini'];
    $relatorio->periodo_fim = $_POST['periodo_fim'];
    $relatorio->atvd_per = $_POST['atvd_per'];
    $relatorio->alteracoes = $_POST['alteracoes'];
    $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    $relatorio->user = $user['id'];
    $relatorio->tramitar = $_POST['tramitar'];

    $vtq = $_POST['visita_tec_qtd'];
    $relatorio->visita_tec_qtd = $vtq = ($vtq) ?: 0;

    $idprjP = $relatorio->cadastrar();

    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = 'relatorios';
        $dados->id_tab = $idprjP;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }
    header('location: index.php?id='.$obProjeto->id);
    exit;
}
$anex = '';
$editar = '';
$msgSolicitacoAlteracao = '';

include '../includes/header.php';

include __DIR__.'/includes/formParcial.php';

include '../includes/footer.php';
