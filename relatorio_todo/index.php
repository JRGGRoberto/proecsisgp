<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use \App\Entity\Outros;


//Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
/*
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);
*/


//Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

//Condições SQL
$condicoes = [
  strlen($busca) ? 'titulo LIKE "%'.str_replace(' ','%',$busca).'%"': null /*,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null */
];

array_push($condicoes, 'id_user = "' .$user['id'] .'"', 'resultado = "e"') ;

//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
// $qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

//paginação
// $obPagination = new Pagination($qntAvaliacoes, $_GET['pagina']?? 1, 5);

//$avaliacoes = Avaliacoes::getRegistros($where, 'created_at', $obPagination->getLimite());



$query = "
select * 
from   
   relatorios  
where 
   tramitar = 1 and 
   last_result = 'n' and 
";

switch ($user['config']) {
  case 3: // campus
    $query .= ' ca_id = "'.$user['ca_id'].'" ';
    $query .= 'and  etapa in (1,4) '; // Somente os relatórios que estão na etapa 1 ou 2
    break;
  case 2: // centro
    $query .= ' ce_id = "'.$user['ce_id'].'" ';
    $query .= 'and etapa = 3 ';
    break;
  case 1: // colegiado
    $query .= ' co_id = "'.$user['co_id'].'" ';
    $query .= 'and etapa = 2 ';
    break;
  default:
     header('location: ../index.php?status=error');
     exit;
}

// 'fi','re','pr', 'pa'
function tipoRelatori($tp){
  switch ($tp){
    case 'fi':
      return "Final";
      break;
    case 're':
      return "Final com pedido de renovação";
      break;
    case 'pr':
      return "Final com pedido de prorrogação";
      break;
    case 'pa':
      return "Parcial";
      break;
    default:
      return "Tipo não definido";
      break;
  }
}



$avaliacoes = Outros::qry($query);

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
