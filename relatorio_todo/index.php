<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\Outros;

// echo '<pre>';
// print_r($user['id']);
// echo '</pre>';
// exit;

// Busca
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);
/*
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$colegiado = filter_input(INPUT_GET, 'colegiado', FILTER_SANITIZE_STRING);
$centro = filter_input(INPUT_GET, 'centro', FILTER_SANITIZE_STRING);
*/

// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

// Condições SQL
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace(' ', '%', $busca).'%"' : null, /*,
  strlen($campus) ? "campus = '$campus'": null,
  strlen($colegiado) ? 'colegiado LIKE "%'.str_replace(' ','%',$colegiado).'%"': null,
  strlen($centro) ? 'centros LIKE "%'.str_replace(' ','%',$centro).'%"': null */
];

array_push($condicoes, 'id_user = "'.$user['id'].'"', 'resultado = "e"');

// Remove posições vazias
$condicoes = array_filter($condicoes);

// Cláusula WHERE
$where = implode(' AND ', $condicoes);

// Qntd total de registros
// $qntAvaliacoes = Avaliacoes::getQntdRegistros($where);

// paginação
// $obPagination = new Pagination($qntAvaliacoes, $_GET['pagina']?? 1, 5);

// $avaliacoes = Avaliacoes::getRegistros($where, 'created_at', $obPagination->getLimite());

$idUser = $user['id'];

$query = '
select 
    r.*
from relatorios r
join (
    select 
        id local_id, nome, "dir_camp" tipo, "campi" local
    from campi where dir_campus_id = "'.$idUser.'" 
    union all
    select 
        id, nome, "chef_div" tipo, "campi" local
    from campi where chef_div_id = "'.$idUser.'"
    union all
    select 
        id, nome, "dir_ca" tipo, "centros" local
    from centros where dir_ca_id = "'.$idUser.'"
    union all
    select 
        id, nome, "coord" tipo, "colegiados" local
    from colegiados where coord_id = "'.$idUser.'"
) juncao
on 
(
    (juncao.local = "campi" AND r.ca_id = juncao.local_id)
    OR
    (juncao.local = "centros" AND r.ce_id = juncao.local_id)
    OR
    (juncao.local = "colegiados" AND r.co_id = juncao.local_id)
)
where 
    r.tramitar = 1
    AND r.last_result = "n"
';

// echo '<pre>';
// print_r($queryCargos);
// echo '</pre>';
// exit;

switch ($user['config']) {
    // Coordenador colegiado
    case 1:
        $query .= ' 
            AND r.etapa = 1 
            AND r.tipo <> "pa" 
        ';
    break;
    // chefe divisao
    case 3:
        $query .= ' 
            AND ( 
                (r.etapa = 1 AND r.tipo = "pa") 
                OR 
                (r.etapa = 2 AND r.tipo <> "pa") 
            )';
        break;
    
    case 4: // Diretor de campus - para 1ª etapa de relatórios finais para Agentes
        $query .= ' and r.etapa = 1  and r.tipo <> "pa" 
        
           and r.regra in (   
                           "d381559a-d1fe-11f0-9444-3a9832f2c2cb",
                           "d3815635-d1fe-11f0-9444-3a9832f2c2cb",
                           "d3815674-d1fe-11f0-9444-3a9832f2c2cb" 
                        )
        
        ';
    break;
    default:
        header('location: ../index.php?status=error');
        exit;
}

// 'fi','re','pr', 'pa'
function tipoRelatori($tp)
{
    switch ($tp) {
        case 'fi':
            return 'Final';
            break;
        case 're':
            return 'Final com pedido de renovação';
            break;
        case 'pr':
            return 'Final com pedido de prorrogação';
            break;
        case 'pa':
            return 'Parcial';
            break;
        default:
            return 'Tipo não definido';
            break;
    }
}



$avaliacoes = Outros::qry($query);

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
