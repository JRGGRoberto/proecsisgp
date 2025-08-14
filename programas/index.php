<?php

require '../vendor/autoload.php';
use App\Entity\Outros;

$qry =
'
select 
   prog,  campus,  COUNT(1) qnt,  aberto
from 
  divulga_proj 
where aberto = 1
group by 1, 2 
order by 1, 2;

';

$lista = Outros::qry($qry);

$prog = '';
$txt = '';

foreach ($lista as $item) {
    if ($prog != $item->prog) {
        $txt .= '<h4> - '.$item->prog.'</h4>';
        $prog = $item->prog;
    }
    //  $txt .= '   <p>  '.$item->campus.'  ['.$item->qnt.']</p>';
}

$ip = 'ααα.ABC.XYZ.ΩΩΩ';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

include '../includes/headersCl.php';
include __DIR__.'/includes/acesso.php';
include '../includes/footer.php';
