<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

//id  ver	protocolo	regras	id_prof	tipo_exten	titulo	vigen_ini	vigen_fim	vigen_fim_orig	para_avaliar	estado	fase_seq	form	resultado	tp_instancia	id_instancia	qnt_fases
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
}

?>