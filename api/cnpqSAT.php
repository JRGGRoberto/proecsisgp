<?php

require '../vendor/autoload.php';

use \App\Session\Login;
Login::requireLogin();

use \App\Entity\CnpqSubA;

$ar = $_GET["ar"];
$where = ' id_area = '.$ar;
$order = 'nome';

$registros = CnpqSubA::getRegistros($where, $order);

$ElementoNA = [            
    'id' => '00000001',
    'id_area' => '10300007',
    'id_avalia' => '0000',
    'nome' => ' N/A',
    'created_at' => '2023-08-09 11:49:12',
    'updated_at' => '',
    'user' => '0'
];
array_unshift($registros, $ElementoNA);

echo '<pre>';
print_r($registros);
echo '</pre>';
echo '<hr>';



exit;
echo json_encode($registros);
