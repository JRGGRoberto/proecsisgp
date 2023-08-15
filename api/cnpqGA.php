<?php

require '../vendor/autoload.php';

use \App\Session\Login;
Login::requireLogin();

use \App\Entity\CnpqGArea;
$order = 'nome';

$registros = CnpqGArea::getRegistros($order);
echo json_encode($registros);
