<?php
require '../vendor/autoload.php';

// use \App\Session\Login;
use \App\Entity\Projeto;
use \App\Entity\Professor;
//Login::requireLogin();
//$user = Login::getUsuarioLogado();
use Dompdf\Dompdf;


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
$obProjeto = Projeto::getProjeto($id, $ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);


//VALIDAÇÃO DA TIPO
if(!$obProjeto instanceof Projeto){
  header('location: ../index.php?status=error');
  exit;
}

use \App\Entity\Colegiado;
$coolCur = Colegiado::getRegistro($obProjeto->para_avaliar)->nome;


use \App\Entity\Area_Cnpq;
$areas_cnpq1 = Area_Cnpq::getRegistro($obProjeto->area_cnpq)->nome;


use \App\Entity\Area_temat;
$area_tem1 = Area_temat::getRegistro($obProjeto->area_tema1)->nome;

use \App\Entity\Area_temat2;
$area_tem2 = Area_temat2::getRegistro($obProjeto->area_tema2)->nome;

/*
use \App\Entity\Area_Extensao;
$area_ext = Area_Extensao::getRegistro($obProjeto->id);
*/
use \App\Entity\Arquivo;
$anexados = Arquivo::getAnexados('projetos', $obProjeto->id);
$anex = '<ul id="anexos_edt">';
$conutAnexo = 0;
foreach($anexados as $att){
  $anex .= 
  '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a>    
  </li> ';
  $conutAnexo++;
}
if ($conutAnexo == 0) {
  $anex = 'Sem anexos';
} else {
  $anex .= '</ul>';
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

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="pt-Br" xmlns="http://www.w3.org/1999/xhtml" lang="pt-Br">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Doc</title>
  <style type="text/css">
  @page {
    margin: 1cm 2cm;
  }

  body {
    font-family: sans-serif;
    margin: 4.5cm 0 1.5cm 0;
    text-align: justify;
  }

  #header,
  #footer {
    position: fixed;
    left: 0;
    right: 0;
    font-size: 0.9em;
  }

  #header {
    top: 0;
    height: 100px;
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
    content: "Página " counter(page);
  }

  hr {
    page-break-after: always;
    border: 0;
  }


  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    text-align: center;
  }

  p {
    text-align: center;
  }

.td1 {
  border: 0;
  border-collapse: collapse;
  text-align: center;
}

.time, th, td {
  border: 0.5px solid gray;
  border-collapse: collapse;
  padding: 5px;
}
.time {
  width: 100%;
}

