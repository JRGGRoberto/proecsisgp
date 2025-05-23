<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;
use \App\Entity\UuiuD;
use \App\Entity\HistRelatorios;
use \App\Session\Login;
Login::requireLogin();


class RelParcial {

  public $id;
  public $idproj;
  public $periodo_ini;
  public $periodo_fim;
  public $atvd_per;
  public $alteracoes;
  public $atvd_prox_per;
  public $tramitar;
  public $last_result;
  public $created_at;
  public $updated_at;
  public $user;

//Dados referente a 
  public $ava_comentario;
  public $ava_publicar;
  public $ava_id;
  public $tp_avaliador; // ('ca','ce','co','pf','dc')
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
                            'last_result'   => 'n',
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
    $lastRult = $this->last_result;
    if ($this->tramitar == 1){
      $lastRult = 'n';
    } 

    return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                                'idproj'        => $this->idproj,
                                'periodo_ini'   => $this->periodo_ini,
                                'periodo_fim'   => $this->periodo_fim,
                                'atvd_per'      => $this->atvd_per,
                                'alteracoes'    => $this->alteracoes,
                                'atvd_prox_per' => $this->atvd_prox_per,
                                'tramitar'      => $this->tramitar,
                                'last_result'   => $lastRult,
                                'updated_at' => date("Y-m-d H:i:s"),
                                'user'       => $this->user
                              ]);
  }


  public function publicar(){
    $user = Login::getUsuarioLogado();
    $tpAvaliadorArray = ['pf', 'co',  'ce', 'ca', 'dc'];
    $histRelatorio = new HistRelatorios();
    $result = 'a';

    $histRelatorio->id_relatorio = $this->id;
    $histRelatorio->tp_avaliador = $tpAvaliadorArray[$user['config']];
    $histRelatorio->id_instancia = $this->ava_id;
    $histRelatorio->resultado = $result;
    $histRelatorio->ava_comentario = $this->ava_comentario;
    $histRelatorio->tp_relatorio = 'pa';
    $histRelatorio->user =  $this->ava_id;

    return    (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                        'ava_comentario' => null,
                        'ava_publicar'   => 1,
                        'last_result'    => $result,
                        'ava_id'         => $this->ava_id,
                        'ava_dtsign'     => date("Y-m-d H:i:s")
               ], 
               $histRelatorio->cadastrar()
                      
    );
  }


  public function solicitarAlteracoes(){
    $user = Login::getUsuarioLogado();
    $tpAvaliadorArray = ['pf', 'co',  'ce', 'ca', 'dc'];
    $histRelatorio = new HistRelatorios();
    $result = 'r';

    $histRelatorio->id_relatorio = $this->id;
    $histRelatorio->tp_avaliador = $tpAvaliadorArray[$user['config']];
    $histRelatorio->id_instancia = $this->ava_id;
    $histRelatorio->resultado = $result;
    $histRelatorio->ava_comentario = $this->ava_comentario;
    $histRelatorio->tp_relatorio = 'pa';
    $histRelatorio->user =  $this->ava_id;

    return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ',[
                                'ava_comentario' => $this->ava_comentario,
                                'ava_id'         => $this->ava_id,
                                'tramitar'       => 0,
                                'ava_publicar'   => 0,
                                'last_result'    => $result,
                                'ava_dtsign'     => date("Y-m-d H:i:s")
                              ],
                            $histRelatorio->cadastrar()
    );
  }


  /**
   * Método responsável por excluir a relatório_parcial do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('rel_parcial'))->delete('id = "'.$this->id.'"');
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