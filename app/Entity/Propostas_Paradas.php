<?php

namespace App\Entity;

use App\Db\Database;

// id  ver	protocolo	regras	id_prof	tipo_exten	titulo	vigen_ini	vigen_fim	vigen_fim_orig	para_avaliar	estado	fase_seq	form	resultado	tp_instancia	id_instancia	qnt_fases
#[\AllowDynamicProperties]
class Propostas_Paradas
{
    public $id_projeto;	
    public $protocolo;	
    public $titulo;	
    public $tipo_exten;	
    public $nome_prof;	
    public $campus;	
    public $total_fases;	
    public $id_avaliacao;	
    public $form;	
    public $fase_avaliacao;	
    public $ver;	
    public $resultado;	
    public $tp_instancia;	
    public $id_instancia;	
    public $instancia_nome;	
    public $avaliador_id;	
    public $avaliador_nome;	
    public $avaliador_email;	
    public $avaliador_funcao;	
    public $aguardando_de;	
    public $created_at;	
    public $updated_at;	
    public $dias_permanencia;

    public static function getRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('propostas_paradas'))->select($where, $order, $limit)
                                ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
    public static function getQntdRegistros($where = null)
    {
        $where = !empty($where) ? 'WHERE ' . $where : '';

        $query = '
            select count(1) as qtd
            from (
                select pp.id_projeto
                from propostas_paradas pp
                ' . $where . '
                group by pp.id_projeto
            ) a
        ';

        return (new Database('propostas_paradas'))
            ->execute($query)
            ->fetchObject()
            ->qtd;
    }
}
