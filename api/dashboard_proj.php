<?php
require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\ProjMaster;

Login::requireLogin();

$listaCampus = [
    'Apucarana',
    'Campo Mourão',
    'Curitiba I (EMBAP)',
    'Curitiba II (FAP)',
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
$anoEncerrados = $ano ?? date('Y');
// echo $anoEncerrados;
// exit;

$campus = $_GET['campus'] ?? null;   

//Preciso separar os wheres pois possuem condicoes diferentes
$whereAno = null;
$whereEncerrados = null;

if (!empty($ano)) {
    $whereAno = "
        created_at >= '{$ano}-01-01'
        AND created_at < '".($ano + 1)."-01-01'
    ";
}

$whereEncerrados = "
    vigen_fim >= '{$anoEncerrados}-01-01'
    AND vigen_fim < '".($anoEncerrados + 1)."-01-01'
";

$qtdPorCampus = [];

//Percorre cada campus com um where diferente
foreach ($listaCampus as $campusNome) {
    $condicoesAno = [];
    $condicoesEncerrados = [];

    //Se tem algum ano no filtro 
    if ($whereAno) {
        $condicoesAno[] = $whereAno;
    }

    $condicoesAno[] = "campus = '{$campusNome}'";
    $condicoesEncerrados[] = $whereEncerrados;
    $condicoesEncerrados[] = "campus = '{$campusNome}'";

    // echo '<pre>'; 
    //     print_r($condicoesEncerrados);
    // echo '</pre>';

    // echo '<pre>'; 
    //     print_r($condicoesAno);
    // echo '</pre>';
    // exit;

    //Separa os wheres com 'and'
    $whereFinalAno = implode(' AND ', $condicoesAno);
    $whereFinalEncerrados = implode(' AND ', $condicoesEncerrados);
    
    //Cria um array associativo para cada campus correspodenndo com a sua quantidade de propostas
    $qtdPorCampus[] = [
        'campus' => $campusNome,
        'total'  => (int) ProjMaster::getQntdRegistros($whereFinalAno),
        'encerrados' => (int) ProjMaster::getQntdRegistros($whereFinalEncerrados)
    ];
}

$projetos = ProjMaster::getRegistros($whereAno, null, null);
$qtdProjetos = ProjMaster::getQntdRegistros($whereAno);
$encerrados = ProjMaster::getQntdRegistros($whereEncerrados);


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
    'qtdEncerrados' => $encerrados,
    'qtdPorCampus'  => $qtdPorCampus,
    'dadosProjetos' => $dadosProjetos,
]);
exit;

