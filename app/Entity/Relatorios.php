<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

//id  ver	protocolo	regras	id_prof	tipo_exten	titulo	vigen_ini	vigen_fim	vigen_fim_orig	para_avaliar	estado	fase_seq	form	resultado	tp_instancia	id_instancia	qnt_fases
class Relatorios 
{
    public $id;
    public $idproj; 
    public $id_prof;
    public $ver;
    public $protocolo;
    public $titulo;
    public $tipo_exten;
    public $nome_prof;
    public $tipo;
    public $regra;
    public $ca_id;
    public $ce_id;
    public $co_id;
    public $tramitar;
    public $last_result;
    public $etapa;
    public $etapas;
    public $visita_tec_qtd;
    public $visita_tec_total;
    public $publicado;
    public $created_at;
    public $created_at_sf;


    public static function getRegistros($where = null, $order = null, $limit = null, $fields = '*')
        {
            return (new Database('relatorios'))->select($where, $order, $limit, $fields)
                                    ->fetchAll(PDO::FETCH_CLASS, self::class);
        }

    public static function getQntdRegistros($where = null)
    {
        return (new Database('relatorios'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }





}
