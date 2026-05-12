<?php

use App\Db\Pagination;
use App\Entity\AvaliaRelatorios;

// Listagem dos relatórios a serem realizados

$condicoes = [];

switch ($user['config']) {
    case 0: // Ag ou Prof
        array_push($condicoes,
            // ' tp_instancia not in ( "dc", "ca", "ce", "co") ',
            ' id_instancia = "'.$user['id'].'"  ');
        break;
    case 1: // Coordenador;
        array_push($condicoes,
            '( ( tp_instancia = "co" and  id_instancia = "'.$user['co_id'].'") 
                or 
               ( tp_instancia = "pf" and  id_instancia = "'.$user['id'].'")   
             )');
        break;
    case 2: // Dir Centro de Area CE
        array_push($condicoes,
            ' tp_instancia = "ce"',
            ' id_instancia in ("'.$user['ce_id'].'", "'.$user['id'].'")  ');
        break;
    case 3: // Chefe de divisão CA
        array_push($condicoes,
            ' tp_instancia = "ca" ',
            ' id_instancia in ("'.$user['ca_id'].'", "'.$user['id'].'")  ');
        break;
    case 4: // Diretor de campus
        array_push($condicoes,
            ' tp_instancia = "dc"',
            ' id_instancia in ("'.$user['ca_id'].'", "'.$user['id'].'")  ');
        break;
}

array_push($condicoes, ' resultado not in ("r", "a") ');

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$avaliacoes = new AvaliaRelatorios();
$avaliacoesQnt = AvaliaRelatorios::getQntdRegistros($where);

$obPagination = new Pagination($avaliacoesQnt, $_GET['pagina'] ?? 1, 10);

$avaliacoes = AvaliaRelatorios::getRegistros($where, null, $obPagination->getLimite());
