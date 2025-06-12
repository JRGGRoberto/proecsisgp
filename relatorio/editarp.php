<?php

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;
use App\Entity\Arquivo;
use App\Entity\RelParcial;
use App\Entity\Campi;
use App\Entity\Colegiado;


// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$id = $_GET['id'];


$relatorio = new RelParcial(); 
$relatorio = (object)RelParcial::get($id);


$editar = '';
$scriptDisble = '';

$obProjeto = (object)Projeto::getProjetoLast($relatorio->idproj);

$obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

if(($relatorio->tramitar == 1) or ($obProjeto->id_prof != $user['id'])){
    $editar = 'readonly';
    

    $scriptDisble = "<script>
                        $('#sumnot_atvd_per').summernote('disable');
                        $('#sumnot_alteracoes').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                        btnArquivo =  document.getElementById('arquivo');
                        btnArquivo.hidden = true;
                    </script>";
} 

$msgSolicitacoAlteracao = '';
if($relatorio->last_result == 'r'){
   
   include __DIR__.'/includes/msgAlteração.php';
}


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
if (isset($_POST['atvd_per'])) {
    $resultado ='';
    $relatorio->idproj = $obProjeto->id;
    $relatorio->periodo_ini = $_POST['periodo_ini'];
    $relatorio->periodo_fim = $_POST['periodo_fim'];
    $relatorio->atvd_per = $_POST['atvd_per'];
    $relatorio->alteracoes = $_POST['alteracoes'];
    $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    $relatorio->user = $user['id'];
    $relatorio->tramitar = $_POST['tramitar'];
    if ($_POST['tramitar']== 1) {
        $relatorio->last_result = 'n';
    } 
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


include '../includes/header.php';
include __DIR__.'/includes/formParcial.php';
echo $scriptDisble; 
include '../includes/footer.php'; 