<?php

require '../vendor/autoload.php';

use \App\Entity\Projeto;
use \App\Entity\Colegiado;

$col = Colegiado::getRegistro('c3bc22e0-3b64-11ed-9793-0266ad9885af');
echo '<pre>';
print_r($col);
echo '</pre>';

echo $col->nome;

exit;


$id = 'f86a60cc-33cc-4103-9c99-b2cfcf905801';
$ver = 4;

$proj = Projeto::getProjeto($id, $ver);

include '../includes/header.php';

echo '<pre>';
echo $proj->titulo;
echo ' | ver: ';
echo $proj->ver;




echo '<hr>';
print_r($proj);

echo '<hr>';
//$projDel = Projeto::getProjeto($id, 3);
//$projDel->excluir();
echo '<hr>';



echo '</pre>';

include '../includes/footer.php';

