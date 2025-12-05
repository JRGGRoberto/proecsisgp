<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Colegiado;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\RelFinal;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$t = $_GET['t'];
$id = $_GET['i'];
$tf = $_GET['f'];

if ($t != 2) {
    header('location: index.php?status=error');
    exit;
}

$obProjeto = Projeto::getProjetoLast($id);

$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

if ($obProjeto->id_prof != $user['id']) {
    header('location: ../index.php?status=errorOwner');
    exit;
}


$cursosetor = '';
if ($obProjeto->para_avaliar == -1) {
    $cursosetor = ''.$user['ca_nome'];
} else {
    $cursosetor = ''.Colegiado::getRegistro($obProjeto->para_avaliar)->nome;
}

$relatorio = new RelFinal();

// VALIDAÇÃO DO POST
if (isset($_POST['valida'])) {
    $relatorio->idproj = $obProjeto->id;
    $relatorio->tipo = $tf;

    // Esses ids de regra estão na base de dados na tabela regras, definidas em 2025.
    // Caso crie outras regras que substituam estas, atualizar aqui e manter os que estão no banco para histórico.
    $regras = array (
   	   'fi' => '7692259f-882e-11f0-b5b5-fed708dafd3c',
   	   're' => '8b71423b-cc7b-11f0-9444-3a9832f2c2cb',
   	   'pr' => '7692ea6e-882e-11f0-b5b5-fed708dafd3c'
    );
    $relatorio->regra = $regras[$tf];

    if ($tf == 're') {
        $relatorio->periodo_renov_ini = $_POST['periodo_renov_ini'];
        $relatorio->periodo_renov_fim = $_POST['periodo_renov_fim'];
    }

    if ($tf == 'pr') {
        $relatorio->periodo_prorroga_fim = $_POST['periodo_prorroga_fim'];
        $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    }

    $relatorio->ch_semanal = $_POST['ch_semanal'];
    $relatorio->dim_mem_com_ex = $_POST['dim_mem_com_ex'];
    $relatorio->dim_disc = $_POST['dim_disc'];
    $relatorio->dim_doce = $_POST['dim_doce'];
    $relatorio->dim_agent_estag = $_POST['dim_agent_estag'];
    $relatorio->atividades = $_POST['atividades'];

    $relatorio->rel_tec_cien_executado = $_POST['rel_tec_cien_executado'];
    $relatorio->divulgacao = $_POST['divulgacao'];
    $relatorio->tramitar = $_POST['tramitar'];
    $relatorio->visita_tec_qtd = $_POST['visita_tec_qtd'];

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
// $relatorio
$relatorio->visita_tec_qtd = 0;
$relatorio->ch_semanal = 0;
$relatorio->dim_mem_com_ex = 0;
$relatorio->dim_disc = 0;
$relatorio->dim_doce = 0;
$relatorio->dim_agent_estag = 0;

include '../includes/header.php';

include __DIR__.'/includes/formFinal.php';

include '../includes/footer.php';
