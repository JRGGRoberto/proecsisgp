<?php

use App\Entity\Professor;

require '../vendor/autoload.php';

require '../includes/funcoes/func_proxAvaliador.php';

function autorProj($id_prof){
    $where = 'id = "'.$id_prof.'"';
    $autorOb = Professor::getProfessores($where);
    $autor = $autorOb['0'];

    $autorEmail = $autor->email;
    $autorNome = $autor->nome;
    
    $autor = [
        'email' => $autorEmail,
        'nome' => $autorNome
    ];

    return $autor;
}

function publicacao($projeto){

    $autor = autorProj($projeto);
    $tipo = 6;
    $idref = $projeto->id;
    
    $destinatario = $autor['email'];
    $nome = $autor['nome'];

    $assunto = 'Sua proposta foi aprovada em todas as instâncias';
    $mensagem = '
        <h3>Proposta aprovada com sucesso</h3>
        <p>Sua proposta concluiu todas as etapas de avaliação.</p>
        <p>Título: <strong>'.$projeto->titulo.'</strong></p>
        <p>Este '.mudaAbreviacaoTipoPropostas($projeto->tipo_exten).' deve ser executado dentro da vigência informada</p>
        <p>Vigência informada: <strong>'.formatData($projeto->vigen_ini).'<strong> - </strong>'.formatData($projeto->vigen_fim).'</strong></p>
        <p>Dentro deste período podem ser inseridos <strong>relatórios parciais</strong></p>
        <p>Ao seu término, <strong>relatórios finais</strong>.</p>

        <br>
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

function aprovacao($projeto){

    $autor = autorProj($projeto->id_prof);
    $proxAvaliador = getProximoAvaliador($projeto->id);

    $tipo = 3;
    $idref = $projeto->id;

    if ($proxAvaliador) {
        // envia para próximo avaliador
        $avaliadorDestinatario = $proxAvaliador->email;
        $avaliadorNome = $proxAvaliador->nome;
        
        $avaliadorAssunto = 'Proposta aguardando avaliação';
        $avaliadorMensagem = '
            <h3><strong>Proposta aguardando avaliação</strong></h3>
            <p>Existe uma proposta aguardando sua avaliação no sistema.</p>
            <p>Título: '.$projeto->titulo.'</p>
            <p>Coordenador: '.$autor['nome'].'

            </p>

            
            <br>
            <small>Este e-mail é automático.</small>
        ';

        // avisa autor que está em avaliação
        $autorDestinatario = $autor['email'];
        $nome = $autor['nome'];

        $autorAssunto = 'Sua proposta está em nova fase de avaliação';
        $autorMensagem = '
            <h3>Sua proposta está em nova fase de avaliação.</h3>
            <p>Instância responsável: '.$proxAvaliador->funcao.' - '.$proxAvaliador->nome.'</p>
            <p>Título da proposta a ser avaliada: <strong>'.$projeto->titulo.'</strong></p>
            <p>Protocolo: <strong>'.$projeto->protocolo.'</strong></p>

            <br>
            <small>Este e-mail é automático.</small>
        ';

        $dados = [
            'tipo' => $tipo,
            'idref' => $idref,

            'avaliador' => [
                'destinatario' => $avaliadorDestinatario,
                'nome' => $avaliadorNome,
                'assunto' => $avaliadorAssunto,
                'mensagem' => $avaliadorMensagem,
            ],

            'autor' => [
                'destinatario' => $autorDestinatario,
                'nome' => $nome,
                'assunto' => $autorAssunto,
                'mensagem' => $autorMensagem
            ]

        ];

        return $dados;
    } else {
        publicacao($projeto);
    }
}

function submissao($projeto){
    
    $autor = autorProj($projeto->id_prof);
    $proxAvaliador = getProximoAvaliador($projeto->id);

    $tipo = 8;

    $idref = $projeto->id;

    if (!$proxAvaliador) {
        return; // ninguém aguardando avaliação
    }

    $avaliadorDestinatario = $proxAvaliador->email;
    $avaliadorNome = $proxAvaliador->nome;
    $avaliadorTipo = 2; 

    $avaliadorAssunto = 'Submissão de proposta de extensão';
    $avaliadorMensagem = '
        <h3>Chegou uma nova avaliação a ser realizada no sistema da PROEC</h3>
        <p>Título da proposta a ser avaliada: <strong>'.$projeto->titulo.'</strong></p>
        <p>Protocolo: <strong>'.$projeto->protocolo.'</strong></p>
        
        <br>
        <small>Este e-mail é automático.</small>
    ';

    if (!$autor) {
        return;
    }

    $autorDestinatario = $autor['email'];
    $nome = $autor['nome'];
    $autorTipo = 2; // primeira submissão da proposta

    $autorAssunto = 'Submissão de Proposta';
    /* Coordenador do projeto */
    $autorMensagem = '
        <h3>Submissão de proposta de extensão</h3>
        <p>'.$autor['nome'].', sua proposta de extensão de título "'.$projeto->titulo.'",
        protocolo '.$projeto->protocolo.'  foi encaminhada para análise da Divisão de Extensão do campus de '.$projeto->campus.'. </p>
        <p>Instância responsável: '.$proxAvaliador->funcao.' - '.$proxAvaliador->nome.'</p>
        <p>Após o parecer da Divisão de Extensão, a proposta poderá retornar para ajustes ou seguir o trâmite descrito no Regulamento de Extensão da Unespar.</p>

        <p>Acesse o sistema para dar continuidade ao fluxo.</p>


        <br>
        <small>Este e-mail é automático.</small>
    ';

    $dados = [
        'tipo' => $tipo,
        'idref' => $idref,

        'avaliador' => [
            'tipo' => $avaliadorTipo,
            'destinatario' => $avaliadorDestinatario,
            'nome' => $avaliadorNome,
            'assunto' => $avaliadorAssunto,
            'mensagem' => $avaliadorMensagem,
        ],

        'autor' => [
            'tipo' => $autorTipo,
            'destinatario' => $autorDestinatario,
            'nome' => $nome,
            'assunto' => $autorAssunto,
            'mensagem' => $autorMensagem
        ]

    ];
    return $dados;

}


function reprovacao($projeto){

    // $projeto = $projeto['0'];
    
    $autor = autorProj($projeto->id_prof);

    $tipo = 9;
    $idref = $projeto->id;

    // achar o autor do proejto pra enviar email
    if (!$autor) {
        return;
    }
    $destinatario = $autor['email'];
    $nome = $autor['nome'];
    
    // aviso de avaliação ao autor
    $assunto = 'Solicitação de Alteração';
    $mensagem = ' 
        <h3>Solicitação de ajustes na proposta</h3> 
        <p>Acesse o sistema para visualizar e realizar as adequações necessárias.</p> 
        <p>Título: <strong>'.$projeto->titulo.'</strong></p>
        <p>Após reajustar a proposta, reenvie para uma nova avaliação.</p> 
        <br> 
        <small>Este e-mail é automático.</small> ';

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

function mailAvaliacaoProposta($projeto, $resultado){
    if ($resultado == 'a') {
        $dados = aprovacao($projeto);
        return $dados;
    }
    elseif ($resultado == 'n') {
        $dados = submissao($projeto);
        return $dados;
    }
    elseif ($resultado == 'r') {
        $dados = reprovacao($projeto);
        return $dados;
    }
}


