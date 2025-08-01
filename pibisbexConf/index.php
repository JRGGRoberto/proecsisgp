<?php

require '../vendor/autoload.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\Outros;

$qry =
"
select 
   ppa.id,
   u.nome,  u.email, u.ca_nome campus, u.co_nome colegiado,
   (select concat(p.nomeproj, ' ',p.doit, ' ', p.total) from pibispibex_v p where p.aval_id = pp.aval_id order by 1 limit 1 offset 0) prj1,
   (select concat(p.nomeproj, ' ',p.doit, ' ', p.total)  from pibispibex_v p where p.aval_id = pp.aval_id order by 1 limit 1 offset 1) prj2,
   (select concat(p.nomeproj, ' ',p.doit, ' ', p.total)  from pibispibex_v p where p.aval_id = pp.aval_id order by 1 limit 1 offset 2) prj3,
   (select concat(p.nomeproj, ' ',p.doit, ' ', p.total)  from pibispibex_v p where p.aval_id = pp.aval_id order by 1 limit 1 offset 3) prj4
FROM  
   pibis_pibex_avaliadores ppa
   left join usuarios u on ppa.id  = u.id 
   left join pibispibex_v pp on pp.aval_id  = ppa.id
group by 2
order by 2
";

$lista = Outros::qry($qry);

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
