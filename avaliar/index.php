<?php

require '../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Diversos;

//Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

if($user['is_admin'] != 1 ){
  header('location: ../index.php?status=error');
  exit;
}
$bossM = Diversos::getResponsavelLocal($user['id']);

$qryToPublicarL4 = '';


$nivel1 =
'
from 
  proj_inf prj
  inner join colegiados co on co.id = prj.para_avaliar
  inner join centros ce on ce.id = co.id_centro
  inner join campi ca on ca.id = ce.id_campi
  inner join responsaveis caa on ca.id = caa.id_cam_cen_col and caa.nivel_adm = '. $bossM->nivel_adm . '
where 
  prj.id_proj not in (select ava.id_proj from avaliacoes ava)
  and caa.id_avaliador = '. $bossM->id_avaliador . '
order by ca.id, ce.id, co.id
';

$nivel2 = "
from 
  proj_inf prj 
  inner join responsaveis r 
    on prj.para_avaliar = r.id_cam_cen_col 
    and r.nivel_adm = 2
where 
  prj.id_proj in 
  (
    select a.id_proj
       from avaliacoes a
    where 
       a.id_instancia = 1
       and a.resultado = 'a'
       and a.id_proj not in (
         select av.id_proj 
         from avaliacoes av 
         where av.id_instancia > 1)
   ) and r.id_avaliador = " . $bossM->id_avaliador  ;


   $nivel3 = "

   from 
     proj_inf prj 
     inner join colegiados co on co.id = prj.para_avaliar
     inner join centros ce on co.id_centro = ce.id
     inner join responsaveis r 
       on ce.id = r.id_cam_cen_col 
       and r.nivel_adm = 3
   where 
     prj.id_proj in 
     (
       select a.id_proj
          from avaliacoes a
       where 
          a.id_instancia = 2
          and a.resultado = 'a'
          and a.id_proj not in (
            select av.id_proj 
            from avaliacoes av 
            where av.id_instancia > 2)
      ) and r.id_avaliador = " . $bossM->id_avaliador  ;


   $qryToAvaliar  = 
'select
   prj.id_proj,
   prj.titulo,
   prj.tipo_extensao,
   prj.vigen_ini,
   prj.vigen_fim,
   prj.area_cnpq,
   prj.area_tema1,
   prj.area_tema2,
   prj.area_extensao,
   prj.linha_ext,
   prj.data 
   ';

switch($bossM->nivel_adm){
  case 1: $qryToAvaliar  .= $nivel1;
    break;
  case 2: $qryToAvaliar  .= $nivel2;
    break;
  case 3: $qryToAvaliar  .= $nivel3;
    break;
}


$projAvaliar = Diversos::qry($qryToAvaliar);

$nivel_adm = $bossM->nivel_adm;
if($nivel_adm == 1){
  $nivel_adm = '1 , 4';
}

$qryJaAvaliados = '
  select 
    pr.id_proj,
    pr.titulo,
    pr.tipo_extensao,
    pr.vigen_ini,
    pr.vigen_fim,
    pr.area_cnpq,
    pr.area_tema1,
    pr.area_tema2,
    pr.area_extensao,
    pr.linha_ext,
    pr.data, 
    ava.id
  from 
    proj_inf pr
    inner join avaliacoes ava on pr.id_proj = ava.id_proj 
    inner join colegiados co  on pr.para_avaliar = co.id
    inner join centros ce on  co.id_centro = ce.id
       and ava.id_instancia in (  '. $nivel_adm .') ';



       $qryToPublicarL4 = "
       select
        prj.id_proj,
        prj.titulo,
        prj.tipo_extensao,
        prj.vigen_ini,
        prj.vigen_fim,
        prj.area_cnpq,
        prj.area_tema1,
        prj.area_tema2,
        prj.area_extensao,
        prj.linha_ext,
        prj.data , 
        r.id_avaliador
     from 
          proj_inf prj 
          inner join colegiados co on co.id = prj.para_avaliar
          inner join centros ce on co.id_centro = ce.id
          inner join responsaveis r 
            on ce.id = r.id_cam_cen_col 
            and r.nivel_adm = 1
        where 
          prj.id_proj in 
          (
            select a.id_proj
               from avaliacoes a
            where 
               a.id_instancia = 3
               and a.resultado = 'a'
               and a.id_proj not in (
                 select av.id_proj 
                 from avaliacoes av 
                 where av.id_instancia > 3)
           ) and r.id_avaliador =" . $bossM->id_avaliador  ;
      
  
           $projToPublicarL4;
  switch($bossM->nivel_adm){
      case 1: $qryJaAvaliados .= ' and ce.id_campi = '. $bossM->id_cam_cen_col ;
        $projToPublicarL4 = Diversos::qry($qryToPublicarL4);

        break;
      case 2: $qryJaAvaliados .= ' and co.id = '. $bossM->id_cam_cen_col ;
        break;
      case 3: $qryJaAvaliados .= ' and ce.id = '. $bossM->id_cam_cen_col ;
        break;
  }

  $qryJaAvaliados .= ' order by ava.id desc';

  $projAvaliados = Diversos::qry($qryJaAvaliados);

  
include '../includes/header.php';

include __DIR__.'/includes/listagem.php';

include '../includes/footer.php';
