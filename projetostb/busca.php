<?php

require '../vendor/autoload.php';

use \App\Entity\Projetostb;
use \App\Db\Pagination;


//Filtros
$coord  = filter_input(INPUT_GET, 'coord', FILTER_SANITIZE_STRING);
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$ano    = filter_input(INPUT_GET, 'ano', FILTER_SANITIZE_STRING);


//Condições SQL
$condicoes = [
  strlen($coord) ? 'coordenador LIKE "%'.str_replace(' ','%',$coord).'%"': null,
  strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ','%',$titulo).'%"': null,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($ano) ? "ano = '$ano'": null
];

$qndL = 0;
$qndL += strlen($coord) + strlen($titulo) + strlen($campus) + strlen($ano);

$currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$url = str_replace('busca','index', $currentPageUrl);

if($qndL == 0){
  header("Location: " .$url); 
  exit;
}


//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
$qntd = Projetostb::getQntd($where);

//paginação
$obPagination = new Pagination($qntd, $_GET['pagina']?? 1, 10);

$prjs = Projetostb::getList($where, null, $obPagination->getLimite());

include '../includes/header.php';
include './includes/listagem.php';
include '../includes/footer.php';