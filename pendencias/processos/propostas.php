<?php

use App\Db\Pagination;
use App\Entity\Propostas_Paradas;

$campusUser = $user['ca_nome'];

$condicoesPropostas = [
    strlen($titulo) ? ' titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($protocolo) ? ' protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    strlen($nome_prof) ? ' nome_prof LIKE "%'.str_replace(' ', '%', $nome_prof).'%"' : null,
    $campusUser !== '' ? ' campus = "'.$campusUser.'"' : null,
    $fase_seq ? ' fase_avaliacao = '.(int) $fase_seq : null,
    $diasParados && in_array($diasParados, [10, 30], true)
        ? ' dias_permanencia >= '.(int) $diasParados
        : null,
];

$condicoesPropostas = array_filter($condicoesPropostas);
$wherePropostas = implode(' AND ', $condicoesPropostas);

$propostasParadasQtd = Propostas_Paradas::getQntdRegistros($wherePropostas);
$obPaginationPropostas = new Pagination(
    $propostasParadasQtd,
    $_GET['pagina_propostas'] ?? 1,
    10
);



$propostasParadas = Propostas_Paradas::getRegistros(
    $wherePropostas,
    null,
    $obPaginationPropostas->getLimite()
);