<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Palavras;
// use App\Entity\Projeto;
use App\Session\Login;
use App\Entity\ProjMaster;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

// Busca
$nome_prof = filter_input(INPUT_GET, 'nome_prof', FILTER_SANITIZE_STRING);
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_STRING);

/*
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$area = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);
$linh_ext = filter_input(INPUT_GET, 'linh_ext', FILTER_SANITIZE_STRING);
*/
$palavOrig = $palavra;



if (strlen($palavra)) {
    $palavra = Palavras::getProjByPalavra($palavra);
} else {
    $palavra = '';
}

// $qry = 'select 
//           ccc.co_id as id, 
//           ccc.colegiado as nome,
//           IFNULL(ccc.coord_id, "disabled") coord
//         from ca_ce_co ccc where ccc.ca_id  = "'.$user['ca_id'].'"';


// use App\Entity\Diversos;


// $sendColegiado = Diversos::qry($qry);
$coolSelectSend = '';

// foreach ($sendColegiado as $co) {
//     $dis = '';
//     $info = '';
//     if ($co->coord == 'disabled') {
//         $dis = 'disabled';
//         $info = '[Sem coordenador]';
//     }

//     $coolSelectSend .= '<option value="'.$co->id.'"  '.$dis.'>'.$co->nome.' '.$info.'</option>';
// }

// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
$execucao = filter_input(INPUT_GET, 'execucao', FILTER_SANITIZE_NUMBER_INT);
$finalizados = filter_input(INPUT_GET, 'finalizados', FILTER_SANITIZE_NUMBER_INT);
$vigenciaFinalizada = filter_input(INPUT_GET, 'vigenciaFinalizada', FILTER_SANITIZE_NUMBER_INT);
$naoIniciados = filter_input(INPUT_GET, 'naoIniciados', FILTER_SANITIZE_NUMBER_INT);
$emAvaliacao  = filter_input(INPUT_GET, 'emAvaliacao', FILTER_SANITIZE_NUMBER_INT);

// echo '<pre>';
// print_r($condicoes);
// echo '</pre>';

// Condições SQL
$condicoes = [
    strlen($titulo) ? ' titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($palavra) ? $palavra : null,
    strlen($protocolo) ? ' protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    strlen($campus) ? ' campus LIKE "%'.str_replace(' ', '%', $campus).'%"' : null,
    strlen($nome_prof) ? ' coord LIKE "%'.str_replace(' ', '%', $nome_prof).'%"' : null,
];

//Puxa os estados via get dos checkboxs
$estados = [];
if (isset($_GET['emAvaliacao'])) {
    $estados[] = 1;
}
if (isset($_GET['naoIniciados'])) {
    $estados[] = 2;
}
if (isset($_GET['execucao'])) {
    $estados[] = 3;
}    
if (isset($_GET['vigenciaFinalizada']))  {
    $estados[] = 4;
}
if (isset($_GET['finalizados']))  {
    $estados[] = 5;
}



// echo '<pre>';
// print_r($estados);
// echo '</pre>';


//adiciona os filtros do checkbox
if (!empty($estados)) {
    $condicoes[] = 'estado in (' . implode(',', $estados) . ')';
}

// array_push($condicoes, '
//  resultado = "a" 
//  and para_avaliar not in ("0" , "-1")
//  and ( ( fase_seq = qnt_fases) or (qnt_fases = 0 and fase_seq is null) )

//  ');


// echo '<pre>';
// print_r($condicoes);
// echo '</pre>';
// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where1 = implode(' AND ', $condicoes);

$palavra = $palavOrig;

// Qntd total de registros
$qntdProjetos = ProjMaster::getQntdRegistros($where1);

// paginação
$obPagination = new Pagination($qntdProjetos, $_GET['pagina'] ?? 1, 5);
$projetos = ProjMaster::getRegistros($where1, null, $obPagination->getLimite());


// echo '<pre>';
// print_r($condicoes);
// echo '</pre>';

/*
use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros();
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->nome.'"   >'.$prop->nome.'</option>';
}
*/

include '../includes/header.php';
include __DIR__.'/includes/listagem_all.php';
include '../includes/footer.php';
