<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Projeto;
use \App\entity\RelParcial;

$user = Login::getUsuarioLogado();

$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
            break;
    }
}

// VALIDAÇÃO DO ID
if (!isset($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}
$id = $_GET['id'];

// CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);

$relQnt = RelParcial::getQntd('idproj = "'.$id.'"' );

$relatorios = RelParcial::gets('idproj = "'.$id.'"' );

function formatData($data): string
{
    return substr($data,8,2) .'/'. substr($data,5,2).'/'.  substr($data,0,4);
}



$obProjeto->tipo_exten;
$tipo = '';
switch ($obProjeto->tipo_exten) {
  case 1:
      $tipo = 'Curso';
      break;
  case 2:
      $tipo = 'Evento';
      break;
  case 3:
      $tipo = 'Prestação de serviço';
      break;
  case 4:
      $tipo = 'Programa';
      break;
  case 5:
      $tipo = 'Projeto';
      break;
  default:
      $tipo = '';
      break;
      exit;
}


include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
