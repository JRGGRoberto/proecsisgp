<?php

use App\Entity\Arquivo;
use App\Entity\AvaliaRelatorios;
use App\Entity\Projeto;

// VALIDAÇÃO DO ID
if (!isset($_GET['i'], $_GET['p'], $_GET['v'])) {
    header('location: /avaliacoes/form_view.php?tpAva=p1&status=error');
    exit;
}

$id_ava = $_GET['i'];
$id_proj = $_GET['p'];
$ver_proj = $_GET['v'];

$avaliacaoRelatorio = (object) AvaliaRelatorios::getById($id_ava);

if ($avaliacaoRelatorio->idproj != $id_proj) {
    header('location: ../avaliacoes/index.php?tpAva=p1&status=error');
    exit;
}

$prj = Projeto::getProjetoView($avaliacaoRelatorio->idproj, $avaliacaoRelatorio->pver);

$cima = '<hr>
Etapa '.$avaliacaoRelatorio->fase_seq.' de '.$avaliacaoRelatorio->fases.'
<a href="../propostas/visualizar.php?id='.$avaliacaoRelatorio->idproj.'&v='.$avaliacaoRelatorio->pver.'&w=nw" target="_blank"><button class="btn btn-success btn-sm mb-2 float-right" > Visualizar</button></a>';

$prjS = Projeto::getRegistros("(id, ver)= ('".$_GET['p']."', ".$_GET['v'].')');
$prj = $prjS[0];

// Para mostar os anexos do Relatório
$anexadosForm = Arquivo::getAnexados('relatorios', $relatorio->id);

$anexForm = '<ul id="anexos_edt">';
foreach ($anexados as $att) {
    $anexForm .=
    '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
    </li> ';
}
$anexForm .= '</ul>';

$tf = $relatorio->tipo; // para deixar comum para formParcial/formFinal
ob_start();
if ($relatorio->tipo == 'pa') {
    require '../relatorio/includes/formParcial.php';
} else {
    require '../relatorio/includes/formFinal.php';
}

$dataRelatorio = ob_get_clean();

include '../includes/header.php';
echo $cima;

include './'.$avaliacaoRelatorio->form.'/form_view.php';

$scriptDisabled =
'
<script>
window.onload = function() {
';

$scriptDisabled .= $relatorio->tipo = 'pa' ?
"
$('#sumnot_atvd_per').summernote('disable');
$('#sumnot_alteracoes').summernote('disable');
$('#sumnot_atvd_prox_per').summernote('disable');
" :
"
$('#sumnot_atividades').summernote('disable');
$('#sumnot_atvd_prox_per').summernote('disable');
$('#sumnot_rel_tec_cien_executado').summernote('disable');
$('#sumnot_divulgacao').summernote('disable');
";

$scriptDisabled .=
'
}
</script>
';
echo $scriptDisabled;

include '../includes/footer.php';
