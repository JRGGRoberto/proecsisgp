<?php

use App\Entity\Professor;
use App\Entity\solicitacao_adendos;

require '../vendor/autoload.php';



function mailAnaliseAlteracaoPropostas($idSolicitacao, $resultado, $userNome, $userEmail) {

    // Pega as infos da view solicitacao_adendos_v
    $where = 'id = "'.$idSolicitacao.'"';
    $ObjSolicitacao = solicitacao_adendos::getRegistros($where);

    $tipo = 8;

    $nomeDonoProj = $ObjSolicitacao[0]->solicitante_nome;
    $emailDonoProj = $ObjSolicitacao[0]->solicitante_email;

    include '../funcoes/func_mudaAbreviacao.php';
    $campoAlterado = mudaAbreviacaoCampoAlterado($ObjSolicitacao[0]->campoAlterado);
    $resultadoAvalia = mudaAbreviacaoAprovacao($resultado);

    // Quem enviou a avaliação de modificação
    $autorDestinatario = $userEmail;
    $autorNome = $userNome;

    $autorAssunto = 'Avaliação de alteração de proposta';
    $autorMensagem = '
        <h2>Avaliação enviada com sucesso!</h2>
        <p>Olá <strong>'.$userNome.'</strong>,</p>
        <p>Sua avaliação de alteração foi retornada para <strong>'.$nomeDonoProj.'</strong>.</p>
        <p>Agradecemos à avaliação.</p>
        <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
        <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>
        <p><strong>Resultado da avaliação: </strong>'.$resultadoAvalia.'</p>
        <br><br>
        <small>Este e-mail é automático.</small>
    ';

    // Quem vai receber a avaliação de modificação
    $avaliadorDestinatario = $emailDonoProj;
    $avaliadorNome = $nomeDonoProj;

    $avaliadorAssunto = 'Avaliação de alteração de proposta';
    $avaliadorMensagem = '
        <h2>Sua solicitação foi avaliada!</h2>
        <p>Olá <strong>'.$nomeDonoProj.'</strong>,</p>
        <p>
            Informamos que foi <strong>'.strtolower($resultadoAvalia).'</strong> 
            a alteração do campo <strong>'.$campoAlterado.'</strong> 
            referente à proposta <strong>"'.$ObjSolicitacao[0]->titulo.'"</strong>.
        </p>
        <br><br>
        <small>Este e-mail é automático.</small>
    ';

    // O novo coordenador caso a proposta seja aprovado
    if ($ObjSolicitacao[0]->campoAlterado == 'id_prof' && $ObjSolicitacao[0]->resultado == 'a') {
        $idNovoCoord = $ObjSolicitacao[0]->dado_novo;
        $where = 'id = "'.$idNovoCoord.'"';
        $registro = Professor::getProfessores($where);
        $nomeNovoCoord = $registro[0]->nome;
        $emailNovoCoord = $registro[0]->email;

        $novoAutorDestinatario = $emailNovoCoord;
        $novoAutorNome = $nomeNovoCoord;
        $novoAutorAssunto = 'Avaliação de alteração de proposta';
        $novoAutorMensagem = '
            <h2>Alteração de coordenador realizada!</h2>
            <p>Olá <strong>'.$nomeNovoCoord.'</strong>,</p>
            <p>
                Informamos que foi <strong>'.strtolower($resultadoAvalia).'</strong> 
                a alteração do campo <strong>'.$campoAlterado.'</strong> 
                referente à proposta <strong>"'.$ObjSolicitacao[0]->titulo.'"</strong>.
            </p>
            <p>
                O projeto já consta na aba "Meus projetos/propostas" do seu sistema!
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ';
    }

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
        ],

        'novoAutor' => [
            'destinatario' => $novoAutorDestinatario,
            'nome' => $novoAutorNome,
            'assunto' => $novoAutorAssunto,
            'mensagem' => $novoAutorMensagem
        ]

    ];
    return $dados;
}