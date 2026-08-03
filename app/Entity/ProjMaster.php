<?php

namespace App\Entity;

use App\Db\Database;

// id  ver	protocolo	regras	id_prof	tipo_exten	titulo	vigen_ini	vigen_fim	vigen_fim_orig	para_avaliar	estado	fase_seq	form	resultado	tp_instancia	id_instancia	qnt_fases
class ProjMaster
{
    public $id;
    public $ver;
    public $protocolo;
    public $regras;
    public $id_prof;
    public $tpprop;
    public $coord;
    public $tipo_exten;
    public $titulo;
    public $resumo;
    public $vigen_ini;
    public $vigen_fim;
    public $vigen_fim_orig;
    public $para_avaliar;
    public $colegiado;
    public $estado;
    public $fase_seq;
    public $form;
    public $resultado;
    public $tp_instancia;
    public $id_instancia;
    public $qnt_fases;
    public $edt;

    public static function getRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('projmaster'))->select($where, $order, $limit)
                                ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getQntdRegistros($where = null)
    {
        return (new Database('projmaster'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }

    public static function getRegistro($id)
    {
        return (new Database('projmaster'))->select('id = "'.$id.'"', null, null)
                                      ->fetchObject();
    }

    public static function getRelatoriosPendentes($idProfessor)
    {
        $qryInadimplentes = "    
            select
                p.id,
                p.id_prof,
                p.titulo,
                p.vigen_ini AS inicio,
                p.vigen_fim AS fim,
                p.estado,

                -- rel parcial
                case
                when p.estado = 3
                    and p.created_at >= '2026-06-01'
                    and timestampdiff(month, p.vigen_ini, p.vigen_fim) > 12
                    and date_add(p.vigen_ini, interval 12 month) < current_date()
                    then
                        case
                            when rp.id is null then 'rel parcial pendente'
                            else 'enviado'
                        end
                    else 'nao precisa'
                end as envio_rel_parcial,

                -- rel final
                case
                    when p.estado = 4 then 'rel final pendente'
                    else 'nao precisa'
                end as envio_rel_final
            from projmaster p

            left join relats rp
                on rp.idproj = p.id
                and rp.tipo = 'pa'
                and rp.tramitar = 1
                and rp.publicado = 1

            left join relats rf
                on rf.idproj = p.id
                and rf.tipo in ('fi','re','pr')
                and rf.tramitar = 1
                and rf.publicado = 1
                and rf.last_result = 'a'
                and rf.fase_atual = rf.fases

            where p.id_prof = '".$idProfessor."'
        ";

        return (new Database())->execute($qryInadimplentes, [
            'id_prof' => $idProfessor,
        ])->fetchAll(\PDO::FETCH_ASSOC);
    }
}
