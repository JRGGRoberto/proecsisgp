<?php
require '../vendor/autoload.php';

use App\Entity\Diversos;
use App\Entity\Outros;
use App\Session\Login;
use App\Entity\ProjMaster;

Login::requireLogin();
$ano = $_GET['ano'] ?? null;   
$campus = $_GET['campus'] ?? null;   

$whereAno = null;

if (!empty($ano)) {
    $whereAno = "
        created_at >= '{$ano}-01-01'
        AND created_at < '".($ano + 1)."-01-01'
    ";
}

$listaCampus = [
    'Apucarana',
    'Campo Mourão',
    'Curitiba I (EMBAP)',
    'Curitiba III (FAP)',
    'Loanda',
    'Paranaguá',
    'Paranavaí',
    'União da Vitória'
];

$sql = '
    select 
        distinct p.id, p.titulo, p.campus
    from 
        projmaster p
    inner join proj_idosos  t
        on p.titulo like concat("%", t.titulo, "%");
';

$projetos = Outros::qry($sql);

$sqlQtdCampus = '
    select 
        p.campus,
        count(distinct p.id) as total
    from projmaster p
    inner join proj_idosos t
        on (p.titulo) like concat("%", t.titulo, "%")
    group by p.campus;
';
$qtdPorCampus = Outros::qry($sqlQtdCampus);


$sqlQtdTotal = '
    select 
        count(distinct p.id) as total
    from 
        projmaster p
    inner join proj_idosos t
        on lower(p.titulo) like concat("%", t.titulo, "%");
';
$qtdTotal = Outros::qry($sqlQtdTotal);


function defTipoExten($tipoExten)
{
    $tipo = [
        1 => 'Curso',
        2 => 'Evento',
        3 => 'Prestação de Serviço',
        4 => 'Programa',
        5 => 'Projeto',
    ];

    return $tipo[$tipoExten];
}





echo json_encode([
    'ano'            => $ano ?: 'todos',
    'projetos'       => $projetos,
    'qtdPorCampus'   => $qtdPorCampus,
    'qtdTotal'       => $qtdTotal
    ]);
exit;

