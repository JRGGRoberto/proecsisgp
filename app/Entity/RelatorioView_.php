<?php

namespace App\Entity;

use App\Db\Database;

class RelatorioView
{
    public $id;
    public $ver;
    public $idproj;
    public $regra;
    public $tipo_relatorio;

    public $periodo_ini;
    public $periodo_fim;
    public $visita_tec_qtd;

    public static function baseQuery($where = null)
    {
        return (new Database('relats r'))
            ->select($where, null, null, '
                r.*,
                rg.detalhe AS tipo_relatorio,

                COALESCE(rf.visita_tec_qtd, rp.visita_tec_qtd) AS visita_tec_qtd,

                COALESCE(rf.periodo_renov_ini, rp.periodo_ini) AS periodo_ini,
                COALESCE(rf.periodo_renov_fim, rp.periodo_fim) AS periodo_fim
            ')
            ->join('regras rg', 'rg.id = r.regra AND rg.tp_regra = "relatorios"')

            ->join('rel_detal_final rf',
                'rf.id = r.id AND rg.detalhe IN ("fi","pr","re")',
                'LEFT')

            ->join('rel_detal_parcial rp',
                'rp.id = r.id AND rg.detalhe = "pa"',
                'LEFT');
    }

    public static function getAll($where = null)
    {
        return self::baseQuery($where)
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getById($id)
    {
        return self::baseQuery('r.id="'.$id.'"')
            ->fetchObject(self::class);
    }

    public static function getFinais()
    {
        return self::baseQuery('rg.detalhe IN ("fi","pr","re")')
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getParciais()
    {
        return self::baseQuery('rg.detalhe = "pa"')
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}
