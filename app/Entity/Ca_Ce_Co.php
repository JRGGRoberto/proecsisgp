<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Ca_Ce_Co{

  public $ca_id;
  public $campus;
  public $codcam;
  public $dir_campus_id;
  public $dir_camp;
  public $dc_mail;
  public $chef_div_id;
  public $chef;
  public $chef_mail;
  public $ce_id;
  public $centros;
  public $codcentro;
  public $dir_ca_id;
  public $dir_ca;
  public $ce_mail;
  public $co_id;
  public $colegiado;
  public $coord_id;
  public $coord;
  public $co_mail;
  public $tipo;

  /**
  * Método responsável por obter as registros do banco de dados
  * @param  string $where
  * @param  string $order
  * @param  string $limit
  * @return array
  */
  // Exibe as informações
  public static function getRegistros($where = null, $order = null, $limit = null, $fields = '*'){
    return (new Database('ca_ce_co'))->select($where, $order, $limit, $fields)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
}