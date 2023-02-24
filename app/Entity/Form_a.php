<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Form_a{

  public $id_proj;
  public $ver_proj;
  public $id_avaliacao;
  public $id_avaliador;

  public $r3_1;
  public $r3_2;
  public $r3_3;
  public $r3_4;
  public $r3_5;
  public $r3_6;
  public $r3_7;
  public $r4_1;
  public $r4_2;
  public $r4_3;
  public $r4_4;
  public $r4_5;
  public $solicitacoes;
  public $parecer;

  public $cidade;  
  public $whosigns; // Nome fulando + cargo 
  public $dateAssing;
  public $resultado;

  public $created_at;
  public $updated_at;
  public $user;

  /**
  * Método responsável por buscar um Registro com base em seu ID
  * @param  string $id
  * @return Colegiado
  */
  public static function getRegistro($id_proj, $ver_proj){
    return (new Database('form_a'))->select('(id_proj, ver_proj)  = ("'.$id_proj.'", "'.$ver_proj.'")')
                                  ->fetchObject(self::class);
  }


}
