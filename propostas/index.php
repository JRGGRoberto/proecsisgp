<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Palavras;
use App\Entity\Projeto;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

// Busca

$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_STRING);
/*
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$protocolo = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$area = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);
$linh_ext = filter_input(INPUT_GET, 'linh_ext', FILTER_SANITIZE_STRING);
*/
$palavOrig = $palavra;

if (strlen($palavra)) {
    $palavra = Palavras::getProjByPalavra($palavra);
} else {
    $palavra = '';
}

//Query pros colegiados
$qry = '';
if (($user['tipo'] == 'professor') || $user['tipo'] == 'prof') {
    $qry = 'select 
            ccc.co_id as id, 
            CONCAT("Colegiado de ", ccc.colegiado) as nome,
            IFNULL(ccc.coord_id, "disabled") coord
          from ca_ce_co ccc where ccc.ca_id  = "'.$user['ca_id'].'"';
} elseif ($user['tipo'] == 'agente') {
    $qry = 'select 
            c.id as id,
            c.nome as nome,
            IFNULL(c.dir_campus_id, "disabled")  coord
          from campi c
          where c.id  = "'.$user['ca_id'].'"';

    /* $qry = 'select
               c.id as id,
               c.nome as nome,
               IFNULL(c.dir_ca_id, "disabled")  coord
             from centros c
             where c.campus_id = "'. $user['ca_id'] .'"'; */
}

use App\Entity\Diversos;
use App\Entity\ProjMaster;

$sendColegiado = Diversos::qry($qry);
$coolSelectSend = '';

foreach ($sendColegiado as $co) {
    $dis = '';
    $info = '';
    if ($co->coord == 'disabled') {
        $dis = 'disabled';
        $info = ($user['tipo'] == 'professor' || $user['tipo'] == 'prof') ? '[Sem coordenador]' : '[Sem diretor de centro]';
    }

    $coolSelectSend .= '<option value="'.$co->id.'"  '.$dis.'>'.$co->nome.' '.$info.'</option>';
}

// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

// Condições SQL
$condicoes = [
    'trim(id_prof) = "'.$user['id'].'"',
    strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
    strlen($palavra) ? $palavra : null,
    strlen($protocolo) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    /*,
  strlen($area) ? "area_extensao = '$area_extensao'": null,
  strlen($linh_ext) ? 'linh_ext LIKE "%'.str_replace(' ','%',$linh_ext).'%"': null */
];

// array_push($condicoes, 'id_prof = "' .$user['id'] .'"');

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where1 = implode(' AND ', $condicoes);

$palavra = $palavOrig;

// Qntd total de registros
$qntdProjetos = ProjMaster::getQntdRegistros($where1);

// paginação
$obPagination = new Pagination($qntdProjetos, $_GET['pagina'] ?? 1, 10);

$projetos = ProjMaster::getRegistros($where1, null, $obPagination->getLimite());

// echo '<pre>';
// print_r($projetos);
// echo '</pre>';



/*
use \App\Entity\Tipo_exten;
$proposta = Tipo_exten::getRegistros();
$propOptions = '';
foreach($proposta as $prop){
  $propOptions .= '<option value="'.$prop->nome.'"   >'.$prop->nome.'</option>';
}
*/

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
