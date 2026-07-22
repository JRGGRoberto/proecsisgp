<?php
// Usado para verificar se tem usuário já cadastrado com os seguintes dados:
//    EMAIL e CPF
// Para utilizar é necessário passar o tipo (ex: email) e o valor (ex: xpto@unespar.edu)

require_once '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();

use App\Entity\Professor;

// Verificar duplucidade Dados
function verificarDuplicidadeDados($tipoDados, $valorDados){
    
    if ($tipoDados == 'email'){
        $campo = 'email';
    }
    elseif ($tipoDados == 'cpf'){
        $campo = 'cpf';
    }else {
        return;
    }

    $where = $campo.' = "'.$valorDados.'"';
    $duplicate = Professor::getProfessores($where);

    if (!$duplicate){
        $return = true; // Pode cadastrar
    } else {
        $return = false; // Não pode cadastrar
    }

    return $return;
}

// $abc = verificarDuplicidadeDados('cpf','419.652.840-60');
// echo '<pre>';
// print_r($abc);
// exit;
// echo '</pre>';