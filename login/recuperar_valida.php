<?php

require '../vendor/autoload.php';

use App\Entity\Agente;
use App\Entity\EmailService;
use App\Entity\Outros;
use App\Entity\Professor;

$email = $_POST['email'];

$sql = "
    select 
        *
    from 
        usuarios 
    where 
        email = '".$email."'
";

$usuarioCadastrado = Outros::qry($sql);

$tipo = $usuarioCadastrado[0]->tipo;
$ativo = $usuarioCadastrado[0]->ativo;

// echo "<pre>";
// print_r ($candidato);
// echo '</pre>';
// exit;

if ($usuarioCadastrado) {
    $novaSenha = substr(md5(uniqid()), 0, 8);
    $where = "email = '".$email."'";

    $email = new EmailService();

    if ($tipo == 'prof') {
        // echo 'Nova senha: '.$novaSenha.'';
        $obProfessor = new Professor();
        $prof = $obProfessor->getProfessores($where);

        // echo "<pre>";
        // print_r ($prof[0]->email);
        // echo '</pre>';
        // exit;

        $prof[0]->senha = password_hash($novaSenha, PASSWORD_DEFAULT);
        // echo 'Senha hasheada: '.password_hash($novaSenha, PASSWORD_DEFAULT).'';
        $prof[0]->atualizar();
        $email->recuperarSenha($prof[0]->email, $prof[0]->nome, $novaSenha);
    } elseif ($tipo == 'agente') {
        $obAgente = new Agente();
        $agente = $obAgente->gets($where);

        $agente[0]->senha = password_hash($novaSenha, PASSWORD_DEFAULT);
        $agente[0]->atualizar();
        $email->recuperarSenha($agente[0]->email, $agente[0]->nome, $novaSenha);
    }

    header('location: recuperar.php?sucesso=1');
    exit;
} else {
    header('location: recuperar.php?erro=1');
    exit;
}
