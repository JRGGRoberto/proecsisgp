<?php

require '../vendor/autoload.php';

function mailCadastrarProposta($projeto, $user){

    $tipo = 1;
    $idref = $projeto->id;
        
    $destinatario = $user['email'];
    $nome = $user['nome']; 
    

    $assunto = 'Proposta cadastrada no Sistema da PROEC';

    $mensagem = '
        <h2>Proposta cadastrada no Sistema da PROEC</h2>

        <p><strong>'.$nome.'</strong>, sua proposta de extensão foi cadastrada no Sistema da PROEC.</p>
        <p><strong>Título: </strong> '.$projeto->titulo.'</p>
        <p><strong>Tipo: </strong>'.mudaAbreviacaoTipoPropostas($projeto->tipo_exten).'</p>
        
        <p>Para que ela siga para etapas de avaliação, após o cadastro clique em <strong>SUBMETER</strong> no sistema, 
        Se você já fez isso, desconsidere essa orientação.</p>
        
        </p>
        <br><br>
        <small>Este e-mail é automático.</small>
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



