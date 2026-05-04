<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\solicitacao_adendos;
use App\Db\Pagination;

// Pegar os valores do GET
$idLocal = filter_input(INPUT_GET, 'idLocal', FILTER_SANITIZE_STRING);
$tituloBusca = strtolower(trim(filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING)));
$coordenadorBusca = strtolower(trim(filter_input(INPUT_GET, 'coordenador', FILTER_SANITIZE_STRING)));
$protocoloBusca = strtolower(trim(filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_STRING)));
$orderByBusca = strtolower(trim(filter_input(INPUT_GET, 'orderBy', FILTER_SANITIZE_STRING)));

// Condições SQL
$condicoesWhere = [
    // Condição padrão
    'id_localValidador = "'.$idLocal.'"',    
    // Condição de filtro
    strlen($tituloBusca) ? 'titulo LIKE "%'.str_replace(' ', '%', $tituloBusca).'%"' : null,
    strlen($coordenadorBusca) ? 'coord LIKE "%'.str_replace(' ', '%', $coordenadorBusca).'%"' : null,
    strlen($protocoloBusca) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocoloBusca).'%"' : null,
];

$orderByBusca=='antigo' || $orderByBusca=='' ? $condicoesOrder='data_solicitacao ASC' : $condicoesOrder='data_solicitacao DESC'  ;

// Remove posições vazias
$condicoesWhere = array_filter($condicoesWhere);

// Cláusula WHERE
$where = implode(' AND ', $condicoesWhere);

$result = solicitacao_adendos::getRegistros($where, $condicoesOrder);

$pendentes = [];
$finalizados = [];
$campo = '';

foreach ($result as $item) {

    // Formatar TIDE como 'sim' ou 'não'
    if ($item->campoAlterado === 'tide'){
        if ($item->dado_novo === 'N'){
            $item->dado_novo = 'Não';
        }
        elseif ($item->dado_novo === 'S'){
            $item->dado_novo = 'Sim';
        }
    }   
    // Formatar data como dd/mm/aaaa
    elseif ($item->campoAlterado === 'vigen_ini' || $item->campoAlterado === 'vigen_fim'){
        $item->dado_novo = date("d/m/Y", strtotime($item->dado_novo));
    }

    // Formatar campo 'vigen_ini' e 'vigen_fim'
    if ($item->campoAlterado === 'vigen_ini'){
        $campo = 'inicío da vigência';
    }
    elseif ($item->campoAlterado === 'vigen_fim'){
        $campo = 'fim da vigência';
    }
    else {
        $campo = $item->campoAlterado;    
    }
    $item->campoAlterado = $campo;

    // Formatar data da solicitação em dd/mm/aaaa
    $item->data_solicitacao = date("d/m/Y", strtotime($item->data_solicitacao));
    
    // Pega os itens dos que estão pendentes ou que foram aprovados
    if ($item->resultado === 'n') {
        $pendentes[] = $item;
    } else {
        $finalizados[] = $item;
    }
}

// O que vai para qual página
if ($_GET['tipo'] === 'atualizar') {
    $lista = $pendentes;
    $pag = './includes/listagemAtualizar.php';
} elseif ($_GET['tipo'] === 'atualizados') {
    $lista = $finalizados;
    $pag = './includes/listagemAtualizados.php';
} else {
    header('Location: ../');
    exit;
}

// Paginação
$adendosPagination = new Pagination(count($lista), $_GET['pagina'] ?? 1, 5);
list($offset, $limit) = explode(',', $adendosPagination->getLimite());

// Dados com a paginação
$dados = array_slice($lista, $offset, $limit);

include '../includes/header.php';
include './includes/filtro.php';
include './includes/paginacao.php';
include $pag;
include '../includes/footer.php';