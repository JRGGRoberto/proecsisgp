<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if ($user['config'] != 3){
  echo "<script>location.replace('../home');</script>";
  exit;
}

if ($_GET['tipo'] == 'atualizar'){
    header('Location: ../solicitaAlteracao/index.php?tipo=atualizar&solicita=DEC&idLocal='.$_GET['idLocal']);
    exit;
} elseif ($_GET['tipo'] == 'atualizados') {
    header('Location: ../solicitaAlteracao/index.php?tipo=atualizados&solicita=DEC&idLocal='.$_GET['idLocal']);
    exit;
}