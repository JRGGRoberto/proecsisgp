<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Form_Rel_Parecer;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\Relatorio;

$relatorio = new Relatorio();
$relatorio = Relatorio::getById($avaliacaoRelatorio->id_rel);
$obProjeto = Projeto::getProjetoLast($relatorio->idproj);
$obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
$obProfessor = new Professor();
$obProfessor = $obProfessor->getProfessor($obProjeto->id_prof);

// Tenta recuperar os dados do formulário, se não achar cria um novo.
$form = Form_Rel_Parecer::getRegistro($avaliacaoRelatorio->id);
$cad = false;
if (!$form) {
    $form = new Form_Rel_Parecer();
    $cad = true;
}

$prjS = Projeto::getRegistros("(id, ver)= ('".$_GET['p']."', ".$_GET['v'].')');
$prj = $prjS[0];

// Para mostar os anexos do Relatório
$anexados = Arquivo::getAnexados('relatorios', $relatorio->id);

$anex = '<ul id="anexos_edt">';
foreach ($anexados as $att) {
    $anex .=
    '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
    </li> ';
}
$anex .= '</ul>';

$tf = $relatorio->tipo; // para deixar comum para formParcial/formFinal
ob_start();
if ($relatorio->tipo == 'pa') {
    require '../relatorio/includes/formParcial.php';
} else {
    require '../relatorio/includes/formFinal.php';
}
$dataRelatorio = ob_get_clean();

// VALIDAÇÃO DO POST
if (isset($_POST['resultado'])) {
    if ($relatorio->idproj == $id_proj) {
        $form->id = $avaliacaoRelatorio->id;
        $form->id_avaliador = $user['id'];
        $form->solicitacoes = $_POST['solicitacoes'];
        $form->cidade = $_POST['cidade'];
        $form->whosigns = $_POST['whosigns'];
        $form->dateAssing = $_POST['dateAssing'];
        $form->resultado = $_POST['resultado'];
        $form->user = $user['id'];

        if ($cad) {
            $form->cadastrar();
        } else {
            $form->atualizar();
        }
        // put $anexosJS = json_decode($_POST['anexosJS']); !!!!!!!!!!!!

        switch ($form->resultado) {
            case 'a':
                $avaliacaoRelatorio->novaEtapaAvaliacao();
                break;
            case 'r':
                $avaliacaoRelatorio->solicitarAlteracoes();
                break;
            case 'e':
                echo 'Salvo para futuro converencia';
                break;
        }
        header('location: ../avaliacoes/index.php?tpAva=r2&status=success');
        exit;
    }
}
