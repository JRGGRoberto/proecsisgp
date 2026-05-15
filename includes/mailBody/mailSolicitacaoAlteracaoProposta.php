<?php

use App\Entity\Ca_Ce_Co;
use App\Entity\Cargos_Especiais;
use App\Entity\solicitacao_adendos;

require '../vendor/autoload.php';

// use \App\Entity\Professor;

// $idSolicitacao = '14a471a7-72c8-45b0-8267-64e207005aca';
// $userEmail = 'arthurguirro@gmail.com';
// $userNome = 'Arthur';

function mailSolicitacaoAlteracaoProposta($idSolicitacao, $userNome, $userEmail) {

    $tipo = 7;

    // Quem enviou a solicitação de modificação
    $autorDestinatario = $userEmail;
    $autorNome = $userNome;    
    
    // Pega as infos da view solicitacao_adendos_v
    $where = 'id = "'.$idSolicitacao.'"';
    $ObjSolicitacao = solicitacao_adendos::getRegistros($where);

    // Pega quem vai receber o projeto para avaliação
    if ($ObjSolicitacao[0]->campoAlterado == 'id_prof') {
        // Garante que vai apenas para o Diretor de Programas e Projetos de Extensão (Dantas)
        $whr = 'idLocalCargo = "'.$ObjSolicitacao[0]->id_localValidador.'" and id = "6d7582d1-3998-11f1-aed4-66a0b0dd1af7"';
        $flds = 'nome, email';
        $data = Cargos_Especiais::getRegistros($whr, '', '', $flds);
        $avaliadorNome = $data[0]->nome;
        $avaliadorDestinatario = $data[0]->email;
    } else {
        $whr = 'ca_id = "'.$ObjSolicitacao[0]->id_localValidador.'"';
        $flds = 'chef, chef_mail';
        $data = Ca_Ce_Co::getRegistros($whr, '', '1', $flds);
        $avaliadorNome = $data[0]->chef;
        $avaliadorDestinatario = $data[0]->chef_mail;
    }

    require_once '../includes/funcoes/func_mudaAbreviacao.php';
    $campoAlterado = mudaAbreviacaoCampoAlterado($ObjSolicitacao[0]->campoAlterado);

    $autorAssunto = 'Solicitação de alteração de proposta';
    $autorMensagem = '
        <h2>Solicitação enviada com sucesso!</h2>
            
        <p>Olá <strong>'.$userNome.'</strong>,</p>
                
        <p>Sua solicitação de alteração foi enviada para <strong>'.$avaliadorNome.'</strong> e será devidamente avaliada.</p>
        <p>O retorno da avaliação será informado via e-mail.</p>
            
        <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
        <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>

        <br><br>
        <small>Este e-mail é automático.</small>
    ';

    $avaliadorAssunto = 'Solicitação de alteração de proposta';
    $avaliadorMensagem = '
        <h2>Você recebeu uma nova solicitação de alteração de proposta!</h2>
        
        <p>Olá <strong>'.$avaliadorNome.'</strong>,</p>
                
        <p>Você recebeu uma solicitação de alteração de proposta de: <strong>'.$userNome.'</strong>.</p>
        <p>Faça a avaliação para finalizar a solicitação.</p>
        
        <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
        <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>

        <br><br>
        <small>Este e-mail é automático.</small>
    ';

    $dados = [
        'tipo' => $tipo,
        'idref' => $idSolicitacao,
        
        'avaliador' => [
            'destinatario' => $avaliadorDestinatario,
            'nome' => $avaliadorNome,
            'assunto' => $avaliadorAssunto,
            'mensagem' => $avaliadorMensagem,
        ],

        'autor' => [
            'destinatario' => $autorDestinatario,
            'nome' => $autorNome,
            'assunto' => $autorAssunto,
            'mensagem' => $autorMensagem
        ]

    ];
    return $dados;
}