<?php 

use App\Session\LoginCandidato;

$user = LoginCandidato::getUsuarioLogado();

?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<!--<link rel="stylesheet" href="../includes/bootstrap-4.6.2-dist/css/bootstrap.min.css">
  <script src="../includes/jquery.min.js"></script>
  <script src="../includes/popper.min.js"></script>
  <script src="../includes/bootstrap-4.6.2-dist/js/bootstrap.bundle.min.js"></script>
-->
  <!--

  <link href="../includes/summernote-bs4.min.css" rel="stylesheet">
  <script src="../includes/summernote-bs4.min.js"></script>

-->



<title>SisGP PROEC</title>
  </head>
  <body class="bg-light text-dark">

<nav class="navbar navbar-light p-2"
     style="background-image: linear-gradient(0deg, #002661 6%, #007F3D 7%, #007F3D 9%, #FFFFFF 10%, #FFFFFF 80%, #D8D8D8 98%, #000000 99%);">

    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="container text-center p-3">
            <div class="row">
                <div>
                    <img src="https://sistemaproec.unespar.edu.br/sistema/imgs/logo_unespar.png"
                         class="d-inline-block align-top"
                         alt=""
                         loading="lazy"
                         width="64"
                         height="68">
                </div>

                <div class="col">
                    <div class="text-left">
                        Pró-Reitoria de
                    </div>

                    <div class="text-left">
                        <a href="./home.php" style="color: #002661;">
                            <strong>Extensão e Cultura - PROEC</strong>
                        </a>
                    </div>

                    <div class="text-left">
                        Universidade Estadual do Paraná
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-group btn-group-sm">

            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                📋 Inscrições
            </button>

            <div class="dropdown-menu">
                <a class="dropdown-item btn-sm" href="./inscricoes.php">
                    Minhas inscrições
                </a>
            </div>

        </div>

        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                👤 <?= explode(' ', trim($user['nome']))[0]; ?>
            </button>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item btn-sm" href="./editar.php">Perfil</a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item btn-sm" href="../programas">Sair</a>
            </div>
        </div>
    </div>

</nav>
