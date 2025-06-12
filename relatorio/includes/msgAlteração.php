<?php
require '../vendor/autoload.php';
use App\Entity\Outros;
$qry =
'select 
  DATE_FORMAT(h.created_at,"%d/%m/%Y") em,  u.nome, h.ava_comentario, h.etapa, f.etapas
from 
  hist_relatorios h
  inner join relatorios f 
    on 
       f.id  = h.id_relatorio and 
       f.etapa  = h.etapa  
--       and     f.id = "'. $id .'"
  inner join usuarios u  on u.id =  h.user 
order by h.created_at desc limit 1';

$msgALT = Outros::q($qry);

 $msgSolicitacoAlteracao = '
  <div class="alert alert-danger">
    <strong>O relatório foi avaliado e retornado com solicitações de alteração</strong> </p>
    <p>Em '.$msgALT->em.', '.$msgALT->nome.' solicitou a(s) seguinte(s) alteração(ões)</p>
    <p>Você pode editar o relatório e reenviar para avaliação</p>
        <div class="alert alert-warning">
          <strong>Solicitações:</strong> 
          <p>'.$msgALT->ava_comentario.'</p>
        </div>
    <strong>Etapa '.$msgALT->etapa.' de '.$msgALT->etapas.'</strong> Depois da alteração, você deve reenviar o relatório para avaliação</p>
  </div>';

