<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Projeto{
  
  public $id;
  public $ver;
  public $regras;
  public $id_prof;
  public $nome_prof;
  public $id_colegiado;
  public $tipo_exten;
  public $titulo;
  public $tide;
  public $vigen_ini;
  public $vigen_fim;
  public $ch_semanal;
  public $ch_total;
  public $situacao;
  public $area_cnpq;
  public $area_tema1;
  public $area_tema2;
  public $area_extensao;
  public $linh_ext;
  public $resumo;
  public $descricao;
  public $objetivos;
  public $public_alvo;
  public $metodologia;
  public $prodserv_espe;
  public $contribuicao;
  public $contrap_nofinac;
  public $municipios_abr;
  public $n_cert_prev;
  public $data;
  public $outs_info;
  public $para_avaliar;
  public $edt;
  public $created_at;
  public $updated_at;
  public $user;

  /**
   * Método responsável por cadastrar um novo projeto no banco
   * @return boolean
   */
  public function cadastrar(){

    //INSERIR PROJETO NO BANCO
    $obDatabase = new Database('projetos');
    $newId = exec('uuidgen -r');
    is_null($this->ver) ? $this->ver = 0 : $this->ver;
    $this->id = $obDatabase->insert([
                                       'id' => $newId,
                                       'ver' =>   $this->ver,
                                       'regras' =>  "6204ba97-7f1a-499e-a17d-118d305bf7e4", //$this->regras,
                                       'id_prof' => $this->id_prof,
                                       'nome_prof' => $this->nome_prof,
                                       'id_colegiado' => $this->id_colegiado,
                                       'tipo_exten' => $this->tipo_exten,
                                       'titulo' => $this->titulo,
                                       'tide' => $this->tide,
                                       'vigen_ini' => $this->vigen_ini,
                                       'vigen_fim' => $this->vigen_fim,
                                       'ch_semanal' => $this->ch_semanal,
                                       'ch_total' => $this->ch_total,
                                       'situacao' => $this->situacao,
                                       'area_cnpq' => $this->area_cnpq,
                                       'area_tema1' => $this->area_tema1,
                                       'area_tema2' => $this->area_tema2,
                                       'area_extensao' => $this->area_extensao,
                                       'linh_ext' => $this->linh_ext,
                                       'resumo' => $this->resumo,
                                       'descricao' => $this->descricao,
                                       'objetivos' => $this->objetivos,
                                       'public_alvo' => $this->public_alvo,
                                       'metodologia' => $this->metodologia,
                                       'prodserv_espe' => $this->prodserv_espe,
                                       'contribuicao' => $this->contribuicao,
                                       'contrap_nofinac' => $this->contrap_nofinac,
                                       'municipios_abr' => $this->municipios_abr,
                                       'n_cert_prev' => $this->n_cert_prev,
                                       'data' => $this->data,
                                       'outs_info' => $this->outs_info,
                                       'para_avaliar' => -1,
                                      // 'created_at' => $this->created_at,
                                      // 'updated_at' => date("Y-m-d H:i:s"),
                                       'user' => $this->user
                                    ]);

    //RETORNAR SUCESSO
    return $this->id ;
  }

  /**
   * Método responsável por atualizar a PROJETO no banco
   * @return boolean
   */

  // return (new Database('projetos'))->update('id = '.$this->id,[
  public function atualizar(){
    return (new Database('projetos'))->update('(id, ver) = ( "'.$this->id.'", '.$this->ver.' )',
                                     [
                                       'regras' =>  $this->regras,
                                       'id_prof' => $this->id_prof,
                                       'nome_prof' => $this->nome_prof,
                                       'id_colegiado' => $this->id_colegiado,
                                       'tipo_exten' => $this->tipo_exten,
                                       'titulo' => $this->titulo,
                                       'tide' => $this->tide,
                                       'vigen_ini' => $this->vigen_ini,
                                       'vigen_fim' => $this->vigen_fim,
                                       'ch_semanal' => $this->ch_semanal,
                                       'ch_total' => $this->ch_total,
                                       'situacao' => $this->situacao,
                                       'area_cnpq' => $this->area_cnpq,
                                       'area_tema1' => $this->area_tema1,
                                       'area_tema2' => $this->area_tema2,
                                       'linh_ext' => $this->linh_ext,
                                       'resumo' => $this->resumo,
                                       'descricao' => $this->descricao,
                                       'objetivos' => $this->objetivos,
                                       'public_alvo' => $this->public_alvo,
                                       'metodologia' => $this->metodologia,
                                       'prodserv_espe' => $this->prodserv_espe,
                                       'contribuicao' => $this->contribuicao,
                                       'contrap_nofinac' => $this->contrap_nofinac,
                                       'n_cert_prev' => $this->n_cert_prev,
                                       'data' => $this->data,
                                       'outs_info' => $this->outs_info,
                                       'para_avaliar' => $this->para_avaliar,
                                      // 'created_at' => $this->created_at,
                                       'updated_at' => date("Y-m-d H:i:s"),
                                       'user' => $this->user
                                      ]);
  }

  /**
   * Método responsável por excluir a projeto do banco
   * @return boolean
   */
  public function excluir(){

    return (new Database('projetos'))->delete(' (id, ver) = ("'.$this->id.'", '. $this->ver .')');

  }

  /**
   * Método responsável por obter as projeto do banco de dados
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @return array
   */
  public static function getRegistros($where = null, $order = null, $limit = null){
    return (new Database('proj_inf_lv'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

/**
   * Método responsável por obter a quantidade de registros
   * @param  integer $id
   * @return integer
   */
  public static function getQntdRegistros($where = null){
    return (new Database('proj_inf_lv'))->select($where, null, null, 'COUNT(*) as qtd')
                                  ->fetchObject()
                                  ->qtd;
  }



  /**
   * Método responsável por buscar uma Projeto com base em seu ID e Versão
   * @param  integer $id
   * @return Projeto
   */
  public static function getProjeto($id, $ver){
    return (new Database('proj_inf'))->select('(id, ver) = ("'.$id.'", '. $ver .')')
                                  ->fetchObject(self::class);
  }


/**
   * Método responsável por buscar uma Projeto com base em seu ID
   * @param  integer $id
   * @return Projeto
   */
  public static function getProjetoView($id){
    return (new Database('proj_inf'))->select('id = "'.$id.'"')
                                  ->fetchObject(self::class);
  }


  /**
   * Método responsável por buscar uma Projeto com base em seu titulo
   * @param  string $titulo
   * @return Projeto
   */
  public static function getProjetoTitulo($titulo){
    return (new Database('projetos'))->select('titulo = '.$titulo)
                                  ->fetchObject(self::class);
  }


  /**
   * Método responsável por obter as professores do banco de dados
   * @param  string $id_avaliador
   * @return array   id_proj, titulo, nivel_adm, local, id_avaliador
   */
  public static function getProjsParaAnalisar($id_avaliador, $level){
    $sql = " select * from para_avaliar
            where 
              id_avaliador =  " . $id_avaliador . " and
              nivel_adm = " . $level;
        
    return (new Database())->selectJ($sql)
      ->fetchAll(PDO::FETCH_CLASS,self::class);
  }


  /**
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function Submeter($para){
    $this->para_avaliar = $para;
    $this->edt = 0;
    $this->atualizar();

    $sql = "
              insert into 
                avaliacoes (id, id_proj, ver, regra_def, fase_seq, tp_instancia, id_instancia)
              select * 
              from to_avaliar 
              where 
                id_proj = '". $this->id ."' and
                fase_seq = 1";
    echo $sql;
    $a = new Database(); 
    $a->execute($sql);
    return true;
      // ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

} 

