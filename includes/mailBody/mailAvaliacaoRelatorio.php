<?php

use App\Entity\Professor;
use App\Entity\Projeto;

require '../vendor/autoload.php';

require_once '../includes/funcoes/func_proxAvaliadorRel.php';
require_once '../includes/funcoes/func_mudaAbreviacao.php';

function autorProj($id_prof)
{
    $where = 'id = "'.$id_prof.'"';
    $autorOb = Professor::getProfessores($where);

    $autor = $autorOb['0'];

    $autorEmail = $autor->email;
    $autorNome = $autor->nome;

    $autor = [
        'email' => $autorEmail,
        'nome' => $autorNome,
    ];

    return $autor;
}

function publicacao($relatorio, $projeto)
{
    $autor = autorProj($projeto->prof_id);
    $tipo = 6;
    $idref = $projeto->id;

    $tipoRel = mudaAbreviacaoTipoRel($relatorio->tipo);

    $destinatario = $autor['email'];
    $nome = $autor['nome'];

    $assunto = 'Seu relatório foi aprovado em todas as instâncias';
    $mensagem = '
        <h3>Relatório publicado com sucesso.</h3>
        <p>'.$nome.', seu <strong>relatório '.$tipoRel.'</strong> da proposta "<strong>'.$projeto->titulo.'</strong>", concluiu todas as etapas avaliação. </p>

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

function aprovacao($relatorio, $projeto)
{
    $autor = autorProj($projeto->id_prof);
    $proxAvaliador = getProximoAvaliadorRel($projeto->id);

    $tipo = 3;
    $idref = $projeto->id;
    $tipoRel = mudaAbreviacaoTipoRel($relatorio->tipo);

    // echo '<pre>';
    // print_r($proxAvaliador);
    // echo '</pre>';
    // exit;
    if ($proxAvaliador) {
        // echo 'entrou no avaliador';

        // envia para próximo avaliador
        $avaliadorDestinatario = $proxAvaliador->email;
        $avaliadorNome = $proxAvaliador->nome;

        $avaliadorAssunto = 'Avaliação de Relatório';
        $avaliadorMensagem = '
            <h3>Chegou uma nova avaliação a ser realizada no sistema da PROEC</h3>
            <p><strong>Relatório '.$tipoRel.'</strong> da proposta: <strong>'.$projeto->titulo.'</strong></p>   
            <p>Coordenador: '.$autor['nome'].'     
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
                'mensagem' => $autorMensagem,
            ],
        ];

        return $dados;
    } else {
        // echo 'entrou na publicacao';
        // exit;
        return publicacao($relatorio, $projeto);
    }
}

function submissao($relatorio, $projeto)
{
    $autor = autorProj($projeto->id_prof);
    $proxAvaliador = getProximoAvaliadorRel($projeto->id);
    //     echo '<pre>';
    // print_r($relatorio);
    // echo '</pre>';

    $tipoRel = mudaAbreviacaoTipoRel($relatorio->tipo);

    // echo '<pre>';
    // print_r($autor);
    // print_r($proxAvaliador);
    // echo '</pre>';
    // exit;

    $tipo = 8;

    $idref = $relatorio->id;

    if (!$proxAvaliador) {
        return; // ninguém aguardando avaliação
    }

    $avaliadorDestinatario = $proxAvaliador->email;
    $avaliadorNome = $proxAvaliador->nome;
    $avaliadorTipo = 2;

    $avaliadorAssunto = 'Avaliação de Relatório';
    $avaliadorMensagem = '
        <h3>Chegou uma nova avaliação a ser realizada no sistema da PROEC</h3>
        <p><strong>Relatório '.$tipoRel.'</strong> da proposta: "<strong>'.$projeto->titulo.'</strong>"</p>   
        <p>Coordenador: '.$autor['nome'].'     
        <br>
        <small>Este e-mail é automático.</small>
    ';

    if (!$autor) {
        return;
    }

    $autorDestinatario = $autor['email'];
    $nome = $autor['nome'];
    $autorTipo = 2; // primeira submissão da proposta

    $autorAssunto = 'Submissão de Relatório';
    /* Coordenador do projeto */
    $autorMensagem = '
        <h3>Submissão de Relatório</h3>
        <p>'.$autor['nome'].', seu <strong>relatório '.$tipoRel.'</strong> da proposta "<strong>'.$projeto->titulo.'</strong>", foi encaminhada para análise. </p>
        <p>Instância responsável: '.$proxAvaliador->funcao.' - '.$proxAvaliador->nome.'</p>
        <p>Após o parecer da instância, o relatório poderá retornar para ajustes ou seguir o trâmite descrito no Regulamento de Extensão da Unespar.</p>

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
            'mensagem' => $autorMensagem,
        ],
    ];

    // echo '<pre>';
    // print_r($dados);
    // echo '</pre>';
    // exit;
    return $dados;
}

function reprovacao($relatorio, $projeto)
{
    // $projeto = $projeto['0'];

    $autor = autorProj($projeto->id_prof);
    $tipoRel = mudaAbreviacaoTipoRel($relatorio->tipo);

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
        <h3>Solicitação de ajustes no relatório '.$tipoRel.'</h3> 
        <p>Acesse o sistema para visualizar e realizar as adequações necessárias.</p> 
        <p>Título: <strong>'.$projeto->titulo.'</strong></p>
        <p>Após reajustar o relatório, reenvie para uma nova avaliação.</p> 
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

function mailAvaliacaoRelatorio($relatorio, $projeto, $resultado)
{
    if ($resultado == 'n') {
        $dados = submissao($relatorio, $projeto);
    } elseif ($resultado == 'a') {
        $dados = aprovacao($relatorio, $projeto);
    } elseif ($resultado == 'r' || $resultado == 'e') {
        $dados = reprovacao($relatorio, $projeto);
    }

    return $dados;
}
