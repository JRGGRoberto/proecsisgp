<?php

require '../vendor/autoload.php';

use App\Entity\Usuario;
use App\Session\Login;

function validaMail($email)
{
    $conta = explode('@', $email);

    return $conta[1] == 'unespar.edu.br' ? strtolower($conta[0]) : false;
}

if (isset($_POST['email'])) {
    validaSemLDAP:
    $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

    if (!$obUsuario instanceof Usuario || !password_verify($_POST['senha'], $obUsuario->senha)) {
        $alertaLogin = 'E-mail ou senha inválidos';
        goto montaTela;
    }

    if ($obUsuario->ativo != 1) {
        $alertaLogin = 'Conta desativada';
        goto montaTela;
    }
    Login::login($obUsuario);
}

montaTela:
include '../includes/headers.php';
include __DIR__.'/includes/formulario-login.php';
include '../includes/footer.php';
