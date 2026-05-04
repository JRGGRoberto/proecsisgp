<?php

use App\Entity\AvaliaRelatorios;
use App\Entity\Projeto;

// VALIDAÇÃO DO ID
if (!isset($_GET['i'], $_GET['p'], $_GET['v'])) {
    header('location: /avaliacoes/index.php?tpAva=p1&status=error');
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

include './'.$avaliacaoRelatorio->form.'/dados.php';

include '../includes/header.php';
echo $cima;

include './'.$avaliacaoRelatorio->form.'/form.php';

$scriptDisabled = $relatorio->tipo = 'pa' ?
"<script>
$('#sumnot_atvd_per').summernote('disable');
$('#sumnot_alteracoes').summernote('disable');
$('#sumnot_atvd_prox_per').summernote('disable');
</script>" :
"<script>
$('#sumnot_atividades').summernote('disable');
$('#sumnot_atvd_prox_per').summernote('disable');
$('#sumnot_rel_tec_cien_executado').summernote('disable');
$('#sumnot_divulgacao').summernote('disable');
</script>";

echo $scriptDisabled;

include '../includes/footer.php';
