<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Db\Pagination;
use \App\Entity\Projeto;
use \App\Entity\Palavras;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

//Busca
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$palavra  = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING); 
/*
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$area = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);
$linh_ext = filter_input(INPUT_GET, 'linh_ext', FILTER_SANITIZE_STRING);
*/
$palavOrig = $palavra;

if (strlen($palavra)) {
  $palavra = Palavras::getProjByPalavra($palavra);
} else {
  $palavra = "";
}

/*

$qry = 'select ccc.co_id as id, ccc.colegiado as nome  from ca_ce_co ccc where1 ccc.ca_id  = "'. $user['ca_id'] .'"';
use \App\Entity\Diversos;
$sendColegiado = Diversos::qry($qry);
$coolSelectSend = '';
foreach($sendColegiado as $co){
  $coolSelectSend .= '<option value="'.$co->id.'">'.$co->nome.'</option>';
}

*/


//Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

//Condições SQL
$condicoes = [
  'id_prof = "' .$user['id'] .'"',
  strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ','%',$titulo).'%"': null,
  strlen($palavra) ? $palavra : null
  /*,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($area) ? "area_extensao = '$area_extensao'": null,  
  strlen($linh_ext) ? 'linh_ext LIKE "%'.str_replace(' ','%',$linh_ext).'%"': null */
];

//array_push($condicoes, 'id_prof = "' .$user['id'] .'"');

//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where1 = implode(' AND ', $condicoes);


$palavra = $palavOrig;

//Qntd total de registros
$qntdProjetos = Projeto::getQntdRegistros($where1);

//paginação
$obPagination = new Pagination($qntdProjetos, $_GET['pagina']?? 1, 5);

$projetos = Projeto::getRegistros($where1, null, $obPagination->getLimite());

/*
use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros();
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->nome.'"   >'.$prop->nome.'</option>';
}
*/

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
