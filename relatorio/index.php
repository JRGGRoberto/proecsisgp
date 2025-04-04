<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Projeto;
use \App\Entity\RelParcial;
use \App\Entity\RelFinal;


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
$novoBTNs = '';

$QntRelFinal = RelFinal::getQntd('id = "'.$id.'"' );
$QntRelParcial = RelParcial::getQntd('idproj = "'.$id.'"' );

$relParcial = RelParcial::gets('idproj = "'.$id.'"' );
$RelFinal = RelFinal::get($id);

$showBTNS = false;
if($QntRelParcial == 0 && $QntRelFinal == 0){  // Não tem nenhum relatórios
    $showBTNS = true;
} else {
    if($QntRelFinal > 0){   // se tem relatório final Não mostar btns para criar
        $showBTNS = false;
    } elseif   ($QntRelParcial > 0){ // se tem algum parcial
       foreach($relParcial as $rel){
            if($rel->ava_publicar == 0){
                $showBTNS = false;
                break;
            } else {
                $showBTNS = true;
            }
        }
    }
}


if($showBTNS){
    $novoBTNs = '
      <section>
        <div class="row mt-2 align-bottom">
          <div class="col" >

            <div class="dropup">
              <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
                Novo
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item btn-sm" href="./cadastrar1.php?t=1&i='. $obProjeto->id. '">Relatório parcial</a>
                  <a class="dropdown-item btn-sm" href="./cadastrar2.php?t=2&i='. $obProjeto->id. '">Relatório final</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    ';
}


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
