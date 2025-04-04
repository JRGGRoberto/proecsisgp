<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;
use App\Entity\Arquivo;
use App\Entity\RelFinal;
use App\Entity\Campi;
use App\Entity\Colegiado;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$t = $_GET['t'];
$id = $_GET['i'];

if ($t != 2) {
  header('location: index.php?status=error');
  exit;
}


$obProjeto = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

$cursosetor = '' ;
if($obProjeto->para_avaliar == -1){
  $cursosetor = $user['ca_nome'];
} else {
  $cursosetor = $obProjeto->para_avaliar;
}

$relatorio = new RelFinal();

// VALIDAÇÃO DO POST
if (isset($_POST['atvd_per'])) {
    $relatorio->id = $obProjeto->id;
    $relatorio->periodo_ini = $_POST['tabela'];
    $relatorio->periodo_fim = $_POST['tabela'];
    $relatorio->periodo_renov_ini = $_POST['tabela'];
    $relatorio->periodo_renov_fim = $_POST['tabela'];
    $relatorio->periodo_prorroga_ini = $_POST['tabela'];
    $relatorio->periodo_prorroga_fim = $_POST['tabela'];
    $relatorio->ch_semanal = $_POST['tabela'];
    $relatorio->dim_mem_com_ex = $_POST['tabela'];
    $relatorio->dim_disc = $_POST['tabela'];
    $relatorio->dim_doce = $_POST['tabela'];
    $relatorio->dim_agent_estag = $_POST['tabela'];
    $relatorio->atividades = $_POST['tabela'];
    $relatorio->atvd_prox_per = $_POST['tabela'];
    $relatorio->rel_tec_cien_executado = $_POST['tabela'];
    $relatorio->divulgacao = $_POST['tabela'];
    $relatorio->rel_finac = $_POST['tabela'];
    $relatorio->tramitar = $_POST['tabela'];
    $relatorio->cadastrar();


    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = $_POST['tabela'];
        $dados->id_tab = $idprjP;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }
    header('location: index.php?id='.$obProjeto->id);
    exit;
}
$anex = '';
$editar = '';

include '../includes/header.php';

include __DIR__.'/includes/formFinal.php';

include '../includes/footer.php';
