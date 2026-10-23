<?php

use App\Db\Pagination;
use App\Entity\Avaliacoes;

$condicoes = [
    $tituloB = (is_string($tituloB) && trim($tituloB) !== '') ? 'titulo LIKE "%'.str_replace(' ', '%', $tituloB).'%"' : null,
    $nome_profB = (is_string($nome_profB) && trim($nome_profB) !== '') ? 'nome_prof LIKE "%'.str_replace(' ', '%', $nome_profB).'%"' : null,
    $protocoloB = (is_string($protocoloB) && trim($protocoloB) !== '') ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocoloB).'%"' : null,
];

// Condições SQL
array_push($condicoes, 'id_user = "'.$user['id'].'"', 'resultado = "e"');

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Qntd total de registros
$qntAvaliacoes = count(Avaliacoes::getRegistros($where));

// paginação
$obPagination = new Pagination($qntAvaliacoes, $_GET['pagina'] ?? 1, 10);

$avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());
