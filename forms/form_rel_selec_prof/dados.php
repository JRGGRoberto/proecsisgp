<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Form_Rel_Selec_Prof;
use App\Entity\Outros;
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
$form = Form_Rel_Selec_Prof::getRegistro($avaliacaoRelatorio->id);
$cad = false;
if (!$form) {
    $form = new Form_Rel_Selec_Prof();
    $cad = true;
}

$prjS = Projeto::getRegistros("(id, ver)= ('".$_GET['p']."', ".$_GET['v'].')');
$prj = $prjS[0];

$sql1 =
        "select
           p.id, CONCAT(p.nome, ' | ', co.nome) as nome
        from
           professores p
           inner join colegiados co ON co.id = p.id_colegiado
           inner join centros ce on ce.id  = co.centro_id
           inner join campi ca on ca.id = ce.campus_id
           inner join centros ce2 on ce2.campus_id  = ca.id
           inner join colegiados co2 on co2.centro_id = ce2.id
           inner join professores p2 on co2.id = p2.id_colegiado
        where
           p2.id = '".$prj->id_prof."'
           and p.ativo = 1
           and p2.ativo  = 1
        order by p.nome asc";

$listaProf = Outros::qry($sql1);
// $listaProf = Professor::getProfessores("id_colegiado  = '".$prj->para_avaliar ."'  and ativo = 1 ");

$opc = '';
foreach ($listaProf as $l) {
    $opc .= "<option value='".$l->id."'>".$l->nome.'</option>';
}

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
        $form->id_parecerista = $_POST['id_parecerista'];
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
                $avaliacaoRelatorio->novaEtapaAvaliacao($form->id_parecerista);
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
