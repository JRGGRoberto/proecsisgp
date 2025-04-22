<?php

require '../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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


$QntRelParcial =  RelParcial::getQntd('idproj = "'.$id.'"' );

$QntRelFinalFinal = RelFinal::getQntd('idproj = "'.$id.'"  and tipo = "f" '); 
$QntRelFinalProrr = RelFinal::getQntd('idproj = "'.$id.'"  and tipo = "p" ');
$QntRelFinalRenov = RelFinal::getQntd('idproj = "'.$id.'"  and tipo = "r" ');
$QntREL =  $QntRelParcial + $QntRelFinalFinal + $QntRelFinalProrr + $QntRelFinalRenov;

/*
echo '<pre>';
echo 'QntRelParcial: '.$QntRelParcial;
echo '<br>';
echo 'QntRelFinalFinal: '.$QntRelFinalFinal;
echo '<br>';
echo 'QntRelFinalProrr: '.$QntRelFinalProrr;
echo '<br>';
echo 'QntRelFinalRenov: '.$QntRelFinalRenov;
echo '</pre>';
*/

;

$relParcial = RelParcial::gets('idproj = "'.$id.'"' );
$RelFinal = RelFinal::gets('idproj = "'.$id.'"' );


$showBTNS_parcial_final = false;
if($QntREL == 0){  // Não tem nenhum relatórios
    $showBTNS_parcial_final = true;
} else {
    if(($QntRelFinalFinal > 0) or ($QntRelFinalRenov > 0)){   // se tem relatório final Não mostar btns para criar
        $showBTNS_parcial_final = false;
    } elseif   ($QntRelParcial > 0){ // se tem algum parcial
       foreach($relParcial as $rel){
            if($rel->ava_publicar == 0){
                $showBTNS_parcial_final = false;
                break;
            } else {
                $showBTNS_parcial_final = true;
            }
        }
    }
}

$btnFinalProrrogado = '<a class="dropdown-item btn-sm" href="./cadastrar2.php?t=2&i='. $obProjeto->id. '&f=p">Relatório final com pedido de Prorrogação</a>';
$btnFinalRenova =     '<a class="dropdown-item btn-sm" href="./cadastrar2.php?t=2&i='. $obProjeto->id. '&f=r">Relatório final com pedido de Renovação</a>';

if(($QntRelFinalFinal > 0) or ($QntRelFinalRenov > 0)){
    $btnFinalProrrogado = '';
}



if($showBTNS_parcial_final){
    $novoBTNs = '
      <section>
        <div class="row mt-2 align-bottom">
          <div class="col" >

            <div class="dropup">
              <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
                Novo
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item btn-sm" href="./cadastrar1.php?t=1&i='. $obProjeto->id. '">Relatório parcial</a>'.
                  $btnFinalProrrogado  . $btnFinalRenova 
                  .'<a class="dropdown-item btn-sm" href="./cadastrar2.php?t=2&i='. $obProjeto->id. '&f=f">Relatório final</a>
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
