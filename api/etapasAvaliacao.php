<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
use App\Entity\Outros;

$regra = $_GET['r'];

$qryEtapas = "
SELECT  
  rd.nome as nome,
  case tp_avaliador 
     when 'ca' then 'Chefe de Divisão'
     when 'ce' then 'Diretor(ª) de Centro de Área'
     when 'co' then 'Coordenador(ª) de colegiado'
     when 'pf' then 'Professor(ª)'
     when 'dc' then 'Diretor de Campus'
     else 'Agente' end as avaliador,
  rd.sequencia , form 
FROM regras_defin rd  
WHERE  
 id_reg = '".$regra."'
 order by sequencia 
";

$etapas = Outros::qry($qryEtapas);

echo json_encode($etapas);
