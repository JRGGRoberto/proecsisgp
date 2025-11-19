<?php
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



use \App\Entity\Projeto;
use \App\Entity\Professor;
use \App\Entity\Area_Cnpq;
use \App\Entity\CnpqArea;
use \App\Entity\CnpqSubA;
use \App\Entity\Area_Extensao;

use \App\Entity\Diversos;
use Dompdf\Dompdf;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensagem = '';
$jan = 'sem';



//VALIDAÇÃO DO ID
if(!isset($_GET['id'], $_GET['v'])){
  header('location: index.php?status=error');
  exit;
}

$id = $_GET['id'];
$ver = $_GET['v'];
$jan = $_GET['w'];


//CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto = Projeto::getProjeto($id, $ver); // getProjetoView($id, $ver);
$obProfessor = (Object) Professor::getProfessor($obProjeto->id_prof);


//VALIDAÇÃO DA TIPO
if(!$obProjeto instanceof Projeto){
  header('location: ../index.php?status=error');
  exit;
}

use \App\Entity\Colegiado;
$coolCur = '';

$coleg = Colegiado::getRegistro($obProjeto->para_avaliar);
if($coleg  instanceof Colegiado){
   //$coolCur = Colegiado::getRegistro($obProjeto->para_avaliar)['nome'];
   $coolCur = $coleg ->nome;
}


$t = $obProjeto->tipo_exten;
$tpprop = '';


switch($t) {
  case 1: 
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE CURSO';
    $tpprop = '( x ) Curso<br>( <span> </span><span> </span>) Evento<br>';
    break;
  case 2:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE EVENTO';
    $tpprop = '( <span> </span><span> </span> ) Curso<br>( x ) Evento<br>';
    break;
  case 3:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PRESTAÇÃO DE SERVIÇO';
    $tpprop = '( <span> </span><span> </span> ) Programa<br>( <span> </span><span> </span> ) Projeto<br>( x ) Prestação de Serviço<br>';
    break;
  case 4:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMA';
    $tpprop = '( x ) Programa<br>( <span> </span><span> </span> ) Projeto<br>( <span> </span><span> </span> ) Prestação de Serviço<br>';
    break;
  case 5:
    $title2 = 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROJETO';
    $tpprop = '( <span> </span><span> </span> ) Programa<br>( x ) Projeto<br>( <span> </span><span> </span> ) Prestação de Serviço<br>';
    break;
  default:
    header('location: index.php?status=error');
    exit;
}



$anexoII = [3, 4, 5];
$anexoIII = [1, 2];

if (in_array($t, $anexoII)) { 
  $title = 'ANEXO II';
} else {
  $title = 'ANEXO III';
}

/*
if ($jan == 'nw') {
  include '../includes/headers.php';
} else {
  include '../includes/header.php';
}
include __DIR__.'/includes/formreadonly.php';
include '../includes/footer.php';
*/


$sql = "
Select 
   CONCAT(
     IFNULL(ccc.codcam, 'wh') ,
     '-',
     IFNULL(SUBSTRING(p.`data`, 1, 4), 9999),
     '-',
     SUBSTRING(uuid(), 5,4),
     '-',
     case 
       when tipo_ext = 1 then 'cur'
       when tipo_ext = 2 then 'eve'
       when tipo_ext = 3 then 'ser'
       when tipo_ext = 4 then 'pro'
       when tipo_ext = 5 then 'prj'
     end
     ) codigo
from 
   proj_inf p
   left join ca_ce_co ccc on p.para_avaliar = ccc.co_id
where (p.id, p.ver) = ('". $obProjeto->id ."', ". $obProjeto->ver ." ) ";


$filename = Diversos::q($sql);

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="pt-Br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-Br">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>'. $filename->codigo .'</title>
  <style type="text/css">
  @page {
    margin: 1.5cm 2cm;
  }

  @media print {
    #print {
      visibility: hidden;
    }
    @page {
      margin: 1.5cm 2cm;
      size: portrait;
    }

  }

  body {
    font-family: sans-serif;
    margin: 0.2cm 0 1.5cm 0;
    text-align: justify;
  }

  #header,
  #footer {
    position: fixed;
    left: 0;
    right: 0;
    font-size: 0.9em;
  }



  #footer {
    bottom: 0;
    border-top: 0.1pt solid #aaa;
  }

  #header table,
  #footer table {
    width: 100%;
    border-collapse: collapse;
    border: 1px;
    border-color: black;
  }

  #header td,
  #footer td {
    padding: 0;
    width: 50%;
  }

  .page-number {
    text-align: center;
  }

  .page-number:before {
    
  }

  hr {
    page-break-after: always;
    border: 0;
  }

  .centralizado {
    text-align: center;
  }

 

