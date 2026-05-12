<?php
// Utilizadas na propostas/includes/ca_ce_co.php
// Para utilizar é necessário passar os parâmetros via $_GET podendo acrescentar no IF

require '../vendor/autoload.php';

use \App\Session\Login;
Login::requireLogin();

use \App\Entity\Ca_Ce_Co;

if (!empty($_GET['co'])){
    $where = 'co_id = "'.$_GET['co'].'"';
} elseif (!empty($_GET['ca'])){
    $where = 'ca_id = "'.$_GET['ca'].'"';
}
// $fields = "ca_id, campus";
$fields = "ca_id, co_id";

$local = Ca_Ce_Co::getRegistros($where,'','',$fields);

echo json_encode($local);
