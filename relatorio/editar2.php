<?php

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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




$id = $_GET['id'];
$relatorio = (object) RelFinal::get($id);
$tf = $relatorio->tipo;


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


$anexados = Arquivo::getAnexados('relatorios', $relatorio->id);




$anex = '<ul id="anexos_edt">';
foreach ($anexados as $att) {
    $anex .=
    '<li>
      <a href="/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
      <a href="../arquiv/index.php?tab='.$att->tabela.'&id='.$att->id_tab.'&arq='.$att->nome_rand.'" >  
        <span class="badge badge-danger">🗑️ Excluir</span>
      </a>
  </li> ';
}
$anex .= '</ul>';

$cursosetor ='';

if (Colegiado::getRegistro($obProjeto->para_avaliar) instanceof Colegiado) {
    $cursosetor = Colegiado::getRegistro($obProjeto->para_avaliar)->nome;
} elseif (Campi::getRegistro($obProjeto->para_avaliar) instanceof Campi) {
    $cursosetor = Campi::getRegistro($obProjeto->para_avaliar)->nome;
} else {
    $cursosetor = $user['ca_nome'];
}


// Quando a ação for para remover anexo
if (isset($_POST['acao']) == 'removeAnexo') {
    // Recuperando nome do arquivo
    $arquivo = $_POST['arquivo'];
    // Caminho dos uploads
    $caminho = '../upload/uploads/';
    // Verificando se o arquivo realmente existe
    if (file_exists($caminho.$arquivo) and !empty($arquivo)) {
        // Removendo arquivo
        unlink($caminho.$arquivo);
    }
    // Finaliza a requisição 
    exit;
}

// VALIDAÇÃO DO POST
if (isset($_POST['periodo_ini'])) {
    $relatorio->id = $obProjeto->id;
    $relatorio->periodo_ini = $_POST['periodo_ini'];
    $relatorio->periodo_fim = $_POST['periodo_fim'];
    $relatorio->periodo_renov_ini =     $_POST['periodo_renov_ini'];
    $relatorio->periodo_renov_fim =     $_POST['periodo_renov_fim'];
    $relatorio->periodo_prorroga_ini =  $_POST['periodo_prorroga_ini'];
    $relatorio->periodo_prorroga_fim =  $_POST['periodo_prorroga_fim'];
    $relatorio->ch_semanal = $_POST['ch_semanal'];
    $relatorio->dim_mem_com_ex = $_POST['dim_mem_com_ex'];
    $relatorio->dim_disc = $_POST['dim_disc'];
    $relatorio->dim_doce = $_POST['dim_doce'];
    $relatorio->dim_agent_estag = $_POST['dim_agent_estag'];
    $relatorio->atividades = $_POST['atividades'];
    $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    $relatorio->rel_tec_cien_executado = $_POST['rel_tec_cien_executado'];
    $relatorio->divulgacao = $_POST['divulgacao'];
    $relatorio->tramitar = $_POST['tramitar'];
    $relatorio->atualizar();


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

$tituloHeader = '';
switch($tf) {
    case 'f':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA';
        break;
    case 'p':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de PRORROGAÇÃO DE PRAZO';
        break;
    case 'r':
        $tituloHeader = 'RELATÓRIO FINAL DE AÇÃO DE EXTENSÃO E CULTURA<BR>E solicitação de RENOVAÇÃO';
        break;
    default:
        $tituloHeader = 'não definido';
        break;
}


include '../includes/header.php'; 
include __DIR__.'/includes/formFinal.php';
echo $scriptDisble; 
include '../includes/footer.php'; 