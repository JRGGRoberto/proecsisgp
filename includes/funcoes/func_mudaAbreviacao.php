<?php

// Função utilizada apenas para receber uma abreviação, verificar se ela existe na lista e mudar ela para o nome sem abreviação
// É necessário passar a abreviação para a função
// Ajudar na hora de dar manutenção em um nome

// Tabelas do banco que também tem abreviação:
// - campos_editaveis_projetos;

require '../vendor/autoload.php';

use App\Session\Login;

Login::requireLogin();

function mudaAbreviacaoCampoAlterado($abreviacao)
{
    $abrevia = [
        'vigen_ini' => 'Início da vigência',
        'vigen_fim' => 'Fim da vigência',
        'id_prof' => 'Coordenador da proposta',
        'titulo' => 'Título da proposta',
        'tide' => 'TIDE',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoAprovacao($abreviacao)
{
    $abrevia = [
        'r' => 'Reprovado',
        'a' => 'Aprovado',
        'n' => 'Novo',
        'e' => 'Em espera',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoTipoPropostas($abreviacao)
{
    $abrevia = [
        '1' => 'Curso',
        '2' => 'Evento',
        '3' => 'Prestação de Serviço',
        '4' => 'Programa',
        '5' => 'Projeto',
    ];

    return $abrevia[$abreviacao];
}

function tipoRelatorio($abreviacao)
{
    $abrevia = [
        'pa' => 'Relatório Parcial',
        'fi' => 'Relatório Final',
        're' => 'Relatório Final com Renovação',
        'pr' => 'Relatório Final com Prorrogação',
    ];

    return $abrevia[$abreviacao];
}

function tipoCargos($abreviacao)
{
    $abrevia = [
        'pf' => 'Professor',
        'ag' => 'Agente',
        'ca' => 'Chefe de Divisão',
        'ce' => 'Diretor(a) de Centro',
        'co' => 'Coordenador(a)',
        'dc' => 'Diretor(a) de Campus',
        'ca' => 'Chefe de Divisão',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoHoraEstatica($abreviacao)
{
    $abrevia = [
        'ultimaHora' => ' 23:59:59.000',
        'meioDia' => ' 12:00:00.000',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoPendencias($abreviacao)
{
    $abrevia = [
        // Tipos de pendências
        'av' => 'Avaliação',
        'aj' => 'Ajuste',
        'ntf' => 'Notificação',
        // Recebedores de pendências
        'proec' => 'PROEC',
        'dec' => 'DEC',
        'prop' => 'Proposta',
        'rp' => 'Relatório Parcial',
        'rf' => 'Relatório Final',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoEstadoProp($abreviacao)
{
    $abrevia = [
        '0' => 'não submetido',
        '1' => 'em avaliação',
        '2' => 'não iniciado',
        '3' => 'em execução',
        '31' => 'em execução (relatório parcial enviado)',
        '4' => 'aguardando relatório final',
        '5' => 'finalizado',
        '6' => 'necessário adequações',
        '7' => 'necessário ressubmeter',
        '8' => '(não tem)',
        '9' => 'cancelado',
        '51' => 'projeto aprovado via e-protocolo',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoInstancias($abreviacao)
{
    $abrevia = [
        'ca' => ' Chefe de Divisão',
        'co' => ' Coordenador',
        'ce' => ' Diretor de Centro de Área',
        'dc' => ' Diretor de Campus',
        'pf' => ' Professor Parecerista',
        'ag' => ' Agente',
    ];

    return $abrevia[$abreviacao];
}

function mudaAbreviacaoTipoRel($abreviacao)
{
    $abrevia = [
        'pa' => 'parcial',
        'fi' => 'final',
    ];

    return $abrevia[$abreviacao];
}

function tipoRelatorioIcon($abreviacao)
{
    $abrevia = [
        'fi' => '📊 Relatório Final ',
        're' => '📊 Relatório Final com renovação ',
        'pr' => '📊 Relatório Final com prorrogação',
        'pa' => '📊 Relatório Parcial ',
        'im' => '📊 Final importado ',
    ];

    return $abrevia[$abreviacao];
}
