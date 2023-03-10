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
  public $last_result;
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
    is_null($this->ver) ? $v = 0 : $v = $this->ver;
    is_null($this->id) ? $ida  = $newId : $ida = $this->id;
    is_null($this->edt) ? $edt = 1 : $edt = $this->edt;
    is_null($this->para_avaliar) ? $aval = -1 : $aval = $this->para_avaliar;
    is_null($this->last_result) ? $lr = 'n' : $lr = $this->last_result;
    
    //$this->id = 
    $obDatabase->insert([
                           'id' => $ida,
                           'ver' =>   $v,
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
                           'edt' => $edt,
                           'outs_info' => $this->outs_info,
                           'para_avaliar' => $aval,
                           'last_result' => $lr,
                           'created_at' => date("Y-m-d H:i:s"),
                          // 'updated_at' => date("Y-m-d H:i:s"),
                           'user' => $this->user
                        ]);

    //RETORNAR SUCESSO
    return true;
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
                                       'edt' => $this->edt,
                                       'outs_info' => $this->outs_info,
                                       'para_avaliar' => $this->para_avaliar,
                                       'last_result' => $this->last_result,
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
    return (new Database('projetos'))->select('(id, ver) = ("'.$id.'", '. $ver .')')
                                  ->fetchObject(self::class);
  }


/**
   * Método responsável por buscar uma Projeto com base em seu ID
   * @param  integer $id
   * @return Projeto
   */
  public static function getProjetoView($id, $ver){
    return (new Database('proj_inf'))->select('(id, ver) = ("'. $id .'", '. $ver .')')
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
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function Submeter($para){
    $this->para_avaliar = $para;
    $this->edt = 0;
    $this->atualizar();

    $sql = "
          insert into
             avaliacoes ( id, id_proj, ver, regra_def, fase_seq, form, tp_instancia, id_instancia, resultado )
             select id, id_proj, ver, regra_def, fase_seq, form, tp_avaliador, id_instancia, if(last_result='n', 'e', last_result)  
          from to_avaliar 
          where 
            id_proj = '". $this->id ."' and
            fase_seq = (select IFNULL(max(fase_seq), 1)   from avaliacoes a where id_proj  = '". $this->id ."')";
                
    $a = new Database(); 
    $a->execute($sql);
    return true;
      // ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  /**
   * Método responsável por buscar uma Projeto com base em seu ID e Versão
   * @param  integer $id
   * @return Projeto
   */
  public function novaVersao(){
    $this->last_result = 'r';
    $this->edt = 1;
    $this->ver = $this->ver  + 1 ;
    $this->cadastrar();
    return true;
  }


    /**
   * Método responsável por cadastrar um novo Registro no banco
   * @return boolean
   */
  public function nextLevel($id_ins = 'id_instancia'){
    $this->last_result = 'a';
    $this->atualizar();

    if($id_ins == 'id_instancia'){
      $id_instancia = 'id_instancia';
    } else {
      $id_instancia = "'".$id_ins."'";
    }
    

    $sql = "
    insert into 
      avaliacoes ( 
        id, id_proj, ver, regra_def, fase_seq, form, tp_instancia, id_instancia, resultado )
    select 
        id, id_proj, ver, regra_def, fase_seq, form, tp_avaliador, ". $id_instancia .", 'e' as resultado
    from to_avaliar 
    where 
       id_proj = '". $this->id ."' and
       fase_seq = (select 
                     IFNULL(max(fase_seq), 0) +
                     (
                        SELECT 
                          if(max(am.fase_seq) < max(ta.fase_seq), 1, 0) soma
                        FROM avaliacoes am
                           inner join to_avaliar ta on (am.id_proj, am.ver ) = (ta.id_proj, ta.ver)
                        WHERE 
                          am.id_proj = ta.id_proj
                     )
                   from avaliacoes a where a.id_proj  = '". $this->id ."'
                  )
    ";
                
    $a = new Database(); 
    $a->execute($sql);
    return true;
      // ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
}
