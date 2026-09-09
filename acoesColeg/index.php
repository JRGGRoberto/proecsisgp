<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

$acesso = $user['config'] > 0 || (int) $user['admin'] === 1;

if (!$acesso) {
    echo "<script>location.replace('../home');</script>";
    exit;
}

$CAop = '';
$CEop = '';
$Coop = '';
$ca_id = $user['ca_id'];
$ca_nome = $user['ca_nome'];
$ce_id = $user['ce_id'];
$ce_nome = $user['ce_nome'];
$co_id = $user['co_id'];
$co_nome = $user['co_nome'];

$script = '<script> 
';

if ($user['adm'] == 1) {
    $script .= 'pegarCA();';
} else {
    switch ($user['config']) {
        case 1:
            $CAop = '<option value="'.$ca_id.'">'.$ca_nome.'</option>';
            $CEop = '<option value="'.$ce_id.'">'.$ce_nome.'</option>';
            $Coop = '<option value="'.$co_id.'">'.$co_nome.'</option>';
            $script .= ' verBtn("'.$co_id.'");';
            break;
        case 2:
            $CAop = '<option value="'.$ca_id.'">'.$ca_nome.'</option>';
            $CEop = '<option value="'.$ce_id.'">'.$ce_nome.'</option>';
            $script .= 'pegarCO("'.$ce_id.'");';
            break;
        case 3:
            $CAop = '<option value="'.$ca_id.'">'.$ca_nome.'</option>';
            $script .= 'pegarCE("'.$ca_id.'");';
            break;
        default:
            $script .= 'pegarCA();';
    }
}

$script .= '
</script>';

include '../includes/header.php';
include './includes/selecao.php';
include '../includes/footer.php';
