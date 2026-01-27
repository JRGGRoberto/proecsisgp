<?php
require '../vendor/autoload.php';

use App\Entity\Relatorios;

use App\Session\Login;


Login::requireLogin();
$ano = $_GET['ano'] ?? null;

$whereAno = null;


if (!empty($ano)) {
    $where = "
        publicado = 1
        AND created_at_sf >= '{$ano}-01-01'
        AND created_at_sf < '".($ano + 1)."-01-01'
    ";

    $whereQtdFinal =  "
        publicado = 1
        AND (tipo = 'fi' OR tipo = 're' OR tipo = 'pr')
        AND created_at_sf >= '{$ano}-01-01'
        AND created_at_sf < '".($ano + 1)."-01-01'
    ";

    $whereQtdParcial =  "
        publicado = 1
        AND tipo = 'pa'
        AND created_at_sf >= '{$ano}-01-01'
        AND created_at_sf < '".($ano + 1)."-01-01'
    ";

} else {
    $where = "
        publicado = 1
    ";

    $whereQtdFinal =  "
        publicado = 1
        AND (tipo = 'fi' OR tipo = 're' OR tipo = 'pr')
    ";

    $whereQtdParcial =  "
        publicado = 1
        AND tipo = 'pa'
    ";
}

$dadosRp = [];
$dadosRf = [];

$relatoriosView = Relatorios::getRegistros($where, null, null, 'created_at_sf, tipo, publicado');
$relatoriosViewQtd = Relatorios::getQntdRegistros($where);
$relatoriosFinaisQtd = Relatorios::getQntdRegistros($whereQtdFinal);
$relatoriosParciaisQtd = Relatorios::getQntdRegistros($whereQtdParcial);


// $relParcial = RelParcial::gets($whereAno, null, null, 'created_at');
// $relParcialQtd = RelParcial::getQntd($whereAno);

// $relFinal = RelFinal::gets($whereAno, null, null, 'created_at');
// $relFinalQtd = RelFinal::getQntd($whereAno);


echo json_encode([
    'ano' => $ano ?? 'todos',
    'relatoriosQtdTotal' => (int) $relatoriosViewQtd,
    'relatoriosFinaisQtd' => (int) $relatoriosFinaisQtd,
    'relatoriosParciaisQtd' => (int) $relatoriosParciaisQtd,
    'relatoriosDados' => $relatoriosView
    // 'relFinalQtd' => (int) $relFinalQtd,
    // 'relParcialQtd' => (int) $relParcialQtd,
    // 'totalQtd' => $relFinalQtd + $relParcialQtd,
    // 'relParcial' => $relParcial,
    // 'relFinal' => $relFinal,

]);


