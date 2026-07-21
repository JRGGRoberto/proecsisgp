<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

require_once '../includes/funcoes/func_permissoes.php';
$permissoesADM = permissoesADM();

require_once '../includes/funcoes/func_verificaCargosEspeciais.php';
$cargosEspeciais = dadosCargosEspeciais($user['CargoEspecial']);

$parametro = null;

// Aqui redireciona para a home se não for permitido
function redirect(){
    header("Location: ../home");
    exit;
}

function verificarCargo($user, $permissoesADM){
    $validade =  0;

    // Aqui vê se a pessoa é cargo especial
    // Se ela for, vê se o cargo dela permite acessar
    if ($user['CargoEspecial'] != '0'){
        if(empty($cargosEspeciais)){
            $validade = 1;
        }
    }

    // Aqui vê se a pessoa é ADM
    // Se ela for, vê se está no array de permissão
    if ($user['adm'] == 1) {
        if(in_array($user['id'],$permissoesADM)){
            $validade = 1;
        }
    }

    return $validade;
}

// Aqui vê quem pode entrar na parte de avaliação
if (($_GET['solicitacao'] ?? '') === 'avalia') {
    $validade = verificarCargo($user, $permissoesADM);
    if($validade == 1){
        $parametro = 'analisaCadastro.php';
    }
    else{   
        redirect();
    }
// Aqui vê quem pode entrar no cadastro
} else {
    switch ($_GET['cargo'] ?? '') {
        // Cadastro de Agentes
        case 'ag':
            $validade = verificarCargo($user, $permissoesADM);
            if ($validade == 1 || $user['config'] == 3){
                $parametro = 'cadastroAg.php';
            }
            else {
                redirect();
            }
            break;
        // Cadastro de Professores
        case 'pf':
            $validade = verificarCargo($user, $permissoesADM);
            if ($validade == 1 || $user['config'] == 1){
                $parametro = 'cadastroPf.php';
            }
            else {
                redirect();
            }
            break;
    }
}
// -----------------------------------------------
$CAop = '';
$CEop = '';
$COop = '';

// Abertura do JS
// Está assim pq tem JS que só entra se atender o IF
$script = '<script>';

if ($user['config'] == 1){
    $CAop = "<option value='".$user['ca_id']."'>".$user['ca_nome'].'</option>';
    $CEop = "<option value='".$user['ce_id']."'>".$user['ce_nome'].'</option>';
    $COop = "<option value='".$user['co_id']."'>".$user['co_nome'].'</option>';
}
elseif ($user['config'] == 3){
    $CAop = "<option value='".$user['ca_id']."'>".$user['ca_nome'].'</option>';
}
elseif ($validade == 1 && ($user['config'] != 1 || $user['config'] == 3)){
    $script .= 'pegarCA();';
}

// JS para filtros
$script .= 'aplicarValidacaoEmail("cadastro");';
$script .= 'aplicarValidacaoCPF("cadastro");';
$script .= 'aplicarValidacaoLink("cadastro","lattes");';
$script .= 'aplicarValidacaoLink("cadastro","portaria");';
$script .= '</script>';

include '../includes/header.php';
include $parametro;
include '../includes/footer.php';