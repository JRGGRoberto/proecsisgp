<?php
 
require '../vendor/autoload.php';

use \App\Entity\Avaliar;
use \App\Entity\Arquivo;
use \App\Entity\Parecer;


$avaliacoes = Avaliar::getRegistros('id_proj = ' . $proj->id_proj);

$anexados = Arquivo::getAnexados('projetos', $proj->id_proj);
$anex = '<ul id="anexos_edt">';
foreach($anexados as $att){
  $anex .= 
  '<li>
      <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
  </li> ';
}
$anex .= '</ul>';


$ava = '
<div class="container">
  <h2>Avaliações</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Instância</th>
        <th>Despacho</th>
        <th>Resultado</th>
        <th>Anexos</th>
        <th>Data</th>
      </tr>
    </thead>
    <tbody>';
    
    $status = '';


    foreach($avaliacoes as $h){

      $anexados = Arquivo::getAnexados('avaliacoes', $h->id);
      $anex_A = '<ul id="anexos_edt">';
      foreach($anexados as $att){
        $anex_A .= 
        '<li>
            <a href="../upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
        </li> ';
      }
      $anex_A .= '</ul>';


      if($h->resultado == 'a' and $h->id_instancia == 4){
        $status = '<span class="badge badge-success">Publicado</span>';
      }


      $res = '';
      switch ($h->resultado){
        case 'a': $res = 'Aprovado'; break;
        case 'r': $res = 'Não aprovado'; break;
        case 'p': $res = 'Com pendências'; break;
      }
      $inst = '';
      switch ($h->id_instancia){
        case 1: $inst =  'Divisão'; break;
        case 2: $inst =  'Coordenação'; break;
        case 3: $inst =  'Centro de área'; break;

      }
      $ava .=  '<tr>';
      $ava .=  '    <td>'. $inst .      '</td>';
      $ava .=  '    <td>'. $h->resu_ata .'</td>';
      $ava .=  '    <td>'. $res .'</td>';
      $ava .=  '    <td>'. $anex_A .'</td>';
      $ava .=  '    <td>'. $h->dt_av .   '</td>';
      $ava .=  '</tr>';
    }

    
$ava .= '

    </tbody>
  </table>
</div>'.$status;

$parecer = Parecer::getRegistro($proj->id_proj);


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
  
  
  if($parecer->parecer == 'a'){
    $resP = '<span class="badge badge-success">Favorável</span>'  ;
  }
  if($parecer->parecer == 'r'){
    $resP = '<span class="badge badge-warning">Não favorável</span>' ; 
  }
  
  
  $infoPar = '<hr>
       <h4>Parecer</h4>
       <div class="row">
         <div class="col">
          <div class="form-group">
          <p>
          Data de solicitação: '. date('d/m/Y',strtotime($parecer->dt_av)). '<br>
          Professor(ª) parecerista: '. $parecer->nome_parecerista.'<br>
          Data do parecer: '.date('d/m/Y',strtotime($parecer->updated_at)). '<br>
          Parecer: '. $parecer->resu_ata.'.<br> 
          Resultado: '. $resP.'
         </p>
          </div>
        </div>
  
        <div class="col">
          <div class="form-group">
            Anexos<br>
            '.$anex_C.'
          </div>
        </div>
      </div>
        <hr>';
} else {
  $infoPar = ' ';
}  

include __DIR__.'/includes/dadosproj.php';

echo '
<hr>
<section>
'. $ava .'
'. $infoPar.'
<p></p>
<p>&nbsp</p>

</section>';
