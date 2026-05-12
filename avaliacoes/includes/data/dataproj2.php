<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Avaliacoes;

$condicoes = [
    strlen($tituloB) ? 'titulo LIKE "%'.str_replace(' ', '%', $tituloB).'%"' : null,
    strlen($nome_profB) ? 'nome_prof LIKE "%'.str_replace(' ', '%', $nome_profB).'%"' : null,
    strlen($protocoloB) ? 'protocolo = "'.$protocoloB.'"' : null,
];

// Condições SQL
array_push($condicoes, 'id_user = "'.$user['id'].'"', 'resultado in ("r", "a")');

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Qntd total de registros
$qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

// paginação
$obPagination = new Pagination($qntAvaliacoes, $_GET['pagina'] ?? 1, 10);

$avaliacoes = Avaliacoes::getRegistros($where, null, $obPagination->getLimite());
