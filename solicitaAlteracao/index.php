<?php

require '../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Db\Pagination;
use App\Entity\Solicitacao_adendos;

// Pegar os valores do GET
$idLocal = filter_input(INPUT_GET, 'idLocal', FILTER_SANITIZE_STRING);
$tituloBusca = strtolower(trim(filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING)));
$coordenadorBusca = strtolower(trim(filter_input(INPUT_GET, 'coordenador', FILTER_SANITIZE_STRING)));
$protocoloBusca = strtolower(trim(filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_STRING)));
$orderByBusca = strtolower(trim(filter_input(INPUT_GET, 'orderBy', FILTER_SANITIZE_STRING)));

// Serve para que o Diretor de Programas e Projetos de Extensão veja todos os projetos atualizados mas altere apenas o dele
if (($user['CargoEspecial'] != '0' || $user['reitoria'] != '0') && ($_GET['tipo'] == 'atualizados')) {
    $idloc = null;
} else {
    $idloc = 'id_localValidador = "'.$idLocal.'"';
}

// Condições SQL
$condicoesWhere = [
    // Condição padrão
    $idloc,
    // Condição de filtro
    strlen($tituloBusca) ? 'titulo LIKE "%'.str_replace(' ', '%', $tituloBusca).'%"' : null,
    strlen($coordenadorBusca) ? 'coord LIKE "%'.str_replace(' ', '%', $coordenadorBusca).'%"' : null,
    strlen($protocoloBusca) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocoloBusca).'%"' : null,
];

$orderByBusca == 'antigo' || $orderByBusca == '' ? $condicoesOrder = 'data_solicitacao ASC' : $condicoesOrder = 'data_solicitacao DESC';

// Remove posições vazias
$condicoesWhere = array_filter($condicoesWhere);

// Cláusula WHERE
$where = implode(' AND ', $condicoesWhere);

$result = Solicitacao_adendos::getRegistros($where, $condicoesOrder);

$pendentes = [];
$finalizados = [];
$campo = '';

foreach ($result as $item) {
    // Formatar TIDE como 'sim' ou 'não'
    if ($item->campoAlterado === 'tide') {
        if ($item->dado_novo === 'N') {
            $item->dado_novo = 'Não';
        } elseif ($item->dado_novo === 'S') {
            $item->dado_novo = 'Sim';
        }
    }
    // Formatar data como dd/mm/aaaa
    elseif ($item->campoAlterado === 'vigen_ini' || $item->campoAlterado === 'vigen_fim') {
        $item->dado_novo = date('d/m/Y', strtotime($item->dado_novo));
    }
    // Pegar nome do professor que vai ser alterado
    elseif ($item->campoAlterado == 'id_prof') {
        $paramns['idPessoa'] = $item->dado_novo;
        require_once '../includes/funcoes/func_recuperarDadosPessoas.php';
        $nomePessoa = recuperarDadosPessoas($paramns);
        $item->dado_novo = $nomePessoa[0]['nome'];
    }

    require_once '../includes/funcoes/func_mudaAbreviacao.php';
    $campo = mudaAbreviacaoCampoAlterado($item->campoAlterado);
    $item->campoAlterado = $campo;

    // Formatar data da solicitação em dd/mm/aaaa
    $item->data_solicitacao = date('d/m/Y', strtotime($item->data_solicitacao));

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

require_once '../includes/funcoes/func_verificaCargosEspeciais.php';
$CargoEspecial = dadosCargosEspeciais($user['CargoEspecial']);
// Se tiver mais de um cargo especial que pode acessar essa página
foreach ($CargoEspecial as $id) {
    $idCargo = $id->idPessoaOcupante;
}

// Valida se o usuário que está tentando acessar a página realmente pode acessar a página
if ($_GET['solicita'] == 'DEC') {
    if ($user['config'] != 3) {
        echo "<script>location.replace('../home');</script>";
        exit;
    } elseif ($user['config'] == 3) {
        include '../includes/header.php';
        include './includes/topoPag.php';
        include './includes/filtro.php';
        include './includes/paginacao.php';
        include $pag;
        include '../includes/footer.php';
    }
} elseif ($_GET['solicita'] == 'PROEC') {
    if ($user['CargoEspecial'] == '0' || empty($user['CargoEspecial'])) {
        echo "<script>location.replace('../home');</script>";
        exit;
    } elseif ($idCargo = $user['id']) {
        include '../includes/header.php';
        include './includes/topoPag.php';
        include './includes/filtro.php';
        include './includes/paginacao.php';
        include $pag;
        include '../includes/footer.php';
    }
} else {
    echo "<script>location.replace('../home');</script>";
    exit;
}
