<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
use App\Entity\Relatorio;

$r = $_GET['r'];

$relats = Relatorio::getByIdBasic($r);

echo json_encode($relats);
