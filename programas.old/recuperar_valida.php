<?php

require '../vendor/autoload.php';

use App\Entity\Candidato;
use App\Entity\EmailService;

$email = $_POST['email'] ;
$data  = $_POST['data_nascimento'] ;


// converte data 
[$dia, $mes, $ano] = explode('/', $data);
$data = "$ano-$mes-$dia";

// echo '<pre>';
// print_r($data);
// echo '</pre>';
// exit;


$candidato = Candidato::getRecuperacao($email, $data);

// echo "<pre>";
// print_r ($candidato);
// echo '</pre>';
// exit;



if ($candidato) {
    // $obProfessor->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    //gerador de senha
    
    $novaSenha = substr(md5(uniqid()), 0, 8); 
    // echo '<pre>';
    // print_r($novaSenha);
    // echo '</pre>';  
    $candidato->senha = password_hash($novaSenha, PASSWORD_DEFAULT);
    $candidato->atualizar();

    $email = new EmailService();
    $email->recuperarSenha($candidato->email, $candidato->nome, $novaSenha);

    header('location: recuperar.php?sucesso=1');
} else { 
    header('location: recuperar.php?erro=1');

}
