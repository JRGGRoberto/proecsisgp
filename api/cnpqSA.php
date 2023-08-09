<?php

require '../vendor/autoload.php';

use \App\Session\Login;
Login::requireLogin();

use \App\Entity\CnpqSubA;

$ar = $_GET["ar"];
$where = ' id_area = '.$ar;
$order = 'id';

$registros = CnpqSubA::getRegistros($where, $order);
echo json_encode($registros);