th {
  background-color: #eeeeee;
  font-weight: lighter;
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
  <div id="header">
    <table>
      <tr>
        <td class="td1"><img src="https://sistemaproec.unespar.edu.br/sis/imgs/logo_unespar.png" width="120px"></td>
      </tr>
    </table>
  </div>
  <div id="footer">
    <div class="page-number"></div>
  </div>';

/**
 * Fim cabeçalho
 */


  $acec = $obProjeto->acec == 'S'? '( x ) Sim<br>( <span> </span><span> </span> ) Não<br>' : '( <span> </span><span> </span> ) Sim<br>( x ) Não<br>';
  $vinculo = $obProjeto->vinculo == 'S'? '( x ) Vinculado <span> </span> <span> </span>( <span> </span><span> </span> ) Não vinculado' : '( <span> </span><span> </span> ) Sim<br>( x ) Não';

  $count = 0; 

  

  $html .= '<h4>'. $title .'</h4>';
  $html .= '<h5>'. $title2 .'</h5>';
  $html .= '<p class="c p"><font size="1">*O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão Tramitação: Coordenador -> Divisão de Extensão e Cultura -> Colegiado de Curso -> Conselho de Centro de Área -> Divisão de Extensão e Cultura.</font></p>';
  
  $html .= '<strong>'. ++$count .'. Título da proposta:</strong> '. $obProjeto->titulo .'<br>';
  $html .= '<strong>'. ++$count .'. Coordenador:</strong> '. $obProjeto->nome_prof .'<br>';
  $html .= '<strong>'. ++$count .'. Contato do Coordenador:</strong> <br>';
  $html .= 'Telefone: '. $obProfessor->telefone .' -  Email: '. $obProfessor->email  .'<br>';
  
  $html .= '<strong>'. ++$count .'. Colegiado de Curso:</strong> '. $coolCur .'<br>';
  $html .= '<strong>'. ++$count .'. Campus:</strong> '. $obProfessor->campus .'<br>';
  $html .= '<strong>'. ++$count .'. Tipo de proposta:</strong> <br>';
  $html .= $tpprop;
  $html .= '<strong>'. ++$count .'.  A proposta está vinculada a alguma disciplina do curso de Graduação ou Pós?Graduação (ACEC II):</strong> <br>';
  $html .= $acec;
  $html .= '<strong>'. ++$count .'.  Vinculação à Programa de Extensão e Cultura:</strong> <br>';
  $html .= $vinculo;
  $html .= '<span> </span> <span> </span> <span> </span><strong> Título do Programa de vinculação:</strong> '. $obProjeto->$tituloprogvinc .'<br>';

  $html .= '<strong>'. ++$count .'.  Classificação do Projeto ou Programa.</strong> <br>';

  $html .= $count . '.1. Áreas de Conhecimento CNPq<br>';

  $html .= 'a) Grande Área: '. $areas_cnpq1 .'<br>';
  $html .= 'b) Área: '. $area_tem1 .'<br>';
  $html .= 'c) Subárea: '. $area_tem2 .'<br>';


  use \App\Entity\Area_Extensao;
  $area_ext = Area_Extensao::getRegistro($obProjeto->area_extensao)->nome;
  $linh_ext = Area_Extensao::getRegistro($obProjeto->linh_ext)->nome;

  
  $html .= $count . '.2. Plano Nacional de Extensão Universitária<br>';

  $html .= 'a) Área de Extensão: '. $area_ext  .'<br>';
  $html .= 'b) Linha de Extensão: '. $linh_ext .'<br>';
  
  $dt1 = substr($obProjeto->vigen_ini, 0, 10);
  $dt1 = substr($dt1, 8, 2). '/'.substr($dt1, 5, 2). '/'. substr($dt1, 0, 4);

  $dt2 = substr($obProjeto->vigen_fim, 0, 10);
  $dt2 = substr($dt2, 8, 2). '/'.substr($dt2, 5, 2). '/'. substr($dt2, 0, 4);
  
  $html .= '<strong>'. ++$count .'.  Período de vigência:</strong> <br>';
  $html .= 'Inicial :' . $dt1 . ' a ' . $dt2 . ' <br> ';

  $html .= '<strong>'. ++$count . ' Carga Horária semanal: </strong>'. $obProjeto->ch_semanal;
  $html .= '<span> </span> <span> </span> <span> </span><strong>  TIDE:</strong> ';

  $tide = $obProjeto->tide == 'S'? '( x ) Sim <span> </span> <span> </span>( <span> </span><span> </span> ) Não ' : '( <span> </span><span> </span> ) Sim <span> </span> <span> </span>( x ) Não ';

  $html .= $tide .'<br>*Indicar a CH a ser computada no PAD, cf. regulamento próprio de distribuição de carga horária da Unespar<br>';

  $html .= '<strong>'. ++$count .'.  Dimensão</strong> <br>';
  $html .= 'Publico alvo: '. $obProjeto->public_alvo .'<br>';
  $html .= 'Abrangência: '. $obProjeto->municipios_abr .'<br>';

  $html .= '<strong>'. ++$count .'.  Previsão de Financiamento</strong> <br>';
  $finac = $obProjeto->finac == 'N'? '( x ) Sem Financiamento <span> </span> <span> </span>( <span> </span><span> </span> ) Com Financiamento' : '( <span> </span><span> </span> ) Sem Financiamento <span> </span> <span> </span>( x ) Com Financiamento';
  $html .= $finac . '<br>';

  $html .= 'Órgão de Financiamento: '.$obProjeto->finacorgao.'<br>';
  $html .= 'Valor do Financiamento: '.$obProjeto->finacval.'<br>';

  $html .= '<strong>'. ++$count .'.  Parcerias</strong> <br>';
  $parceria = $obProjeto->parceria == 'S'? '( x ) Sim <span> </span> <span> </span>( <span> </span><span> </span> ) Não' : '( <span> </span><span> </span> ) Sim <span> </span> <span> </span>( x ) Não';
  $html .= $parceria . '<br>';

  $html .= 'Nome(s) da(s) Entidade(s):'.$obProjeto->parcanomes.'<br>';  
  $html .= 'Atribuição(ões) da(s) Entidade(s):'.$obProjeto->parcaatribuic.'<br>'; 


  $html .= '<strong>'. ++$count .'.  Equipe da proposta</strong> <br>';


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
    $html .= 'Trabalho desenvolvido sem equipe. <br>';
  } else {
    $html .= '<table class="time">
  <thead>
    <tr>
      <th>N</th>
      <th>Nome</th>
      <th>Instituição</th>
      <th>Formação</th>
      <th>Função na equipe</th>
      <th>Telefone</th>
    </tr>
  </thead>
    <tbody>';

    $html .= $tblEquipe;

  $html .= '    </tbody>
  </table>';

  }


  

/**
 * $html .= '<p>'..'</p>';
 * Fim conteúdo
 */


 $html .= '</body>
 </html>';

 
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("a_PDF__.pdf");

/*
echo $html;

echo '<pre>';
print_r($obProjeto);
echo '<hr>';
print_r($obProfessor);
echo '</pre>';

$html .= '</body>
</html>';*/