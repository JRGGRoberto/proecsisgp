<?php

use App\Db\Pagination;
use App\Entity\Relatorios_Parados;

$campusUser = $user['ca_nome'];

$condicoesRelatorios = [
    
    strlen($titulo) ? ' titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($protocolo) ? ' protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    strlen($nome_prof) ? ' nome_prof LIKE "%'.str_replace(' ', '%', $nome_prof).'%"' : null,
    $campusUser !== '' ? ' campus = "'.$campusUser.'"' : null,
    $fase_seq ? ' fase_avaliacao = '.(int) $fase_seq : null,
    $diasParados && in_array($diasParados, [10, 30], true)
        ? ' dias_permanencia >= '.(int) $diasParados
        : null,
];

$condicoesRelatorios = array_filter($condicoesRelatorios);
$whereRelatorios = implode(' AND ', $condicoesRelatorios);

$relatoriosParadosQtd = Relatorios_Parados::getQntdRegistros($whereRelatorios);
$obPaginationRelatorios = new Pagination(
    $relatoriosParadosQtd,
    $_GET['pagina_relatorios'] ?? 1,
    10
);
$relatoriosParados = Relatorios_Parados::getRegistros(
    $whereRelatorios,
    null,
    $obPaginationRelatorios->getLimite()
);