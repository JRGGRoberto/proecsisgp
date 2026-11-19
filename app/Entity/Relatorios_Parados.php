<?php

namespace App\Entity;

use App\Db\Database;


#[\AllowDynamicProperties]
class Relatorios_Parados
{
    public $id_avaliacao;	
    public $id_rel;
    public $ver;
    public $tipo;	
    public $fase_seq;	
    public $fases;
    public $tramitar;	
    public $publicado;
    public $tp_instancia;	
    public $id_instancia;	
    public $resultado;
    public $form;
    public $idproj;
    public $pver;
    public $titulo;
    public $protocolo;
    public $nome_prof;
    public $instancia_nome;
    public $avaliador_id;
    public $avaliador_nome;
    public $avaliador_email;
    public $avaliador_funcao;
    public $created_at;
    public $fase_avaliacao;
    public $updated_at;
    public $dias_permanencia;

    public static function getRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('relatorios_parados'))->select($where, $order, $limit)
                                ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getQntdRegistros($where = null)
    {
        $where = !empty($where) ? 'where ' . $where : '';

        $query = '
            select count(1) as qtd
            from (
                select rp.id_rel
                from relatorios_parados rp
                '.$where.'
                group by rp.id_rel
            ) a;
        ';

        return (new Database('relatorios_parados'))
            ->execute($query)
            ->fetchObject()
            ->qtd;
    }

    public static function getRegistrosPendentes($campus) {
        $query = "
            select
                *,
                count(*) as relatorios_pendentes
            from relatorios_parados
            where resultado = 'n'
                and campus = '".$campus."'
                and avaliador_id is not null
            group by
                avaliador_id,
                avaliador_nome,
                avaliador_email,
                avaliador_funcao
            order by relatorios_pendentes desc
        ";

        return (new Database('relatorios_parados'))
            ->execute($query)
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getRegistrosPendentesByUsuario($id)
    {
        $query = "
            select
                *
            from
                relatorios_parados
            where
                resultado = 'n'
            and 
                avaliador_id = '".$id."'
            order by
                avaliador_nome, dias_permanencia desc
        ";

        return (new Database('relatorios_parados'))
            ->execute($query)
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
    
    

}
