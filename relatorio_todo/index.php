<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Outros;

Login::requireLogin();
$user = Login::getUsuarioLogado();


//Limita o acesso ao CO[1] CE[2] CA[3]
// 0 - Professor
// 1 - Coordenador colegiado
// 2 - Diretor de Cenro de Área
// 3 - Chefe de Divisão
// 4 - Diretor de Campus
if(!in_array($user['config'],[1,2,3]) ){ 
  header('location: ../');
  exit;
}


/***
Tipos de relatórios 
PA - Parcial
RE - Final renovação
PR - Final prorrogação
FI - Final

Validação do [PA] 
 1 etapa de 1 etapas  quem valida ->  CA[3]

Validação dos finais [RE] [PR] [FI]
 1 etapa de 3 etapas  quem valida ->  CA[3]
 2 etapa de 3 etapas  quem valida ->  CO[1]
 3 etapa de 3 etapas  quem valida ->  CE[2]

***/

$qryRelatRel = 'select * from relatorios';


if($user['config'] == 3 ){ 
   $qryRelatRel .= 
  " where 
      ca_id = '". $user['ca_id'] ."'  
      and tramitar = 1
      and etapa = 1
      and publicado <> 1
  ";

} elseif ($user['config'] == 2) { 
  $qryRelatRel .= 
  " where 
      co_id = '". $user['co_id'] ."'
      and tramitar = 1
      and etapa = 3
      and tipo in ('re','pr','fi')
      and publicado <> 1
  ";
} elseif ($user['config'] == 1) { 
  $qryRelatRel .= 
  " where 
      co_id = '". $user['co_id'] ."'
      and tramitar = 1
      and etapa = 2
      and tipo in ('re','pr','fi')
      and publicado <> 1
  ";

}
$dadosToAvaliar = Outros::qry($qryRelatRel);
//paginação
// $obPagination = new Pagination($qntAvaliacoes, $_GET['pagina']?? 1, 5);

// $avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());



include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php'; 
