<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;
use App\Entity\RelParcial;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$id = $_GET['id'];
$relatorio = (object) RelParcial::get($id);

$editar = '';
$scriptDisble = '';
if($relatorio->tramitar == 1){
    $editar = 'readonly';

    $scriptDisble = "<script>
                        $('#sumnot_atvd_per').summernote('disable');
                        $('#sumnot_alteracoes').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                    </script>";
}

$obProjeto = Projeto::getProjetoLast($relatorio->idproj);
$obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

// VALIDAÇÃO DO POST
if (isset($_POST['atvd_per'])) {
    $relatorio->idproj = $obProjeto->id;
    $relatorio->periodo_ini = $_POST['periodo_ini'];
    $relatorio->periodo_fim = $_POST['periodo_fim'];
    $relatorio->atvd_per = $_POST['atvd_per'];
    $relatorio->alteracoes = $_POST['alteracoes'];
    $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    $relatorio->user = $user['id'];
    $relatorio->atualizar();

/*
    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = $_POST['tabela'];
        $dados->id_tab = $idprjP;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }
*/
    header('location: index.php?id='.$obProjeto->id);
    exit;
}
$anex = '';

include '../includes/header.php';
include __DIR__.'/includes/formParcial.php';
echo $scriptDisble;
include '../includes/footer.php';
