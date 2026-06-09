<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Form_Rel;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\Relatorio;

$form = Form_Rel::getRegistro($_GET['i']);
$relatorio = new Relatorio();
$relatorio = Relatorio::getById($avaliacaoRelatorio->id_rel);
$obProjeto = Projeto::getProjetoLast($relatorio->idproj);
$obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
$obProfessor = new Professor();
$obProfessor = $obProfessor->getProfessor($obProjeto->id_prof);

$somenteLeitura = false;

$cad = false;
if (!$form) {
    $form = new Form_Rel();
    $cad = true;
} else {
    if (in_array($form->resultado, ['a', 'r'])) {
        $somenteLeitura = true;
    }
}

$anexados = Arquivo::getAnexados('forms', $form->id);
$anex = '<ul id="anexos_edt">';
$canDel = '';
foreach ($anexados as $att) {
    $canDel = '<a href="../arquiv/index.php?tab='.$att->tabela.'&id='.$att->id_tab.'&arq='.$att->nome_rand.'" >  
         <span class="badge badge-danger">🗑️ Excluir</span>
      </a>';

    if ($somenteLeitura) {
        $canDel = '';
    }

    $anex .=
    '<li>
      <a href="/home/sistemaproec/www/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
      '.$canDel.'
  </li> ';
}
$anex .= '</ul>';

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

        $anexosJS = json_decode($_POST['anexosJS']);
        foreach ($anexosJS as &$anx) {
            $dados = Arquivo::getArquivo($anx);
            $dados->tabela = 'forms';
            $dados->id_tab = $form->id;
            $dados->user = $obProjeto->user;
            $dados->atualizar();
        }

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
