<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Palavras;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

// Busca

$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_STRING);
/*
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$protocolo = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
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

/*

1832e881-39eb-11ed-9793-0266ad9885af	Curitiba I (EMBAP)
1832e953-39eb-11ed-9793-0266ad9885af	Curitiba II (FAP)
*/
$ca_ids = $user['ca_id'];
$inValues = '("'.$ca_ids.'")';
if (($ca_ids == '1832e881-39eb-11ed-9793-0266ad9885af') or ($ca_ids == '1832e953-39eb-11ed-9793-0266ad9885af')) {
    $inValues = '("1832e881-39eb-11ed-9793-0266ad9885af", "1832e953-39eb-11ed-9793-0266ad9885af")';
}

// Query pros colegiados
$qry = '';
if (($user['tipo'] == 'professor') || $user['tipo'] == 'prof') {
    $qry = 'select 
            ccc.co_id as id, 
            CONCAT("Colegiado de ", ccc.colegiado, "[", upper(ccc.codcam),"]") as nome,
            IFNULL(ccc.coord_id, "disabled") coord
          from ca_ce_co ccc where ccc.ca_id in '.$inValues.' ';
} elseif ($user['tipo'] == 'agente') {
    $qry = 'select 
            c.id as id,
            c.nome as nome,
            IFNULL(c.dir_campus_id, "disabled")  coord
          from campi c
          where c.id  in in '.$inValues.' ';
}

use App\Entity\Diversos;
use App\Entity\ProjMaster;

$sendColegiado = Diversos::qry($qry);
$coolSelectSend = '';

foreach ($sendColegiado as $co) {
    $dis = '';
    $info = '';
    if ($co->coord == 'disabled') {
        $dis = 'disabled';
        $info = ($user['tipo'] == 'professor' || $user['tipo'] == 'prof') ? '[Sem coordenador]' : '[Sem diretor de centro]';
    }

    $coolSelectSend .= '<option value="'.$co->id.'"  '.$dis.'>'.$co->nome.' '.$info.'</option>';
}

// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

// Condições SQL
$condicoes = [
    'id_prof = "'.$user['id'].'"',
    strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($palavra) ? $palavra : null,
    strlen($protocolo) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    /*,
  strlen($area) ? "area_extensao = '$area_extensao'": null,
  strlen($linh_ext) ? 'linh_ext LIKE "%'.str_replace(' ','%',$linh_ext).'%"': null */
];

// array_push($condicoes, 'id_prof = "' .$user['id'] .'"');

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where1 = implode(' AND ', $condicoes);

$palavra = $palavOrig;

// Qntd total de registros
$qntdProjetos = ProjMaster::getQntdRegistros($where1);

// paginação
$obPagination = new Pagination($qntdProjetos, $_GET['pagina'] ?? 1, 10);

$projetos = ProjMaster::getRegistros($where1, null, $obPagination->getLimite());

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
