<?php

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

/*
<a href="../projetos/index.php" class="btn btn-primary btn-sm float-right">Meus projetos/propostas</a>
header('location: ../projetos/index.php');
  exit;
*/
include './todosProjetos.php';
include './projetosUsuario.php';
include './avaliacaoUsuario.php';
include './relatoriosPublicados.php';

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';

