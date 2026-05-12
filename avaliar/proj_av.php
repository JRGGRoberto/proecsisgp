<?php
 
require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Diversos;
use \App\Entity\Avaliar;
use \App\Entity\Arquivo;
use \App\Entity\Parecer;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($user['is_admin'] != 1 ){
  header('location: ../index.php?status=error');
  exit;
}

$bossM = Diversos::getResponsavelLocal($user['id']);

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

if($user['is_admin'] != 1 ){
  header('location: ../index.php?status=error');
  exit;
}
$bossM = Diversos::getResponsavelLocal($user['id']);
$proj = Diversos::projetosView($_GET['id']);


$qryPublic = "
select 
  if (max(id_instancia) = 3, 4, ". $bossM->nivel_adm .") instan
from avaliacoes a 
where 
  a.id_proj = ". $proj->id_proj."
  and a.resultado = 'a' ";

$toPublic = Diversos::q($qryPublic);

$optLista = '';
$parecer = Parecer::getRegistro($proj->id_proj);

$callParecer = false;
$noParecer = [1, 3];
if (in_array($bossM->nivel_adm, $noParecer)){
  $callParecer = false;
} elseif($bossM->nivel_adm == 2) {
  $parecer = Parecer::getRegistro($proj->id_proj);
  if(isset($parecer)){

    $listaParecerists = Diversos::SelInvidProfToParecer($bossM->id_campus, $proj->id_proj);
    foreach($listaParecerists as $op){
      $optLista .= '<option value="'.$op->id_prof.'" '.$op->sel.'>'.$op->nome.'</option>';
    }
    $callParecer = true;
  }
}

if(!empty($parecer)){
    $anexados = Arquivo::getAnexados('pareceres', $parecer->id);
    $anex_C = '<ul id="anexos_edt">';
    foreach($anexados as $att){
      $anex_C .= 
      '<li>
          <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
      </li> ';
    }
    $anex_C .= '</ul>';
  } else {
    $anex_C = '';
  }

$tabela;
if(isset($_POST['resultado']) ){
  $ori = $_POST['origem'];
  $id;
  if($ori == 'avaliar'){
    $avaliar = new Avaliar;
    $avaliar->id_proj      = $proj->id_proj;
    if($bossM->nivel_adm == 1){
      $avaliar->id_instancia = $toPublic->instan;
    } else {
      $avaliar->id_instancia = $bossM->nivel_adm;
    }
    
    $avaliar->id_avaliador = $bossM->id_avaliador;
    $avaliar->resultado    = $_POST['resultado'];
    $avaliar->resu_ata     =  $_POST['resu_ata'];
    $avaliar->user       = $bossM->id_prof;
    $tabela = 'avaliacoes';
    $id = $avaliar->cadastrar();
  } elseif($ori == 'invite') {
      $invPar = new Parecer;
      $invPar->id_proj = $_POST['id_proj'];
      $invPar->id_prof = $_POST['resultado'];
      $invPar->user   = $bossM->id_prof;
      $invPar->solicitant_id = $bossM->id_prof;
      $tabela = 'pareceres';
      $id = $invPar->Cadastrar();
  }
  $arqs = $_POST['anexos'];

  foreach($arqs as $arq){
    $dados = Arquivo::getArquivo($arq);
    $dados->tabela = $tabela;
    $dados->id_tab = $id  ;
    $dados->user = $user['id'];
    $dados->atualizar();
  }

  header('location: ./index.php?status=success');
  exit;
}
  
include '../includes/header.php';


include 'dproj_ava_par.php';



if($callParecer){
  if(!empty($parecer)){
    if(!empty($parecer->parecer)){
     // echo $infoPar;
      include __DIR__.'/includes/avaliar.php';
    } else {
      echo '
        <section>
          <hr>
          <h5>Em '. date('d/m/Y',strtotime($parecer->dt_av)). ', foi solicitado a parecer do Professor(ª) '.
              $parecer->nome_parecerista.'.<br>Favor aguardar o parecer.
          </h5>
          <hr><p></p>  <p></p> <p></p> <p></p>
        </section>';
      echo 'não dado';
    }  
  } else {
    include __DIR__.'/includes/invite.php';
    echo '<section></section><p>
    
    <p>&nbsp</p>
    <p><hr></p>
  </p>';
  }
  
} else {
  include __DIR__.'/includes/avaliar.php';
}

echo '<p>&nbsp</p>';
include '../includes/footer.php';