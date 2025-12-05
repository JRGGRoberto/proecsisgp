<?php

require '../vendor/autoload.php';


use \App\Session\Login;
use \App\Entity\Projeto;
use App\Entity\Palavras;

//Obriga o usuário a estar logado
Login::requireLogin();

$user = Login::getUsuarioLogado();


//VALIDAÇÃO DO ID
if(!isset($_POST['modIDprj'], $_POST['modVerPrj'], $_POST['selecOpt'], $_POST['modCreated'])){
   header('location: index.php?status=error');
  exit;
}

//CONSULTA REGISTRO
$obProjeto = Projeto::getProjeto($_POST['modIDprj'],  $_POST['modVerPrj']);


//VALIDAÇÃO DA Campus
if(!$obProjeto instanceof Projeto){
  header('location: index.php?status=error');
  exit;
}

//VALIDANDO SE OS DADOS VIERAM REALMENTE PELO LINK
if($obProjeto->created_at != $_POST['modCreated']){
  echo 'tentando trapassear....';
  header('location: index.php?status=error');
  exit;
}


//VALIDANDO SE O DONO DO PROJETO É  USUÁRIO
if($obProjeto->id_prof != $user['id']){
  echo 'tentando trapassear.... NÃO ÉS O DONO DO PROJETO!!!';
  header('location: index.php?status=error');
  exit;
}

// $obProjeto->regra    =  '6204ba97-7f1a-499e-a17d-118d305bf7e4';

$palavras = Palavras::getPalavrasByProj($obProjeto->id);
$palav1 = $palavras[0]->palavra ?? null;
$palav2 = $palavras[1]->palavra ?? null;
$palav3 = $palavras[2]->palavra ?? null;


$obProjeto->palav1 = $palav1;
$obProjeto->palav2 = $palav2;
$obProjeto->palav3 = $palav3;


// 3 = serviço; 4 = programa; 5 = projeto;
$anxII = [3, 4, 5];
// 1 = curso; 2 = evento;
$anxIII = [1, 2];
// ver qual é o tipo de projeto
$tipo = $obProjeto->tipo_exten;
// iniciar variável
$missing = []; 
            
function isEmpty($value) {
    // null -> vazio
    if ($value === null) return true;
    // arrays/objects -> considera vazio se convertido para array resultar em vazio
    if (is_array($value) || is_object($value)) {
        return empty((array) $value);
    }
    // garante string
    $str = (string) $value;
    // remove tags HTML
    $str = strip_tags($str);
    // decodifica entidades (&nbsp;, &amp;, etc.)
    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    // remove caracteres de controle / ZWSP / BOM
    $str = preg_replace('/[\x00-\x1F\x7F-\x9F\p{Cf}]+/u', '', $str);
    // remove tudo que não for letra ou número (elimina pontuação e espaços)
    // se quiser permitir acentos, \p{L} mantém letras unicode
    $clean = preg_replace('/[^\p{L}\p{N}]+/u', '', $str);
    // trim por precaução
    $clean = trim($clean);

    return $clean === '';
}


if (in_array($tipo, $anxII)) {
  // Campos obrigatórios para tipos 3, 4, 5
  $required = ['id', 'resumo', 'palav1', 'palav2', 'palav3', 'justificativa'];

  foreach ($required as $field) {
    if (isEmpty($obProjeto->$field)) {
      $missing[] = $field;
    }  
  }
} elseif (in_array($tipo, $anxIII)) {
  // Campos obrigatórios para tipos 1, 2
  $required = ['id', 'resumo', 'palav1', 'palav2', 'palav3', 'justificativa'];
  
  foreach ($required as $field) {
    if (isEmpty($obProjeto->$field)) {
      $missing[] = $field;
    }  
  }
}

session_start();
if (!empty($missing)) {
    $_SESSION['missing_fields'] = $missing;
    $pass = 'false';
    header("location: editar.php?id=$obProjeto->id&v=$obProjeto->ver&pass=$pass");
    exit;
}
elseif (empty($missing)){
  $obProjeto->Submeter($_POST['selecOpt']);
  header('location: index.php?status=success');
  exit;
}
