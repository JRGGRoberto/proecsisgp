<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\Outros;

// Busca
// ////$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
/*
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);
*/

// Filtro de status
// /      $filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

// Condições SQL

// /     array_push($condicoes, 'id_user = "'.$user['id'].'"', 'resultado in ("r", "a")');

// Remove posições vazias
// ////////////////$condicoes = array_filter($condicoes);
/*echo "<pre>";
print_r($condicoes);
echo "</pre>";
*/
// Cláusula WHERE
// /////$where = implode(' AND ', $condicoes);

// Qntd total de registros
// $qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

$iduser = $user['id'];

$qry = 'select 
 p.idprof,  p.prog,
 c.nome, c.cidade, c.curso,
 DATE_FORMAT(i.created_at, "%d/%m/%Y %H:%i") dt_insc
from 
   candidatos c 
   inner join inscricao i on i.id_can = c.id
   inner join divulga_proj p on p.id = i.if_prog 
where p.idprof = "'.$iduser.'"';

$candidatos = Outros::qry($qry);

// paginação
// $obPagination = new Pagination($qntAvaliacoes, $_GET['pagina'] ?? 1, 10);

// $avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
