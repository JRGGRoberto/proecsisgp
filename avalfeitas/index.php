<?php

require '../vendor/autoload.php';

use \App\Session\Login;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use \App\Entity\Outros;
use \App\Db\Pagination;

//Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);


//Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

//Condições SQL
/*
$condicoes = [
  strlen($busca) ? 'nome LIKE "%'.str_replace(' ','%',$busca).'%"': null,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null
];
*/

$sql = '';


switch ($user['niveln']) {
  case 0: // parecer
    $sql = 
    `select 
      p.id, p.ver, p.titulo, fa.resultado, fa.parecer
    from  form_a_2211 fa 
      inner join projetos p  on (fa.id, fa.ver) = (p.id, p.ver)
    where 
      fa.resultado in ('aprovado', 'reprovado') and fa.avaliador_pos = 0`;
    
    break;
  case 1: // join 1 e ultima instancia CAMPUS
    $sql = 
    'select
      concat(fa.id, fa.ver) id_av, fa.`data`, 
       p.titulo, fa.resultado, fa.parecer
     from  form_a_2211 fa 
       inner join projetos p  on (fa.id, fa.ver) = (p.id, p.ver)
       inner join ca_ce_co c on p.para_avaliar  = c.co_id 
     where 
       fa.resultado in ("aprovado", "reprovado") 
       and fa.avaliador_pos = '.  $user['niveln'] . '
       and c.ca_id =  "'.  $user['ca_id'] . '"' ;
    
    
    break;
  case 2: // diretor de centro
    $sql = 
    `select 
      p.id, p.ver, p.titulo, fa.resultado, fa.parecer
    from  form_a_2211 fa 
      inner join projetos p  on (fa.id, fa.ver) = (p.id, p.ver)
    where 
      fa.resultado in ('aprovado', 'reprovado') and fa.avaliador_pos = 2`;
    
    break;
  case 3:  // colegiado
    $sql = 
    `select 
      p.id, p.ver, p.titulo, fa.resultado, fa.parecer
    from  form_a_2211 fa 
      inner join projetos p  on (fa.id, fa.ver) = (p.id, p.ver)
    where 
      fa.resultado in ('aprovado', 'reprovado') and fa.avaliador_pos = 3`;
    
    break;
  default:
    header('location: ../home/index.php?status=error');
    exit;
} 




/*
//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

//Qntd total de registros
/// $qntProfessores = Professor::getQntdProfessores($where);

//paginação
$obPagination = new Pagination($qntProfessores, $_GET['pagina']?? 1, 10);

//$professores = Professor::getProfessores($where, null, $obPagination->getLimite());
*/


 $avaliados = Outros::qry($sql);


include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
