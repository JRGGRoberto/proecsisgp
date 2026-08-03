<?php
// API para utilizar a função '../includes/funcoes/func_verificarExistenciaPessoas.php'
// Utilizada para verificaçoes via JS
// Retorna true ou false

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();

$tipoDados = $_GET['tipoDados'];
if (!in_array($tipoDados, ['cpf', 'email'])) {
    http_response_code(400);
    exit;
}

$valorDados = $_GET['valorDados'];

header('Content-Type: application/json');
include '../includes/funcoes/func_verificarDuplicidadeDados.php';
$duplicado = verificarDuplicidadeDados($tipoDados, $valorDados);

// Se for usar esse código para contexto de cadastro de pessoas
// em verificação se há números duplicados...
echo json_encode($duplicado);
// 1 = Pode cadastrar
// 0 = Não pode cadastrar