<?php
require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\ProjMaster;

Login::requireLogin();

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


$dadosProjetos = []; 
$ano = $_GET['ano'] ?? null;   
$whereAno = null;

if (!empty($ano)) {
    $whereAno = "
        vigen_fim >= '{$ano}-01-01'
        AND vigen_fim < '".($ano + 1)."-01-01'
    ";
}


$qtdPorCampus = [];

//Percorre cada campus com um where diferente
foreach ($listaCampus as $campusNome) {
    $condicoes = [];

    //Se tem algum ano no filtro 
    if ($whereAno) {
        $condicoes[] = $whereAno;
    }

    $condicoes[] = "campus = '{$campusNome}'";
    //Separa os wheres com 'and'
    $whereFinal = implode(' AND ', $condicoes);

    //Cria um array associativo para cada campus correspodenndo com a sua quantidade de propostas
    $qtdPorCampus[] = [
        'campus' => $campusNome,
        'total'  => (int) ProjMaster::getQntdRegistros($whereFinal)
    ];
}

$projetos = ProjMaster::getRegistros($whereAno, null, null);
$qtdProjetos = ProjMaster::getQntdRegistros($whereAno);

foreach ($projetos as $p) {
    $dadosProjetos[] = [
        'id' => $p->id,
        'titulo' => $p->titulo,
        'campus' => $p->campus,
        'estado' => $p->estado,
        'tipo_exten' => defTipoExten($p->tipo_exten),
        'created_at' => $p->created_at
    ];
}

echo json_encode([
    'ano'           => $ano ?: 'todos',
    'qtdProjetos'   => $qtdProjetos,
    'qtdPorCampus'  => $qtdPorCampus,
    'dadosProjetos' => $dadosProjetos
]);
exit;

