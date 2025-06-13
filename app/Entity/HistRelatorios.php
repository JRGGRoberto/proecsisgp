<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;
use \App\Entity\UuiuD;

class HistRelatorios{

  public $id;
  public $id_relatorio;
  public $tp_avaliador;
  public $id_instancia;
  public $etapa;
  public $resultado;
  public $ava_comentario;
  public $tp_relatorio;
  public $created_at;
  public $updated_at;
  public $user;
  
  /**
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function cadastrar(){
    $newId = UuiuD::gera();
    //INSERIR A VAGA NO BANCO
    $obDatabase = new Database('hist_relatorios');
    $obDatabase->insert([ 
                            'id'             =>    $newId,
                            'id_relatorio'   =>    $this->id_relatorio,
                            'tp_avaliador'   =>    $this->tp_avaliador,
                            'id_instancia'   =>    $this->id_instancia,
                            'etapa'          =>    $this->etapa,
                            'resultado'      =>    $this->resultado,
                            'ava_comentario' =>    $this->ava_comentario,
                            'tp_relatorio'   =>    $this->tp_relatorio,
                            'created_at'     =>    date("Y-m-d H:i:s"),
                            'user'           =>    $this->user       
                        ]);

    //RETORNAR SUCESSO
    return true;
  }

  /**
   * Método responsável por atualizar a Registro no banco
   * @return boolean
   */
  public function atualizar(){
    return (new Database('hist_relatorios'))->update(
                                           'id = "'.$this->id.'" ',[
                                      'id_relatorio'   => $this->id_relatorio,
                                      'tp_avaliador'   => $this->tp_avaliador,
                                      'id_instancia'   => $this->id_instancia,
                                      'resultado'      => $this->resultado,
                                      'ava_comentario' => $this->ava_comentario,
                                      'tp_relatorio'   => $this->tp_relatorio,
                                      'updated_at'     => date("Y-m-d H:i:s"),
                                      'user'           => $this->user       
                                  ]);

  }

  /**
   * Método responsável por obter os registros do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function getRegistros($where = null, $order = null, $limit = null){
    return (new Database('hist_relatorios_v'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

/**
   * Método responsável por obter a quantidade de registros
   * @param  integer $id
   * @return integer
   */
  public static function getQntdRegistros($where = null){
    return (new Database('hist_relatorios'))->select($where, null, null, 'COUNT(*) as qtd')
                                  ->fetchObject()
                                  ->qtd;
  }

  /**
   * Método responsável por buscar um Registro com base em seu ID
   * @param  integer $id
   * @return HistRelatorios
   */
  public static function getRegistro($id){
        return (new Database('hist_relatorios'))->select('id = "'.$id.'"')
                                  ->fetchObject(self::class);
  }

  /**
   * Método responsável por excluir a Registro do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('hist_relatorios'))->delete('id = "'.$this->id.'"');
  }



}