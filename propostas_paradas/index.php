<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Propostas_Paradas;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

// Definindo os campus de cada chefe de divisão
$adm = [
    '2bebba9e-226a-11ef-b2c8-0266ad9885af',
    'b8fa555f-cedb-47cf-91cc-7581736aac88',
    'bfd757a5-4f2d-4a10-87a8-a872ae69f1fd'
];

if (!in_array($user['id'], $adm)) {
    $campusUser = $user['ca_nome'];
} else {
    $campusUser = '';
}

// Busca
$nome_prof = filter_input(INPUT_GET, 'nome_prof', FILTER_SANITIZE_SPECIAL_CHARS);
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_SPECIAL_CHARS);
$fase_seq = filter_input(INPUT_GET, 'fase_seq', FILTER_VALIDATE_INT);
$diasParados = filter_input(INPUT_GET, 'dias_parados', FILTER_VALIDATE_INT);

// Condições SQL
// Condições SQL
$condicoes = [
    strlen($titulo ?? '') ? ' titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($protocolo ?? '') ? ' protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    strlen($nome_prof ?? '') ? ' nome_prof LIKE "%'.str_replace(' ', '%', $nome_prof).'%"' : null,
    $campusUser !== '' ? ' campus = "'.$campusUser.'"' : null,
    $fase_seq ? ' fase_avaliacao = '.(int) $fase_seq : null,
    $diasParados && in_array($diasParados, [10, 30], true)
        ? ' dias_permanencia >= '.(int) $diasParados
        : null,
];

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Quantidade total de projetos
$propostasParadasQtd = Propostas_Paradas::getQntdRegistros($where);

// Paginação
$obPagination = new Pagination($propostasParadasQtd, $_GET['pagina'] ?? 1, 10);

// Registros
$propostasParadas = Propostas_Paradas::getRegistros(
    $where,
    null,
    $obPagination->getLimite()
);

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';

?>