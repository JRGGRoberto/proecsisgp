<?php
// API para utilizar a função '../includes/funcoes/func_recuperarDadosPessoas.php'
// Utilizada para requisições via $_GET

header('Content-Type: application/json');
include '../includes/funcoes/func_recuperarDadosPessoas.php';
$dados = recuperarDadosPessoas($_GET);
echo json_encode($dados);

