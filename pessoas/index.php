<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

include_once '../includes/funcoes/func_verificaCargosEspeciais.php';
$cargosEspeciais = dadosCargosEspeciais($user['CargoEspecial']);

$parametro = null;

// Aqui redireciona para a home se não for permitido
function redirect(){
    header("Location: ../home");
    exit;
}

require_once '../includes/funcoes/func_Cargos.php';

// Aqui vê quem pode entrar na parte de avaliação
if ($_GET['tipo'] === 'avalia' || $_GET['tipo'] === 'historico') {
    $validade = verificarCargosAdmin($user);
    if($validade == 1){
        $parametro = 'adminPessoas/analisaCadastro.php';
    }
    else{   
        redirect();
    }
// Aqui vê quem pode entrar no cadastro
} else {
    if ($_GET['tipo'] === 'cadastro'){
        switch ($_GET['cargo'] ?? '') {
            // Cadastro de Agentes
            case 'ag':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 3){
                    $parametro = 'cadastroPessoas/cadastroAg.php';
                }
                else {
                    redirect();
                }
                break;
            // Cadastro de Professores
            case 'pf':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 1){
                    $parametro = 'cadastroPessoas/cadastroPf.php';
                }
                else {
                    redirect();
                }
                break;
        }
    }
    elseif ($_GET['tipo'] === 'desativacao'){
        switch ($_GET['cargo'] ?? '') {
            // Desativação de Agentes
            case 'ag':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 3){
                    $parametro = 'ativacaoPessoas/desativacaoAg.php';
                }
                else {
                    redirect();
                }
                break;
            // Desativação de Professores
            case 'pf':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 1){
                    $parametro = 'ativacaoPessoas/desativacaoPf.php';
                }
                else {
                    redirect();
                }
                break;
        }
    }
    elseif ($_GET['tipo'] === 'reativacao'){
        switch ($_GET['cargo'] ?? '') {
            // Reativação de Agentes
            case 'ag':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 3){
                    $parametro = 'ativacaoPessoas/reativacaoAg.php';
                }
                else {
                    redirect();
                }
                break;
            // Reativação de Professores
            case 'pf':
                $validade = verificarCargosAdmin($user);
                if ($validade == 1 || $user['config'] == 1){
                    $parametro = 'ativacaoPessoas/reativacaoPf.php';
                }
                else {
                    redirect();
                }
                break;
        }
    }
}

// Isso aqui é se o usuário for permitido
// ele retorna pra página certa (Adm) QryString
if($validade===1){
    $true = '=true';
}else{
    $true = null;
}

// scripts que são usados para mais de uma parte que sai do index..
$CAop = '';
$CEop = '';
$COop = '';

// Abertura do JS
// Está assim pq tem JS que só entra se atender o IF
$script = '<script>';

if(isset($_GET['valida']) && $_GET['valida'] == 'true'){
    $valida = 'true';
}else{
    $valida = null;
}

if ($user['config'] == 1 && $validade != 1){
    $CAop = "<option value='".$user['ca_id']."'>".$user['ca_nome'].'</option>';
    $CEop = "<option value='".$user['ce_id']."'>".$user['ce_nome'].'</option>';
    $COop = "<option value='".$user['co_id']."'>".$user['co_nome'].'</option>';
}
elseif ($user['config'] == 3 && $validade != 1){
    $CAop = "<option value='".$user['ca_id']."'>".$user['ca_nome'].'</option>';
}
elseif ($validade == 1 && $valida == 'true'){
    $script .= 'pegarCA();';
}

// JS para filtros
$script .= 'aplicarValidacaoCadastroPessoa("cadastro", "s");';
$script .= 'aplicarValidacaoLink("cadastro","lattes");';
$script .= 'aplicarValidacaoLink("cadastro","portaria");';
$script .= '</script>';

include_once '../includes/header.php';
include $parametro;
include '../includes/footer.php';