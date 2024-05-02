<?php
         /*
if(isset($parecer->parecer)){
  
  echo '<hr><p>Em '. date('d/m/Y',strtotime($parecer->dt_av)). ', foi solicitado a parecer do Professor(ª) '.
  $parecer->nome_parecerista.'.<br>Favor aguardar o parecer.</p><hr>';
} else{
   $res = '';
   if ($parecer->parecer == "a"){
     $res = 'Aceito';
   } else {
    $res = 'Não aceito';
   }
   */

  '; /**
  echo '<hr>
     <h4>Parecer</h4>
     <p>
       Data de solicitação: '. date('d/m/Y',strtotime($parecer->dt_av)). '<br>
       Professor(ª) parecerista: '. $parecer->nome_parecerista.'.<br>
       Data do parecer: '.date('d/m/Y',strtotime($parecer->updated_at)). '<br>
       Parecer: '. $parecer->resu_ata.'.<br> 
       Resultado: '. $res.'
      </p><hr>';

       */
  echo '


    include __DIR__.'/includes/invite.php';