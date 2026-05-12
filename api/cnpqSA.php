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
    'id' => '1',
    'id_area' => $ar,
    'id_avalia' => '0000',
    'nome' => ' N/A',
    'created_at' => '2023-08-09 11:49:12',
    'updated_at' => '',
    'user' => '0'
];
array_unshift($registros, $ElementoNA);

echo json_encode($registros);
