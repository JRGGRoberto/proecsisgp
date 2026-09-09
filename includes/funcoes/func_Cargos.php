<?php

// Verifica cargos que tem uma complexidade de validação

// Passa o usuário e verifica se tem cargo Adm Full
function verificarCargosAdmin($user)
{
    $user = (array) $user;
    require_once '../includes/funcoes/func_permissoes.php';
    $permissoesADM = permissoesADM();

    $validade = 0;
    // Aqui vê se a pessoa é cargo especial
    // Se ela for, vê se o cargo dela permite acessar
    if ($user['CargoEspecial'] != '0') {
        if (empty($cargosEspeciais)) {
            $validade = 1;
        }
    }

    // Aqui vê se a pessoa é ADM
    // Se ela for, vê se está no array de permissão
    if ($user['adm'] == 1) {
        if (in_array($user['id'], $permissoesADM)) {
            $validade = 1;
        }
    }

    return $validade;
}
