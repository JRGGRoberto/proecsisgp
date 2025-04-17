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
$tf = $_GET['f'];


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
if (isset($_POST['valida'])) {
   
/*
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    $k = 'periodo_renov_fim';
    if(key_exists($k,$_POST)){
      echo 'Exite '. $k;
    } else {
      echo 'não exite '. $k;
    }
    exit;
*/
    $relatorio->idproj = $obProjeto->id;

    if($tf == 'r'){
        $relatorio->periodo_renov_fim = $_POST['periodo_renov_fim'];
    }
    
    if($tf == 'p'){
      $relatorio->periodo_prorroga_fim = $_POST['periodo_prorroga_fim'];
      $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    }
      
    $relatorio->tipo = $tf;
    $relatorio->ch_semanal = $_POST['ch_semanal'];
    $relatorio->dim_mem_com_ex = $_POST['dim_mem_com_ex'];
    $relatorio->dim_disc = $_POST['dim_disc'];
    $relatorio->dim_doce = $_POST['dim_doce'];
    $relatorio->dim_agent_estag = $_POST['dim_agent_estag'];
    $relatorio->atividades = $_POST['atividades'];
    
    $relatorio->rel_tec_cien_executado = $_POST['rel_tec_cien_executado'];
    $relatorio->divulgacao = $_POST['divulgacao'];
    $relatorio->tramitar = $_POST['tramitar'];
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
