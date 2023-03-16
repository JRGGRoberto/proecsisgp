<?php

require '../vendor/autoload.php';

use \App\Entity\Projeto;

$projetos = Projeto::getRegistros();

echo '<pre>';
print_r($projetos);
echo '<hr>';


$prj = Projeto::getProjetoView('8b2c5fee-5d62-4a1a-97dc-8f33209b9ee7', 0);

print_r($prj);

echo '<hr>';

$aa = $prj->ultimaInstancia();

print_r ($aa);

echo '</pre> <hr>';




