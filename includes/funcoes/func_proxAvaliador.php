<?php

use App\Entity\Diversos;

require '../vendor/autoload.php';

function getProximoAvaliador($idProjeto){
    $sql = "
        select 
            a.fase_seq,
            a.tp_instancia,
            COALESCE(uca.id,  uco.id,   pf.id,  uce.id,  udc.id  ) as id,
            COALESCE(uca.nome,  uco.nome,   pf.nome,  uce.nome,  udc.nome  ) as nome,                
            COALESCE(uca.email, uco.email,  pf.email, uce.email, udc.email ) as email, 
            COALESCE(ca.nome, ce.nome, co.nome, 'Parecerista') as local,
            CASE a.tp_instancia
                WHEN 'dc' THEN 'Diretor de Campus'
                WHEN 'ca' THEN 'Chefe de Divisão'
                WHEN 'ce' THEN 'Diretor(ª) de Centro de Área'
                WHEN 'co' THEN 'Coordenador(ª)'
                ELSE 'Professor(ª)'
            END funcao
        from avaliacoes a
            left join campi ca on a.id_instancia = ca.id and a.tp_instancia = 'ca'
            left join campi dc on a.id_instancia = dc.id and a.tp_instancia = 'dc'
            left join centros ce on a.id_instancia = ce.id and a.tp_instancia = 'ce'
            left join colegiados co on a.id_instancia = co.id and a.tp_instancia = 'co'
            left join userprof pf on a.id_instancia = pf.id and a.tp_instancia = 'pf'
            left join userprof udc on dc.dir_campus_id = udc.id 
            left join userprof uca on ca.chef_div_id = uca.id
            left join userprof uce on ce.dir_ca_id = uce.id
            left join userprof uco on co.coord_id = uco.id
        where 
            a.id_proj = '{$idProjeto}'
            and a.resultado = 'e'
        order by a.fase_seq asc
    ";

    return Diversos::qry($sql)[0] ?? null;
}