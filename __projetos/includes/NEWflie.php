create or replace view projmaster as 
select 
   p.id, p.ver, p.protocolo, COALESCE(ca.nome, ca1.nome, ag1.nome ) campus, 
   p.regras, p.id_prof, if(isnull(ag.id), 'pf', 'ag') tpprop, COALESCE(pf.nome, ag.nome) coord, p.tipo_exten, p.titulo, p.resumo,
   p.para_avaliar, p.edt, COALESCE(co.nome, ca.nome ) submetido_para,
   ce.id ce_id, ce.nome centro,
   a.fase_seq , a.form, COALESCE(a.resultado, p.last_result) resultado, a.tp_instancia, a.id_instancia, r.qnt_fases, 
   p.vigen_ini , p.vigen_fim, p.vigen_fim_orig, 
   case p.cancelado 
      when 1 then 9 -- 'Cancelado'
      else 
       
      case r.aprov_auto 
           when 1 then  
              case 
                 when  p.vigen_ini > now() then 2 -- 0
                 when  now() BETWEEN p.vigen_ini and p.vigen_fim   then 3 -- EM EXECUÇÃO
                 else 4 -- 'Finalizado' 
              end 
      
              else  
              case 
                 when a.resultado = 'a' and r.qnt_fases = a.fase_seq then -- 'Aprovado' 
                    case     
                       when  p.vigen_ini > now() then 0
                       when  now() BETWEEN p.vigen_ini and p.vigen_fim   then 3 -- EM EXECUÇÃO
                       else 4                                                   -- 'Finalizado' 
                    end
                 else  if(p.para_avaliar = -1, 0, 1) -- 0 = NÃO SUBMETIDO / 1 = EM AVALIAÇÃO
              end
        end 
      end estado,
   r.aprov_auto
FROM 
  (
     SELECT p.id, p.ver, p.protocolo, p.regras, p.id_prof, p.nome_prof, p.id_colegiado, p.tipo_exten, p.titulo, p.tide, p.vigen_ini, p.vigen_fim, p.vigen_fim_orig, p.ch_semanal, p.ch_total, p.situacao, p.cnpq_garea, p.cnpq_area, p.cnpq_sarea, p.area_cnpq, p.area_tema1, p.area_tema2, p.area_extensao, p.linh_ext, p.resumo, p.descricao, p.objetivos, p.public_alvo, p.metodologia, p.prodserv_espe, p.contribuicao, p.contrap_nofinac, p.municipios_abr, p.n_cert_prev, p.`data`, p.outs_info, p.para_avaliar, p.last_result, p.edt, p.created_at, p.updated_at, p.`user`, p.acec, p.vinculo, p.tituloprogvinc, p.finac, p.finacorgao, p.finacval, p.justificativa, p.cronograma, p.referencia, p.parcanomes, p.parceria, p.parcaatribuic, p.obs, p.cancelado, p.canceljustif
     FROM projetos p 
     inner join  (
                   select plv.id, max(plv.ver) ver  FROM  projetos plv group by plv.id ) p2 on (p.id, p.ver) = (p2.id, p2.ver )
  ) p   
  inner join regras r on p.regras = r.id 
  left join 
     (
       select 
          aa.id_proj, aa.ver, aa.fase_seq , aa.form, aa.resultado, aa.tp_instancia, aa.id_instancia
       from 
          avaliacoes aa
       inner join 
          (
            select a.id_proj, max(a.fase_seq) fs
            from avaliacoes a
            group by a.id_proj
          ) a
           on     (aa.id_proj, aa.fase_seq ) = (a.id_proj , a.fs ) 
  ) a  on (p.id, p.ver) = (a.id_proj, a.ver) 
  left join (
    select 
      rd.id_reg id_regra, max(rd.sequencia) qnt_fases from regras_defin rd 
    group by rd.id_reg
  ) r on r.id_regra = p.regras
  left join agentes ag on ag.id =  p.id_prof
  left join professores pf on pf.id = p.id_prof and ag.id is null
  left join colegiados co on co.id = p.para_avaliar 
  left join centros ce on ce.id = co.centro_id
  left join campi ca on ca.codigo  = LOWER(SUBSTR(p.protocolo,1,2))
  left join (
            select ca.nome, pf.id 
            from 
              professores pf
            inner join colegiados co on co.id = pf.id_colegiado 
            inner join centros ce    on ce.id  = co.centro_id 
            inner join campi ca     on ca.id = ce.campus_id 
       ) ca1 on ca1.id = p.id_prof and p.protocolo is null
    left join (
            select ca.nome, ag.id 
            from 
              agentes ag
              inner join campi ca     on ca.id = ag.lotacao  
       ) ag1 on ag1.id = p.id_prof and p.protocolo is null and  ca1.nome is null
;