<?php

require '../vendor/autoload.php';

function mailCadastrarCand($cand, $idCand){

    $tipo = 20;
    $idref = $idCand;
        
    $destinatario = $cand->email;
    $nome = $cand->nome; 
    

    $assunto = 'Usuário cadastrado no Sistema de Programas';

    $mensagem = '
        <h2>Cadastro realizado com sucesso!</h2>

        <p>Olá, <strong>'.$nome.'</strong>!</p>

        <p>Seu cadastro no <strong>Sistema de inscrições</strong> foi realizado com sucesso.</p>

        <p>Agora você já pode acessar o sistema utilizando as credenciais informadas durante o cadastro.</p>

        <p>Por meio do sistema, você poderá consultar e realizar sua inscrição nos programas <strong>PIBIS</strong> e <strong>PIBEX</strong>, conforme os editais e períodos de inscrição disponíveis.</p>

        <small>Este é um e-mail automático. Por favor, não responda a esta mensagem.</small>
    ';

    $dados = [
        'tipo' => $tipo,
        'idref' => $idref,
        'destinatario' => $destinatario,
        'nome' => $nome,
        'assunto' => $assunto,
        'mensagem' => $mensagem,
    ];

    return $dados;

}



