<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Avaliar1{

  public $id;
  public $id_chefdiv;
  public $id_proj;
  public $resutado;
  public $ata;
  public $dt_av;
  public $updated_at;
  public $user;
  
  /**
   * Método responsável por obter as registros do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function getRegistros($where = null, $order = null, $limit = null){
    return (new Database('avali_chef_div'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

/**
   * Método responsável por obter a quantidade de registros
   * @param  integer $id
   * @return integer
   */
  public static function getQntdRegistros($where = null){
    return (new Database('avali_chef_div'))->select($where, null, null, 'COUNT(*) as qtd')
                                  ->fetchObject()
                                  ->qtd;
  }

  /**
   * Método responsável por buscar um Registro com base em seu ID
   * @param  integer $id
   * @return Colegiado
   */
  public static function getRegistro($id_proj, $resutado){
    return (new Database('avali_chef_div'))->select('id_proj = '.$id_proj.'  and resutado = "'. $resutado. '"')
                                  ->fetchObject(self::class);
  }

  /**
   * Método responsável por excluir a Registro do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('avali_chef_div'))->delete('id = '.$this->id);
  }

  /**
   * Método responsável por atualizar a Registro no banco
   * @return boolean
   */
  public function atualizar(){
    return (new Database('avali_chef_div'))->update('id = '.$this->id,[
                                                                'id_chefdiv' => $this->id_chefdiv,
                                                                'id_proj' => $this->id_proj,
                                                                'resutado' => $this->resutado,
                                                                'ata' => $this->ata,
                                                                'dt_av' => date("Y-m-d H:i:s"),
                                                                'updated_at' => date("Y-m-d H:i:s"),
                                                                'user' => $this->user 
                                                              ]);
  }

  /**
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function cadastrar(){
    //DEFINIR A DATA
    // $this->data = date('Y-m-d H:i:s');
    $obDatabase = new Database('avali_chef_div');
    $this->id = $obDatabase->insert([
                                      'id_chefdiv' => $this->id_chefdiv,
                                      'id_proj' => $this->id_proj,
                                      'resutado' => $this->resutado,
                                      'ata' => $this->ata,
                                      'dt_av' => date("Y-m-d H:i:s"),
                                      'user' => $this->user
                                    ]);

    //RETORNAR SUCESSO
    return true;
  }


}