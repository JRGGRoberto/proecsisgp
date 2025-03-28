<?php

require '../vendor/autoload.php';

use \App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

use \App\Db\Pagination;
use \App\Entity\Avaliacoes;


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

/*


select 
  rp.id, rp.idproj , pl.titulo, pl.id_prof, p.nome, rp.periodo_ini, rp.periodo_fim, rp.tramitar, rp.ava_publicar
from 
  rel_parcial rp 
  inner join proj_last pl on rp.idproj = pl.id
  inner join professores p on pl.id_prof = p.id
where 
   rp.tramitar  =  1 and 
   rp.ava_publicar = 0

*/

//Qntd total de registros
$qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

//paginação
$obPagination = new Pagination($qntAvaliacoes, $_GET['pagina']?? 1, 5);

$avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());

include '../includes/header.php';
echo '<pre>';
print_r($obQAvalioRel);
echo '</pre>';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
