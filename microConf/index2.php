<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Db\Pagination;
use App\Entity\Pibis_pibex_proj;

// Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
/*
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);
*/

// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

// Condições SQL
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null, /*,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null
  */
];

/*
array_push($condicoes, 'id_instancia = "'.$inst_id.'"');
array_push($condicoes, 'tp_avaliador = "'.$inst_tp.'"');
*/
// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Qntd total de registros
$qntProjPIbisBex = Pibis_pibex_proj::getQntd($where);

// paginação
$obPagination = new Pagination($qntProjPIbisBex, $_GET['pagina'] ?? 1, 10);

$ProjPIbisBex = Pibis_pibex_proj::gets($where, null, $obPagination->getLimite());

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
