<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use \App\Entity\HistRelatorios;
use \App\Db\Pagination;
/*
0 - Professor
1 - Coordenador colegiado
2 - Diretor de Cenro de Área
3 - Chefe de Divisão
4 - Diretor de Campus
*/
if(!in_array($user['config'],[1,3]) ){
  header('location: ../');
  exit;
}

/*
//Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);


//Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

//Condições SQL
$condicoes = [
  strlen($busca) ? 'nome LIKE "%'.str_replace(' ','%',$busca).'%"': null,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null
];


//Remove posições vazias
$condicoes = array_filter($condicoes);
*/
// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
$qntRelatorios = HistRelatorios::getQntdRegistros(); // ($where);

//paginação
$obPagination = new Pagination($qntRelatorios, $_GET['pagina']?? 1, 10);

//$relatorios = HistRelatorios::getRegistros(null,  $obPagination->getLimite());
$relatorios = HistRelatorios::getRegistros();

include '../includes/header.php';
/*
echo '<pre>';
// print_r($user);
print_r($relatorios);
echo '</pre>';
*/
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