.td1 {
  border: 0;
  border-collapse: collapse;
  text-align: center;
}

table, th, td {
  border: 0.5px solid gray;
  border-collapse: collapse;
  padding: 5px;
}
.time {
  width: 100%;
}

.table-bordered {
  width: 100%;
}


.th_cinza {
  background-color: #eeeeee;
  font-weight: lighter;
  text-align: left;
}

peq {
  font-family: "arial";
  font-size:5px;
}

c {
  text-align: center;
  font-family: "arial";
  font-size:5px;
}

</style>

</head>
<body>
  <div id="footer">
    <div class="page-number"></div>
  </div>';

/**
 * Fim cabeçalho
 */

 

  $count = 0; 
  $html .= '<span id="print" onclick="printIT();" style="text-decoration:underline;cursor:pointer;">🖨️</span>';
  $html .= '<img src="../imgs/logo_unespar.png" width="120px" style="display: block;  margin-left: auto;  margin-right: auto;">';
  $html .= '<h4 class="centralizado">'. $title .'</h4>';
  $html .= '<h5 class="centralizado">'. $title2 .'</h5>';
  $html .= '<p class="c p centralizado"><font size="1">*O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão Tramitação: Coordenador -> Divisão de Extensão e Cultura -> Colegiado de Curso -> Conselho de Centro de Área -> Divisão de Extensão e Cultura.</font></p>';
  
/*
  <table>
   <thead><tr><th class="th_cinza">N</th></tr></thead>
  <tbody><tr><td></tbody>
  </table>

  
  */

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Título da proposta</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->titulo .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Protocolo da proposta</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->protocolo .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Coordenador</strong></th></tr></thead>
   <tbody><tr><td>'. $obProjeto->nome_prof .'</td></tr></tbody>
  </table>'
  ;

  $telefone= '';
  $email = '';

  use \App\Entity\Agente;
  if($obProjeto->regras == "6204ba97-7f1a-499e-a17d-118d305bf7e4"){
    $telefone = $obProfessor->telefone;
    $email =    $obProfessor->email;
  } elseif ($obProjeto->regras == "a45daba2-12ec-11ef-b2c8-0266ad9885af"){
    $dadosAgentes = (Object)Agente::get($obProjeto->id_prof);
    $telefone = $dadosAgentes->telefone;
    $email =    $dadosAgentes->email;
  }



  $html .= 
  '<table class="time">
    <thead>
      <tr>
        <th class="th_cinza" colspan="4"><strong>'. ++$count .'. Contato do Coordenador</strong></th>
      </tr>
    </thead>
    <tbody>
      <tr>
         <td class="th_cinza"><strong>Telefone</strong></td>
         <td>** *********</td>
         <td class="th_cinza"><strong>Email</strong></td>
         <td>'. $email.'</td>
      </tr>
    </tbody>
  </table>'
  ;
  
  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Colegiado de Curso</strong></th></tr></thead>
  <tbody><tr><td>'. $coolCur .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Campus</strong></th></tr></thead>
  <tbody><tr><td>'. $obProfessor->campus .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Tipo de proposta</strong></th></tr></thead>
  <tbody><tr><td>'. $tpprop .'</td></tr></tbody>
  </table>'
  ;


  if (in_array($t, $anexoII)) { 
    $acec = ($obProjeto->acec == 'S'? 
    '( x ) Sim<br>( <span> </span><span> </span> ) Não<br>' : 
    '( <span> </span><span> </span> ) Sim<br>( x ) Não<br>');

    $html .= 
    '<table class="time">
     <thead><tr><th class="th_cinza"><strong>'. ++$count .'. A proposta está vinculada a alguma disciplina do curso de Graduação ou Pós?Graduação (ACEC II)</strong></th></tr></thead>
    <tbody><tr><td>'. $acec . '</td></tr></tbody>
    </table>'
    ;
  } 

  $vinculo = ($obProjeto->vinculo === 'S'? '( x ) Vinculado <span> </span> <span> </span>( <span> </span><span> </span> ) Não vinculado' : '( <span> </span><span> </span> ) Sim<br>( x ) Não');
    $html .= 
    '<table class="time">
      <thead>
        <tr>
          <th class="th_cinza" colspan="2"><strong>'. ++$count .'. Vinculação à Programa de Extensão e Cultura</strong></th>
        </tr>
      </thead>
      <tr>
        <th class="th_cinza"><strong>'. $count . '.1. É vinculado?</strong></th> <td>'.$vinculo.'</td>
      </tr>';
      
      
