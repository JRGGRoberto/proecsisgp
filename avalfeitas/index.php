<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Db\Pagination;
use App\Entity\Avaliacoes;

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

array_push($condicoes, 'id_user = "'.$user['id'].'"', 'resultado in ("r", "a")');

// Remove posições vazias
$condicoes = array_filter($condicoes);
/*echo "<pre>";
print_r($condicoes);
echo "</pre>";
*/
// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Qntd total de registros
$qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

// paginação
$obPagination = new Pagination($qntAvaliacoes, $_GET['pagina'] ?? 1, 10);

$avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
