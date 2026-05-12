<?php

require '../vendor/autoload.php';

use App\Entity\Outros;

$idCand = $_GET['ca'];

$qryCurInsc = '
   select 
      p.id, 
      p.prof, p.prog, p.campus, p.colegiado, 
      DATE_FORMAT(i.created_at, "%d/%m/%Y") em,
      p.aberto
    from
      divulga_proj p
      left join  inscricao i  on i.id_prog = p.id and i.id_can =  "'.$idCand.'"
  ';

$curInscritos = Outros::qry($qryCurInsc);

echo json_encode($curInscritos);
