<?php

require '../vendor/autoload.php';
use App\Session\Login;

Login::requireLogin();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Entity\Projeto;

$user = Login::getUsuarioLogado();

$id = $_GET['id'];
$ver = $_GET['v'];

$obProjeto = Projeto::getProjeto($id, $ver);
$ini = '2026-03-02 00:00:00';
$fim = '2026-03-04 00:00:00';
$obProjeto->para_avaliar = 'c3bd0ba4-3b64-11ed-9793-0266ad9885af';
$obProjeto->renovacao($ini, $fim);
echo 'ok';
/*

select * from projetos where id  = 'c2a0cb6f-d0e4-4014-bcfa-6cb8c76dc2ca'





echo '<pre>';
print_r($obProjeto);
echo '</pre>';
http://localhost/proecsisgp/projetos/do.php?id=abac47b7-e625-11ee-b2c8-0266ad9885af&v=0

*/
