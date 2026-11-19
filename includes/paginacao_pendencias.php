
<?php
$parametroPagina = $parametroPagina ?? 'pagina';

$gets = $_GET;
unset($gets['status'], $gets['pagina'], $gets['pagina_propostas'], $gets['pagina_relatorios'], $gets['palavra']);

$gets = http_build_query($gets);
$paginas = $obPagination->getPages();

$paginacao = '<nav aria-label="Paginação">
    <ul class="pagination pagination-sm">';

if ($obPagination->getQntPages() > 13) {
    $paginacao .= '<li class="page-item">
        <a class="page-link" href="?' . $parametroPagina . '=1&' . $gets . '">﹤</a>
    </li>';
}

foreach ($paginas as $pagina) {
    $class = $pagina['atual'] ? 'page-item active' : 'page-item';

    $paginacao .= '<li class="' . $class . '">
        <a class="page-link" href="?' . $parametroPagina . '=' . $pagina['pagina'] . '&' . $gets . '">' . $pagina['pagina'] . '</a>
    </li>';
}

if ($obPagination->getQntPages() > 13) {
    $paginacao .= '<li class="page-item">
        <a class="page-link" href="?' . $parametroPagina . '=' . $obPagination->getQntPages() . '&' . $gets . '">﹥</a>
    </li>';
}

$paginacao .= '</ul></nav>';
