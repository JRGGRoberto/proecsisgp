<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Outros;
use App\Entity\Palavras;
use App\Entity\Projeto;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

// echo '<pre>';
//     print_r($user);
// echo '<pre>';
// exit;

// Busca

$nome_prof = filter_input(INPUT_GET, 'nome_prof', FILTER_SANITIZE_STRING);
$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
$campus = filter_input(INPUT_GET, 'campus', FILTER_SANITIZE_STRING);
$palavra = filter_input(INPUT_GET, 'palavra', FILTER_SANITIZE_STRING);
$fase_seq = filter_input(INPUT_GET, 'fase_seq', FILTER_SANITIZE_NUMBER_INT);
$diasParados = filter_input(INPUT_GET, 'diasParados', FILTER_SANITIZE_NUMBER_INT);

$campusUser = strtoupper($user['ca_cod']);

// $condicoes = [
//   strlen($titulo) ? ' p.titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
//   strlen($palavra) ? $palavra : null,
//   strlen($campus) ? ' p.campus LIKE "%'.str_replace(' ', '%', $campus).'%"' : null,
//   strlen($nome_prof) ? ' p.nome_prof LIKE "%'.str_replace(' ', '%', $nome_prof).'%"' : null,
//   strlen($fase_seq) ? 'a.fase_seq = ' . (int)$fase_seq : 'a.fase_seq >= 1', 'NOT (p.last_result = "a" AND (p.fase_seq = p.etapas))',
// ];

// print_r($condicoes);
// exit;

$whereQtd = '
  a.fase_seq = 1
  and not (p.last_result = "a" and (p.fase_seq = p.etapas))
'
;

if ($fase_seq) {
  $whereQtd .= ' and exists (
        select 1 from avaliacoes ax
        where ax.id_proj = p.id
          and ax.fase_seq = '.$fase_seq.'
    )'
  ;
}

if ($titulo) {
  $whereQtd .= ' 
    and p.titulo like "%'.$titulo.'%" 
  ';
}

if ($nome_prof) {
  $whereQtd .= 'and p.nome_prof like "%'.$nome_prof.'%"';
}

if ($campus) {
  $whereQtd .= 'and SUBSTRING(p.protocolo, 1, 2) = "'. $campus .'"';
}

if ($diasParados) { 
  $whereQtd .= '
    and exists (
        select 1 
        from avaliacoes ax
        where ax.id_proj = p.id
          and ax.fase_seq >= 1' . ($fase_seq ? ' AND ax.fase_seq = ' . $fase_seq : '') . '
          and DATEDIFF(IFNULL(ax.updated_at, NOW()), ax.created_at) >= 10
    )
 ';
}
 
$qryQuantidade = '
select count(distinct p.id) as qtd
from proj_inf_lv p
  inner join avaliacoes a on a.id_proj = p.id
  left join campi ca on ca.id = a.id_instancia
  left join centros ce on ce.id = a.id_instancia and ca.id is null
  left join colegiados co on co.id = a.id_instancia and ca.id is null and ce.id is null
  left join usuarios u on u.id = a.id_instancia and ca.id is null and ce.id is null and co.id is null
where '.$whereQtd.'
';


// echo '<pre>';
// print_r($qryQuantidade);
// echo '</pre>';
// exit;

$projetosQtd = Outros::qry($qryQuantidade);
// print_r($projetosQtd);
// exit;

$obPagination = new Pagination($projetosQtd[0]->qtd, $_GET['pagina'] ?? 1, 5);

$whereBase = '
  a.fase_seq = 1
  and not (p.last_result = "a" and (p.fase_seq = p.etapas))
';

$whereFases = '
  a.fase_seq >= 1
  and not (p.last_result = "a" and (p.fase_seq = p.etapas))
';



if ($fase_seq) {
  $whereBase .= ' and exists (
      select 1 from avaliacoes ax
      where ax.id_proj = p.id
        and ax.fase_seq = '.$fase_seq.'
  )';

  $whereFases .= ' and a.fase_seq = '.$fase_seq;

}

if ($titulo) {
  $whereBase .= ' 
    and p.titulo like "%'.$titulo.'%" 
  ';
}

if ($nome_prof) {
  $whereBase .= ' 
    and p.nome_prof like "%'.$nome_prof.'%"';
}

if ($campus) {
  $whereBase .= '  and SUBSTRING(p.protocolo, 1, 2) = "'. $campus .'"';
}

if ($diasParados) { 
  $whereBase .= '
    and exists (
        select 1 
        from avaliacoes ax
        where ax.id_proj = p.id
          and ax.fase_seq >= 1' . ($fase_seq ? ' AND ax.fase_seq = ' . $fase_seq : '') . '
          and DATEDIFF(IFNULL(ax.updated_at, NOW()), ax.created_at) >= 10
    )
 ';

  $whereFases .= ' and DATEDIFF(ifnull(a.updated_at, now()), a.created_at) >= 10';
}

 
$qry = '
select 
  p.id, p.ver, p.protocolo, p.titulo, p.tipo_exten, p.aprov, p.nome_prof,
  a.fase_seq,
  a.resultado,
  a.tp_instancia,
  coalesce(ca.nome, ce.nome, co.nome, u.nome) quem,
  DATE_FORMAT(a.created_at, "%d/%m/%Y") chegada,
  DATE_FORMAT(a.updated_at, "%d/%m/%Y") saida,
  DATEDIFF(ifnull(a.updated_at, now()), a.created_at) dias
from proj_inf_lv p
  inner join avaliacoes a on a.id_proj  = p.id
  left join campi  ca on ca.id =  a.id_instancia
  left join centros ce on ce.id =  a.id_instancia  and ca.id is null
  left join colegiados co on co.id =  a.id_instancia  and ca.id is null and ce.id is null
  left join usuarios u  on u.id =  a.id_instancia  and ca.id is null and ce.id is null and co.id is null
where '.$whereBase.'
group by p.id, a.fase_seq
order by p.id, a.fase_seq
limit '.$obPagination->getLimite().';
';

// echo '<pre>';
// print_r($qry);
// echo '</pre>';
// exit;

$qryFases = '
select 
  p.id, p.ver, p.protocolo, p.titulo, p.tipo_exten, p.aprov,
  a.resultado,
  a.fase_seq,
  a.tp_instancia,
  coalesce(ca.nome, ce.nome, co.nome, u.nome) quem,
  DATE_FORMAT(a.created_at, "%d/%m/%Y") chegada, 
  DATE_FORMAT(a.updated_at, "%d/%m/%Y") saida,
  DATEDIFF(ifnull(a.updated_at, now()), a.created_at) dias
from 
  proj_inf_lv p
  inner join avaliacoes a on a.id_proj = p.id
  left join campi ca on ca.id = a.id_instancia
  left join centros ce on ce.id = a.id_instancia and ca.id is null
  left join colegiados co on co.id = a.id_instancia and ca.id is null and ce.id is null
  left join usuarios u on u.id = a.id_instancia and ca.id is null and ce.id is null and co.id is null
where '.$whereFases.'
order by p.id, a.fase_seq
'
;

// echo '<pre>';
// print_r($qryFases);
// echo '</pre>';
// exit;



// $todosProjetos = Outros::qry($qryAdmin);
$fasesDoProjeto = Outros::qry($qryFases);
$projetosParados = Outros::qry($qry);


// Filtro de status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);

include '../includes/header.php';
include __DIR__.'/includes/listagemAll.php';
include '../includes/footer.php';
