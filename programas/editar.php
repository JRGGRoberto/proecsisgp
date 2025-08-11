<?php

require '../vendor/autoload.php';

use App\Entity\Professor;

define('TITLE', 'Editar dados ');

// CONSULTA AO PROJETO
$obProfessor = new Professor();
$obProfessor = $obProfessor::getProfessor($_GET['id']);

// VALIDAÇÃO DA TIPO
/*if (!$obProfessor instanceof Professor) {
    header('location: ../index.php?status=error');
    exit;
}*/

// VALIDAÇÃO DO POST
if (isset($_POST['nome'])) {
    // $obProfessor->id = $_POST['id'];
    // $obProfessor->nome = strtoupper($_POST['nome']);
    $obProfessor->cpf = $_POST['cpf'];
    $obProfessor->telefone = $_POST['telefone'];
    $obProfessor->lattes = $_POST['lattes'];
    $obProfessor->titulacao = $_POST['titulacao'];
    $obProfessor->email = $_POST['email'];
    $obProfessor->id_colegiado = $_POST['id_colegiado'];
    $obProfessor->cat_func = $_POST['cat_func'];
    $obProfessor->ativo = $_POST['ativo'];
    if ($obProfessor->niveln > 0) {
        $obProfessor->ativo = 1;
    }
    $obProfessor->adm = $_POST['adm'];
    $obProfessor->updated_at = date('Y-m-d H:i:s');
    $obProfessor->user = $_POST['user'];
    if (strlen($_POST['senha']) > 0) {
        $obProfessor->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    }
    $obProfessor->atualizar();

    header('location: index.php?status=success');
    exit;
}
function validaMail1($email)
{
    $conta = explode('@', $email);

    return $conta[1] == 'unespar.edu.br' ? ['✅', 'readonly'] : ['<span class="badge badge-danger">Deve ser uma conta <strong>@unespar.edu.br</strong></span>', ''];
}
$infoMail = validaMail1($obProfessor->email);

include '../includes/headersCl.php';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';
