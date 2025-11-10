<?php

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Entity\Arquivo;
use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\RelFinal;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$id = $_GET['id'];
$relatorio = (object) RelFinal::get($id);
$tf = $relatorio->tipo;

$obProjeto = Projeto::getProjetoLast($relatorio->idproj);
$obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

$editar = '';
$scriptDisble = '';
if (($relatorio->tramitar == 1) or ($obProjeto->id_prof != $user['id'])) {
    $editar = 'readonly';

    $scriptDisble = "<script>
                        $('#sumnot_atividades').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                        $('#sumnot_rel_tec_cien_executado').summernote('disable');
                        $('#sumnot_divulgacao').summernote('disable');
                        btnArquivo =  document.getElementById('arquivo');
                        btnArquivo.hidden = true;
                        
                    </script>";
}

$anexados = Arquivo::getAnexados('relatorios', $relatorio->id);

$anex = '<ul id="anexos_edt">';
foreach ($anexados as $att) {
    $anex .=
    '<li>
      <a href="/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> ';
    if ($editar == '') {
        $anex .=
        '<a href="../arquiv/index.php?tab='.$att->tabela.'&id='.$att->id_tab.'&arq='.$att->nome_rand.'" >  
            <span class="badge badge-danger">🗑️ Excluir</span>
          </a>';
    }
    $anex .= '
  </li> ';
}
$anex .= '</ul>';

$msgSolicitacoAlteracao = '';
if ($relatorio->last_result == 'r') {
    include __DIR__.'/includes/msgAlteração.php';
}

$cursosetor = '';

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
if (isset($_POST['valida'])) {
    $relatorio->idproj = $obProjeto->id;
    $relatorio->tipo = $tf;

    if ($tf == 're') {
        $relatorio->periodo_renov_fim = $_POST['periodo_renov_fim'];
        $relatorio->periodo_renov_ini = $_POST['periodo_renov_ini'];
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
    if ($_POST['tramitar'] == 1) {
        $relatorio->last_result = 'n';
    }
    $relatorio->atualizar();

    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = 'relatorios';
        $dados->id_tab = $relatorio->id;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }

    header('location: index.php?id='.$obProjeto->id);
    exit;
}

include '../includes/header.php';
include __DIR__.'/includes/formFinal.php';
echo $scriptDisble;
include '../includes/footer.php';
