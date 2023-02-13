<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use \App\Entity\Professor;
use \App\Db\Pagination;

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

/*

if ($user[adm] == 1){
  $a = true;
} else {
  switch ($user[niveln]) {
    case 1:
      array_push($condicoes, "ca_id = '". $user[ca_id] .'"');
      break;
    case 2:
      array_push($condicoes, "ce_id = '". $user[ce_id] .'"');
      break;
    case 3:
      array_push($condicoes, "co_id = '". $user[co_id] .'"');
      break;
    default:
      header('location: ../home/index.php?status=error');
      exit;
  } 
}

*/

//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
$qntProfessores = Professor::getQntdProfessores($where);

//paginação
$obPagination = new Pagination($qntProfessores, $_GET['pagina']?? 1, 10);

$professores = Professor::getProfessores($where, null, $obPagination->getLimite());


include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
