<?php

function getEstadoProjeto($estado)
{
    switch ($estado) {
        case 0:
            return [
                'badge' => '<span class="badge badge-info">Não submetido</span>',
                'nome' => 'Não submetido'
            ];

        case 1:
            return [
                'badge' => '<span class="badge badge-warning">Em avaliação</span>',
                'nome' => 'Em avaliação'
            ];

        case 2:
            return [
                'badge' => '<span class="badge badge-secondary">Não iniciado</span>',
                'nome' => 'Não iniciado'
            ];

        case 3:
            return [
                'badge' => '<span class="badge badge-primary">Em execução</span>',
                'nome' => 'Em execução'
            ];

        case 4:
            return [
                'badge' => '<span class="badge badge-success">Aguarde Relatório Final</span>',
                'nome' => 'Aguarde Relatório Final'
            ];

        case 5:
        case 51:
            return [
                'badge' => '<span class="badge badge-success">Finalizado</span>',
                'nome' => 'Finalizado'
            ];

        case 6:
        case 7:
            return [
                'badge' => '<span class="badge badge-warning">Em avaliação</span>',
                'nome' => 'Em avaliação'
            ];

        case 9:
            return [
                'badge' => '<span class="badge badge-danger">Cancelado</span>',
                'nome' => 'Cancelado'
            ];

        default:
            return [
                'badge' => '<span class="badge badge-danger">Erro estado</span>',
                'nome' => 'Erro estado'
            ];
    }
}


function getBotoesProjeto($proj, $user, $userId, $estado)
{
    //necessitaAlteracoes -> caso precise de um controle melhor na reprovação 
    switch ($estado) {
        case 0:
            return [
                'botoes' => naoSubmetido($proj, $user),
                'necessitaAlteracoes' => false
            ];

        case 1:
            return [
                'botoes' => emAvaliacao($proj, $user),
                'necessitaAlteracoes' => false
            ];

        case 2:
            return [
                'botoes' => naoIniciado($proj, $userId),
                'necessitaAlteracoes' => false
            ];

        case 3:
            return [
                'botoes' => emExecucao($proj, $userId),
                'necessitaAlteracoes' => false
            ];

        case 4:
            return aguardandoRelatorio($proj, $userId);

        case 5:
        case 51:
            return [
                'botoes' => finalizado($proj, $user),
                'necessitaAlteracoes' => false
            ];

        case 6:
        case 7:
            return [
                'botoes' => emAvaliacao($proj, $user),
                'necessitaAlteracoes' => false
            ];

        case 9:
            return [
                'botoes' => cancelado($proj),
                'necessitaAlteracoes' => false
            ];

        default:
            return [
                'botoes' => '',
                'necessitaAlteracoes' => false
            ];
    }
}