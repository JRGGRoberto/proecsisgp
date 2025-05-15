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
                        btnArquivo =  document.getElementById('arquivo');
                        btnArquivo.hidden = true;
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
if (isset($_POST['to_do'])) {
    
    $relatorio->ava_comentario = $_POST['ava_comentario'];
    $relatorio->ava_id = $user['id'];

    if($_POST['to_do'] == 1){
        echo 'publicado';
        $relatorio->publicar();
    } elseif ($_POST['to_do'] == -1){
        echo 'revisão';
        $relatorio->solicitarAlteracoes();
    } 


    header('location: index.php');
    exit;
}


include '../includes/header.php'; 
include __DIR__.'/includes/formParcial.php';
echo $scriptDisble; 
include '../includes/footer.php'; 


