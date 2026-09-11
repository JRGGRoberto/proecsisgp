<?php

use App\Entity\Arquivo;

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Entity\Form_Rel;
use App\Entity\Outros;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\Relatorio;
use App\Session\Login;

Login::requireLogin();

$user = Login::getUsuarioLogado();
$idAvaliacao = $_GET['id'] ?? null;

$formRel = new Form_Rel();
$formRel = $formRel->getRegistro($idAvaliacao);

$editar = '';

$avaliacaoRel = Outros::q("
    SELECT
        ar.id,
        ar.id_rel,
        ar.fase_seq,
        ar.resultado
    FROM avaliacoes_rel ar
    WHERE ar.id = '".$idAvaliacao."'
");

$relatorio = new Relatorio();
$relatorio = $relatorio->getById($avaliacaoRel->id_rel);

$obProjeto = Projeto::getProjetoLast($relatorio->idproj);
$obProjeto = Projeto::getProjeto(
    $obProjeto->id,
    $obProjeto->ver
);

$anexados = Arquivo::getAnexados('forms', $idAvaliacao);
$anex = '<ul id="anexos_edt">';
foreach ($anexados as $att) {
    $anex .=
    '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> ';
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
$cursosetor = '';

if (Colegiado::getRegistro($obProjeto->para_avaliar) instanceof Colegiado) {
    $cursosetor = Colegiado::getRegistro($obProjeto->para_avaliar)->nome;
} elseif (Campi::getRegistro($obProjeto->para_avaliar) instanceof Campi) {
    $cursosetor = Campi::getRegistro($obProjeto->para_avaliar)->nome;
} else {
    $cursosetor = $user['ca_nome'];
}
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

$tf = $relatorio->tipo;

$editar = 'readonly';

// var_dump($editar);
// die();
include '../includes/header.php';

include __DIR__.'/includes/avalListagem.php';

include '../includes/footer.php';
