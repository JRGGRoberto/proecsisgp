<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;
use \App\Entity\UuiuD;

class RelFinal{

  public $id;
  public $idproj;
  public $tipo;
  public $periodo_renov_ini;
  public $periodo_renov_fim;
  public $periodo_prorroga_fim;
  public $ch_semanal;
  public $dim_mem_com_ex;
  public $dim_disc;
  public $dim_doce;
  public $dim_agent_estag;
  public $atividades;
  public $atvd_prox_per ;
  public $rel_tec_cien_executado;
  public $divulgacao;
  public $rel_finac;
  public $tramitar;
  public $last_result;
  public $etapa;
  public $etapas;
  public $created_at;
  public $updated_at;
  public $user;

  /**
   * Método responsável por cadastrar uma nova pessoa no banco
   * @return boolean
   */
  public function cadastrar(){


    $newId = UuiuD::gera(); //exec('uuidgen -r');
    //INSERIR A REGISTRO NO BANCO
    $obDatabase = new Database('rel_final');
    $obDatabase->insert([
                            'id'                     => $newId,
                            'idproj'                 => $this->idproj,
                            'tipo'                   => $this->tipo,
                            'periodo_renov_ini'      => $this->periodo_renov_ini,
                            'periodo_renov_fim'      => $this->periodo_renov_fim,
                            'periodo_prorroga_fim'   => $this->periodo_prorroga_fim,
                            'ch_semanal'             => $this->ch_semanal,
                            'dim_mem_com_ex'         => $this->dim_mem_com_ex,
                            'dim_disc'               => $this->dim_disc,
                            'dim_doce'               => $this->dim_doce,
                            'dim_agent_estag'        => $this->dim_agent_estag,
                            'atvd_prox_per'          => $this->atvd_prox_per,
                            'atividades'             => $this->atividades,
                            'rel_tec_cien_executado' => $this->rel_tec_cien_executado,
                            'divulgacao'             => $this->divulgacao,
                            'rel_finac'              => $this->rel_finac,
                            'tramitar'               => $this->tramitar,
                            'etapa'                  => 1,
                            'etapas'                 => 4,
                            'last_result'            => 'n',
                            'created_at'             => date("Y-m-d H:i:s"),
                            'user'                   => $this->user
                       ]);
    //RETORNAR SUCESSO
    return true;
  }



  /**
   * Método responsável por atualizar REGISTRO no banco
   * @return boolean
   */
  public function atualizar(){ 
      return (new Database('rel_final'))->update(' id = "'.$this->id.'" ',[
                                'idproj'                 => $this->idproj,
                                'tipo'                   => $this->tipo,
                                'periodo_renov_ini'      => $this->periodo_renov_ini,
                                'periodo_renov_fim'      => $this->periodo_renov_fim,
                                'periodo_prorroga_fim'   => $this->periodo_prorroga_fim,
                                'ch_semanal'             => $this->ch_semanal,
                                'dim_mem_com_ex'         => $this->dim_mem_com_ex,
                                'dim_disc'               => $this->dim_disc,
                                'dim_doce'               => $this->dim_doce,
                                'dim_agent_estag'        => $this->dim_agent_estag,
                                'atividades'             => $this->atividades,
                                'atvd_prox_per'          => $this->atvd_prox_per,
                                'rel_tec_cien_executado' => $this->rel_tec_cien_executado,
                                'divulgacao'             => $this->divulgacao,
                                'rel_finac'              => $this->rel_finac,
                                'tramitar'               => $this->tramitar,
                                'etapa'                  => $this->etapa,
                                'etapas'                 => $this->etapas,
                                'last_result'            => $this->last_result,
                                'updated_at'             => date("Y-m-d H:i:s"),
                                'user'                   => $this->user
                            ]);
    
  }
    

  /**
   * Método responsável por excluir a professor do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('rel_final'))->delete('id = "'.$this->id .'"');
  }

  /**
   * Método responsável por obter as professores do banco de dados
   * @param  string $whereagente
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function gets($where = null, $order = null, $limit = null){
    return (new Database('rel_final'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  /**
   * Método responsável por obter as professores do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function get($id){
    $where = ' id = "'.$id.'" ';
    return (new Database('rel_final'))->select($where)
                                     ->fetchObject(self::class);
  }


  /**
   * Método responsável por obter a quantidade de registros
   * @param  integer $id
   * @return integer
   */
  public static function getQntd($where = null){
    return (new Database('rel_final'))->select($where, null, null, 'COUNT(*) as qtd')
                                  ->fetchObject()
                                  ->qtd;
  }
 
}