<?php

require '../vendor/autoload.php';
use App\Entity\Projeto;

$prj = new Projeto();
$prj = Projeto::getProjeto('abb18eaf-e625-11ee-b2c8-0266ad9885af', 0);

$ini = '2025-06-16';
$fim = '2027-06-16';
if ($prj->renovacao($ini, $fim)) {
    echo 'ok';
} else {
    echo 'não foi';
}