/*
entre os tr de baixo 


**/

    if ($obProjeto->vinculo === 'S'){
      $html .= '  <thead>
      <tr>
        <th class="th_cinza" colspan="2"><strong>'. $count . '.2. Título do Programa de vinculação</strong></th>
      </tr>
      </thead>
      <tr>
        <td  colspan="2">'.  $obProjeto->tituloprogvinc .'</td>
      </tr>';

    }


  $html .= '</table>';
 

 
  $cnpq_sarea = '';
  $cnpq_sarea1 = CnpqSubA::getRegistro( $obProjeto->cnpq_sarea);
  if($cnpq_sarea1 instanceof CnpqSubA){
    $cnpq_sarea = $cnpq_sarea1->nome;
  }

  $cnpq_garea =  Area_Cnpq::getRegistro($obProjeto->cnpq_garea);
  if($cnpq_garea instanceof Area_Cnpq){
    $cnpq_garea = $cnpq_garea->nome;
  } else {
    $cnpq_garea = '';
  }


  $cnpq_gare =  CnpqArea::getRegistro($obProjeto->cnpq_area);
  if($cnpq_gare instanceof CnpqArea){
    $cnpq_gare = $cnpq_gare->nome;
  } else {
    $cnpq_gare = '';
  }


  
  use \App\Entity\Area_temat;

  if (in_array($t, $anexoII)) { 
    $html .= 
    '<table class="time">
      <thead>
        <tr>
          <th class="th_cinza" colspan="2"><strong>'. ++$count .'. Classificação do Projeto ou Programa</strong></th>
        </tr>
        <tr>
          <th class="th_cinza" colspan="2"><strong>'. $count . '.1. Áreas de Conhecimento CNPq</strong></th>
        </tr>
      </thead>
      <tbody> 
        <tr>  
           <td><strong>a) Grande Área</strong></td>    <td>'. $cnpq_garea  .'</td>
        </tr><tr>
           <td><strong>b) Área</strong></td>           <td>'. $cnpq_gare .'</td>

        </tr><tr>
           <td><strong>c) Subárea</strong></td>        <td>'. $cnpq_sarea .'</td>
        </tr>
        
        <thead>
          <tr>
            <th class="th_cinza" colspan="2"><strong>'. $count . '.2. Plano Nacional de Extensão Universitária</strong></th>
          </tr>
        </thead>
        <tr>
           <td><strong>a) Área de Extensão</strong></td>    <td>'. Area_Extensao::getRegistro($obProjeto->area_extensao)->nome .'</td>
        </tr><tr>
           <td><strong>b) Linha de Extensão</strong></td>   <td>'. Area_temat::getRegistro($obProjeto->linh_ext )->nome  .'</td>
        </tr>
      </tbody>
    </table>'
    ;

  }
  

  $dt1 = substr($obProjeto->vigen_ini, 0, 10);
  $dt1 = substr($dt1, 8, 2). '/'.substr($dt1, 5, 2). '/'. substr($dt1, 0, 4);

  $dt2 = substr($obProjeto->vigen_fim, 0, 10);
  $dt2 = substr($dt2, 8, 2). '/'.substr($dt2, 5, 2). '/'. substr($dt2, 0, 4);

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Período de vigência</strong></th></tr></thead>
  <tbody><tr><td>'.  $dt1 . ' a ' . $dt2 .'</td></tr></tbody>
  </table>'
  ;

  if (in_array($t, $anexoII)) {
    $tide = $obProjeto->tide == 'S'? '( x ) Sim <span> </span> <span> </span>( <span> </span><span> </span> ) Não' : '( <span> </span><span> </span> ) Sim <span> </span> <span> </span>( x ) Não';  
    $html .= 
    '<table class="time">
      <thead>
        <tr>
          <th class="th_cinza" colspan="4"><strong>'. ++$count .'. Carga Horária</strong></th>
        </tr>
      </thead>
      <tr>
        <th class="th_cinza"><strong>Horas por semana*</strong></th> <td>'. $obProjeto->ch_semanal.'</td>
        <th class="th_cinza"><strong>TIDE</strong></th> <td>'. $tide.'</td>
      </tr>
      <tr>
          <th class="th_cinza" colspan="4"><sup>*Indicar a CH a ser computada no PAD, cf. regulamento próprio de distribuição de carga horária da Unespar</sup></strong></th>
        </tr>
     </table>';

  } elseif (in_array($t, $anexoIII)) {
    $html .= 
    '<table class="time">
      <thead>
        <tr>
          <th class="th_cinza" colspan="2"><strong>'. ++$count .'. Carga Horária</strong></th>
        </tr>
      </thead>
      <tr>
        <th class="th_cinza"><strong>Total de horas</strong></th> 
        <td>'. $obProjeto->ch_total.'</td>
      </tr>
      
     </table>';
  }


  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza" colspan="2"><strong>'. ++$count .'. Dimensão</strong></th></tr></thead>
   <tbody>
      <tr>
        <th class="th_cinza" style=" width: 30px;"><strong>Publico alvo</strong></th> 
        <td>'.  $obProjeto->public_alvo .'</td>
      </tr>
      <tr>
        <th class="th_cinza"><strong>Abrangência</strong></th> 
        <td>'.  $obProjeto->municipios_abr .'</td>
        </tr>
   </tbody>
  </table>'
  ;


  
  $finac = ($obProjeto->finac == 'S'? '( <span> </span><span> </span> ) Sem  <span> </span> <span> </span>( x ) Com ' : '( x ) Sem  <span> </span> <span> </span>( <span> </span><span> </span> ) Com ');
  $finacInfo = '';

  if ($obProjeto->finac == 'S'){
    $finacInfo = '
    <tr>
      <th class="th_cinza" style=" width: 30px;"><strong>Órgão de Financiamento</strong></th> 
      <td>'.  $obProjeto->finacorgao .'</td>
    </tr>
    <tr>
      <th class="th_cinza"><strong>Valor do Financiamento</strong></th> 
      <td>'.  $obProjeto->finacval .'</td>
    </tr>
    ';
  }

    $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza" colspan="2"><strong>'. ++$count .'. Previsão de Financiamento</strong></th></tr></thead>
   <tbody>
      <tr>
        <th class="th_cinza" style=" width: 100px;"><strong>Financiamento</strong></th> 
        <td>'.  $finac .'</td>
      </tr>';

    $html .= $finacInfo;
    $html .= '
      </tbody>
    </table>'
  ;


