
<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Propostas_Paradas;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

$adm = ['2bebba9e-226a-11ef-b2c8-0266ad9885af','b8fa555f-cedb-47cf-91cc-7581736aac88','bfd757a5-4f2d-4a10-87a8-a872ae69f1fd'];

//definindo os campus de cada chefe de div
if (!in_array($user['id'], $adm)) {
    $campusUser = $user['ca_nome'];
} else {
    $campusUser = '';
}

//filtros 
$titulo = trim($_GET['titulo']);
$nome_prof = trim($_GET['nome_prof']);
$protocolo = trim($_GET['protocolo']);
$fase_seq = filter_input(INPUT_GET, 'fase_seq', FILTER_VALIDATE_INT) ?: null;
$dias_parados = filter_input(INPUT_GET, 'dias_parados', FILTER_VALIDATE_INT) ?: null;


$condicoes = [
    $campus !== '' ? 'campus LIKE "%' . str_replace(' ', '%', $campusUser) . '%"' : null,
    $titulo !== '' ? 'titulo LIKE "%' . str_replace(' ', '%', $titulo) . '%"' : null,
    $nome_prof !== '' ? 'nome_prof LIKE "%' . str_replace(' ', '%', $nome_prof) . '%"' : null,
    $protocolo !== '' ? 'protocolo LIKE "%' . str_replace(' ', '%', $protocolo) . '%"' : null,
    $fase_seq ? 'fase_avaliacao = ' . $fase_seq : null,

    in_array($dias_parados, [10, 30], true) ? 'dias_permanencia >= ' . $dias_parados : null
];

//monta o where dos filtros
$condicoes = array_filter($condicoes);
$where = implode(' AND ', $condicoes);

// qtd pra paginação
$propostasParadasQtd = Propostas_Paradas::getQntdRegistros($where);

$obPagination = new Pagination($propostasParadasQtd, $_GET['pagina'] ?? 1, 10);

$propostasParadas = Propostas_Paradas::getRegistros($where, null, $obPagination->getLimite());

include '../includes/header.php';
include __DIR__ . '/includes/listagem.php';
include '../includes/footer.php';

?>
