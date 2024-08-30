<?php

require './vendor/autoload.php';

use App\Entity\Outros;
use App\Session\Login;

$user = Login::getUsuarioLogado();
$id = $user['id'];
$query = Outros::q('select * from userprof where id = "'.$id.'" ');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<pre>';
echo '$user:';
print_r($user);
echo '<hr>';
echo 'select userprof:';
print_r($query);
echo '</pre>';
echo '<hr>';
phpinfo();

extract($_REQUEST);

/*
CREATE or REPLACE VIEW `userprof` AS
select
   `p`.`id` AS `id`,`p`.`nome` AS `nome`,
   `p`.`cpf` AS `cpf`,`p`.`lattes` AS `lattes`,`p`.`titulacao` AS `titulacao`,
   `p`.`email` AS `email`,`p`.`telefone` AS `telefone`,
   `p`.`id_colegiado` AS `id_colegiado`,
   `p`.`cat_func` AS `cat_func`,
   `p`.`ativo` AS `ativo`,`p`.`senha` AS `senha`,
   `p`.`adm` AS `adm`,`p`.`created_at` AS `created_at`,
   `p`.`updated_at` AS `updated_at`,`p`.`user` AS `user`,
   `ccc`.`ca_id` AS `ca_id`,`ccc`.`codcam` AS `codcam`,
   `ccc`.`campus` AS `campus`,`ccc`.`chef_div_id` AS `chef_div_id`,`ccc`.`chef` AS `chef`,
   `ccc`.`ce_id` AS `ce_id`,`ccc`.`codcentro` AS `codcentro`,
   `ccc`.`centros` AS `centros`,`ccc`.`dir_ca_id` AS `dir_ca_id`,
   `ccc`.`dir_ca` AS `dir_ca`,`ccc`.`co_id` AS `co_id`,
   `ccc`.`colegiado` AS `colegiado`,
   `ccc`.`coord_id` AS `coord_id`,
   `ccc`.`coord` AS `coord`,
   (case
        when (`p`.`id` = `ccc`.`coord_id`) then 'Coordenador'
        when (`p`.`id` = `ccc`.`dir_ca_id`) then 'Diretor de Centro'
        when (`p`.`id` = `ccc`.`chef_div_id`) then 'Chefe de Divisão' else 'comum' end) AS `nivel`,(case
        when (`p`.`id` = `ccc`.`coord_id`) then 3
        when (`p`.`id` = `ccc`.`dir_ca_id`) then 2
        when (`p`.`id` = `ccc`.`chef_div_id`) then 1 else 0 end) AS `niveln`,(case
        when (`p`.`id` = `ccc`.`coord_id`) then 'co'
        when (`p`.`id` = `ccc`.`dir_ca_id`) then 'ce'
        when (`p`.`id` = `ccc`.`chef_div_id`) then 'ca'
    else 'pf' end) AS `tpnivel`
from
   `professores` `p` join `ca_ce_co` `ccc` on `ccc`.`co_id` = `p`.`id_colegiado`


CREATE or REPLACE VIEW `usuarios` AS
select
   `a`.`id` AS `id`,`a`.`nome` AS `nome`,
   `a`.`email` AS `email`,
   `a`.`lotacao` AS `lota_id`,
   `c`.`nome` AS `lota_nome`,
   `a`.`senha` AS `senha`,
   `a`.`config` AS `config`,
   'na' AS `ce_id`,
   'na' AS `ce_cod`,
   'na' AS `ce_nome`,
   'na' AS `co_id`,
   'na' AS `co_nome`,
   'agente' AS `tipo`
from
 `agentes` `a` join `campi` `c` on `a`.`lotacao` = `c`.`id` where `a`.`ativo` = 1
union all
select `p`.`id` AS `id`,
   `p`.`nome` AS `nome`,
   `p`.`email` AS `email`,
   `ca`.`id` AS `lota_id`,
   `ca`.`nome` AS `lota_nome`,
   `p`.`senha` AS `senha`,
   (case
       when (`p`.`id` = `co`.`coord_id`) then 1
       when (`p`.`id` = `ce`.`dir_ca_id`) then 2
    else 0 end) AS `config`,
    `ce`.`id` AS `ce_id`,
    `ce`.`codigo` AS `ce_cod`,
    `ce`.`nome` AS `ce_nome`,
    `co`.`id` AS `co_id`,
    `co`.`nome` AS `co_nome`,
    'prof' AS `tipo`
from (((`professores` `p` join `colegiados` `co` on((`p`.`id_colegiado` = `co`.`id`))) join `centros` `ce` on((`co`.`centro_id` = `ce`.`id`))) join `campi` `ca` on((`ce`.`campus_id` = `ca`.`id`))) where (`p`.`ativo` = 1)
*/