/*
  $parca = $obProjeto->parceria == 'S'? '( x ) Sim <span> </span> <span> </span>( <span> </span><span> </span> ) Não' : '( <span> </span><span> </span> ) Sim <span> </span> <span> </span>( x ) Não';
  $parcInfo = '';

  if ($obProjeto->parceria == 'S'){
    $parcInfo = '
    <tr>
      <th class="th_cinza" style=" width: 30px;"><strong>Nome(s) da(s) Entidade(s)</strong></th> 
      <td>'.  $obProjeto->parcanomes .'</td>
    </tr>
    <tr>
      <th class="th_cinza"><strong>Atribuição(ões) da(s) Entidade(s)</strong></th> 
      <td>'.  $obProjeto->parcaatribuic .'</td>
    </tr>
    ';
  }
  

    $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza" colspan="2"><strong>'. ++$count .'.Parcerias</strong></th></tr></thead>
   <tbody>
      <tr>
        <th class="th_cinza" style=" width: 100px;"><strong>Possui parcerias</strong></th> 
        <td>'.  $parca .'</td>
      </tr>';

    $html .= $parcInfo;
    $html .= '
      </tbody>
    </table>'
  ;
*/


  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza" colspan="6"><strong>'. ++$count .'. Equipe da proposta</strong></th></tr></thead>';
 


  use \App\Entity\Equipe;
  $tblEquipe = '';
  $equipe = Equipe::getMembProj($obProjeto->id);
  $x = 0;
  foreach($equipe as $pess){
    $tblEquipe .=
     '<tr>
        <td>'. ++$x. '</td>
        <td>'. $pess->nome .'</td>
        <td>'. $pess->instituicao .'</td>
        <td>'. $pess->formacao .'</td>
        <td>'. $pess->funcao .'</td>
        <td>'. $pess->tel .'</td>
      </tr>';
  }

  if($x == 0 ){
    $html .= 
  '<tbody> <tr>  <td colspan="6">Trabalho desenvolvido apenas pelo coordenador</td>  </tr>  </tbody>
  </table>'
;

  } else {
    $html .= '
    </thead>
      <tr>
        <th class="th_cinza">N</th>
        <th class="th_cinza">Nome</th>
        <th class="th_cinza">Instituição</th>
        <th class="th_cinza">Formação</th>
        <th class="th_cinza">Função na equipe</th>
        <th class="th_cinza">Telefone</th>
      </tr>
    </thead>
      <tbody>';
    $html .= $tblEquipe;
    $html .= '    </tbody>
    </table>';
  }


  use \App\Entity\Palavras;
  $lista = '';
  $palavras = Palavras::getPalavrasByProj($obProjeto->id);
  $x = 0;
  foreach($palavras as $palavra){
    $lista .= '<li>'.$palavra->palavra . '</li>';
    ++$x;
  }
  if($x > 0) {
    $lista = '<ul>'. $lista . '</ul>';
  } else {
    $lista = 'Sem palavras-chave.' ;
  }

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'.  Resumo</strong></th></tr></thead>
   <tbody><tr><td>'. $obProjeto->resumo .'</td></tr></tbody>

   <thead><tr><th class="th_cinza"><strong>'. ++$count .'.  Palavras-chave</strong></th></tr></thead>
   <tbody><tr><td>'. $lista .'</td></tr></tbody>
  </table>'
  ;
  
  $titulo = '';

  if (in_array($t, $anexoII)) {
    $titulo ='.  Problema e justificativa da proposta';
  } elseif (in_array($t, $anexoIII)) {
    $titulo ='.  Justificativa da proposta';
  }

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. '. $titulo .'</strong></th></tr></thead>
  <tbody><tr><td>'.  $obProjeto->justificativa .'</td></tr></tbody>
  </table>'
  ;


  if (in_array($t, $anexoII)) {
    $titulo = '.  Objetivos – Geral e Específicos';
  } elseif (in_array($t, $anexoIII)) {
    $titulo = '.  Objetivos';
  }
  
  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. '. $titulo .'</strong></th></tr></thead>
  <tbody><tr><td>'.  $obProjeto->objetivos .'</td></tr></tbody>
  </table>'
  ;


  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'.  Metodologia para execução da proposta</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->metodologia .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'.  Contribuição científica, tecnológica e de Inovação</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->contribuicao .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Cronograma da proposta</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->cronograma .'</td></tr></tbody>
  </table>'
  ;

  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Observações</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->obs .'</td></tr></tbody>
  </table>'
  ;


  $html .= 
  '<table class="time">
   <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Referências</strong></th></tr></thead>
  <tbody><tr><td>'. $obProjeto->referencia .'</td></tr></tbody>
  </table>'
  ;


use \App\Entity\Arquivo;
$anexados = Arquivo::getAnexados('projetos', $obProjeto->id);
$anex = '<ul id="anexos_edt">';
$conutAnexo = 0;
foreach($anexados as $att){
  $anex .= 
  '<li>
    <a href="https://sistemaproec.unespar.edu.br/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a>   
  </li> ';
  $conutAnexo++;
}
if ($conutAnexo == 0) {
  $anex = 'Sem anexos';
} else {
  $anex .= '</ul>';
}
/*
 
<a href="https://sistemaproec.unespar.edu.br/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a>
 
https://sistemaproec.unespar.edu.br/sistema/upload/uploads/
  
 */

$html .= 
'<table class="time">
 <thead><tr><th class="th_cinza"><strong>'. ++$count .'. Anexos</strong></th></tr></thead>
<tbody><tr><td>'. $anex .'</td></tr></tbody>
</table>'
;





 $html .= '</body>
 <script>

 function printIT(){
    window.print();
 }

  </script>
 </html>';



/*  
 
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
//$dompdf->stream($filename->codigo .".pdf");
$dompdf->stream($filename->codigo,array('Attachment'=>0));

//hash_file('md5', $dompdf->stream('file'));
*/


echo $html;


/*/