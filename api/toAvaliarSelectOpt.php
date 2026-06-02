<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\Outros;

$qryOptions = '';
if ($user['tipo'] == 'prof') {    // echo 'prof';
    $qryOptions = "
        select 
          ccc.co_id as id, 
          ccc.colegiado as nome,
          IFNULL(ccc.coord_id, 'disabled') coord,
          if(col.id is not null, '1', '') selected
        from 
          ca_ce_co ccc 
          left join (select '".$user['co_id']."' id) col on col.id = ccc.co_id 
        where ccc.ca_id  =  '".$user['ca_id']."'
      ";
    $options = Outros::qry($qryOptions);
} elseif ($user['tipo'] == 'agente') {    // echo 'agente';
    $options = [
        'id' => $user['ca_id'],
        'nome' => $user['ca_nome'],
        'coord' => 'xpto14',
        'selected' => 'selected',
    ];
} else {
    return null;
    // error!!!!
}

echo json_encode($options);
