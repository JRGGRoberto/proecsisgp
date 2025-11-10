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
$ini = '2024-04-02 00:00:00';
$fim = '2026-04-02 00:00:00';
$obProjeto->para_avaliar = 'c3bd1034-3b64-11ed-9793-0266ad9885af';
$obProjeto->renovacao($ini, $fim);
echo 'ok';
/*
echo '<pre>';
print_r($obProjeto);
echo '</pre>';
http://localhost/proecsisgp/projetos/do.php?id=abac47b7-e625-11ee-b2c8-0266ad9885af&v=0

*/
