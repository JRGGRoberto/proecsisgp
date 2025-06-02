<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Outros;

Login::requireLogin();
$user = Login::getUsuarioLogado();


//Limita o acesso ao CO 1 e CA 3
// 0 - Professor
// 1 - Coordenador colegiado
// 2 - Diretor de Cenro de Área
// 3 - Chefe de Divisão
// 4 - Diretor de Campus
if(!in_array($user['config'],[1,3]) ){ 
  header('location: ../');
  exit;
}

/*
//Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//Filtro de status

//Condições SQL
$condicoes = [
  strlen($busca) ? 'titulo LIKE "%'.str_replace(' ','%',$busca).'%"': null /*,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null 
];


array_push($condicoes, 'id_user = "' .$user['id'] .'"', 'resultado = "e"') ;

//Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);


//Qntd total de registros
// $qntAvaliacoes = Avaliacoes::getQntdRegistros($where);
*/

if($user['config'] == 3 ){ 
  $qryRelatRel = 
  "select 
      rp.id,
      lv.protocolo, lv.titulo, lv.tipo_exten, lv.nome_prof, lv.para_avaliar, 
      DATE_FORMAT(lv.created_at, '%d/%m/%Y') created_at, 
      'parcial' as 'tp',
      lv.id idproj, lv.ver
  from 
      rel_parcial rp
      inner join proj_inf_lv lv on 
            lv.id = rp.idproj  
            and  ( ( fase_seq = etapas) or (etapas = 0 and fase_seq is null) )
            and rp.last_result = 'n'
            and campus = '". $user['ca_nome']."' 
   ";
} else {  //como só é permitido ao CO 1 e CA 3, não sendo o CA 3, é o CO 1
  //CO 1  -- relatório Final 2ª etapa
  $qryRelatRel = 
  "select 
      rp.id,
      lv.protocolo, lv.titulo, lv.tipo_exten, lv.nome_prof, lv.para_avaliar, 
      DATE_FORMAT(lv.created_at, '%d/%m/%Y') created_at, 
      'parcial' as 'tp',
      lv.id idproj, lv.ver
  from 
      rel_parcial rp
      inner join proj_inf_lv lv on 
            lv.id = rp.idproj  
            and  ( ( fase_seq = etapas) or (etapas = 0 and fase_seq is null) )
            and rp.last_result = 'n'
            and 1 = 2
   ";

}
$dadosToAvaliar = Outros::qry($qryRelatRel);
//paginação
// $obPagination = new Pagination($qntAvaliacoes, $_GET['pagina']?? 1, 5);

// $avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());



include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
