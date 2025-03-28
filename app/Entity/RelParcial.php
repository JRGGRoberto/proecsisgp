<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;
use \App\Entity\UuiuD;


class RelParcial {

  public $id;
  public $idproj;
  public $periodo_ini;
  public $periodo_fim;
  public $atvd_per;
  public $alteracoes;
  public $atvd_prox_per;
  public $tramitar;
  public $created_at;
  public $updated_at;
  public $user;

//Dados referente a 
  public $ava_comentario;
  public $ava_publicar;
  public $ava_id;
  public $ava_dtsign;

/**
   * Método responsável por cadastrar uma nova pessoa no banco
   * @return boolean
   */
  public function cadastrar(){
    //INSERIR A REGISTRO NO BANCO
    $newId = UuiuD::gera(); //exec('uuidgen -r');
    $obDatabase = new Database('rel_parcial');


    $obDatabase->insert([
                            'id'            => $newId,
                            'idproj'        => $this->idproj,
                            'periodo_ini'   => $this->periodo_ini,
                            'periodo_fim'   => $this->periodo_fim,
                            'atvd_per'      => $this->atvd_per,
                            'alteracoes'    => $this->alteracoes,
                            'atvd_prox_per' => $this->atvd_prox_per,
                            'tramitar'      => $this->tramitar,
                            'created_at'    => date("Y-m-d H:i:s"),
                          //  'updated_at'  => $this->updated_at,
                            'user'          => $this->user
                       ]);

    //RETORNAR SUCESSO
    return $newId;
  }



  /**
   * Método responsável por atualizar REGISTRO no banco
   * @return boolean
   */
  public function atualizar(){ 
    return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                                'idproj'        => $this->idproj,
                                'periodo_ini'   => $this->periodo_ini,
                                'periodo_fim'   => $this->periodo_fim,
                                'atvd_per'      => $this->atvd_per,
                                'alteracoes'    => $this->alteracoes,
                                'atvd_prox_per' => $this->atvd_prox_per,
                                'tramitar'      => $this->tramitar,
                                'updated_at' => date("Y-m-d H:i:s"),
                                'user'       => $this->user
                              ]);
  }


  public function publicar(){
    return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                                'ava_comentario' => $this->ava_comentario,
                                'ava_publicar'   => 1,
                                'ava_id'         => $this->ava_id,
                                'ava_dtsign'     => date("Y-m-d H:i:s")
                              ]);
  }


  public function solicitarAlteracoes(){
    return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                                'ava_comentario' => $this->ava_comentario,
                                'ava_id'         => $this->ava_id,
                                'tramitar'      => 0,
                                'ava_dtsign'     => date("Y-m-d H:i:s")
                              ]);
  }


  /**
   * Método responsável por excluir a relatório_parcial do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('rel_parcial'))->delete('id = '.$this->id);
  }

  /**
   * Método responsável por obter as relatório_parcial do banco de dados
   * @param  string $whereagente
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function gets($where = null, $order = null, $limit = null){
    return (new Database('rel_parcial'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  /**
   * Método responsável por obter as relatório_parcial do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function get($id){
    $where = ' id = "'.$id.'" ';
    return (new Database('rel_parcial'))->select($where)
                                     ->fetchObject(self::class);
  }


  /**
   * Método responsável por obter a quantidade de registros
   * @param  integer $id
   * @return integer
   */
  public static function getQntd($where = null){
    return (new Database('rel_parcial'))->select($where, null, null, 'COUNT(*) as qtd')
                                  ->fetchObject()
                                  ->qtd;
  }
 
}