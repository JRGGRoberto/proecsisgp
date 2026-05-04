<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class solicitacao_adendos{

  public $id;
  public $idproj;
  public $verProj;
  public $id_estadoProj;
  public $id_alteracao;
  public $dado_orig;
  public $dado_novo;
  public $solicitante_nome;
  public $solicitante_id;
  public $mensagem_solicitante;
  public $validador_nome;
  public $validador_id;
  public $validador_cargo;
  public $mensagem_validador;
  public $id_localValidador;
  public $tipo_validador;
  public $email_ca;
  public $data_resultado;
  public $resultado;
  public $data_solicitacao;

  /**
  * Método responsável por cadastrar um novo Registro no banco
  * @return boolean
  */
  // Inserir no banco após a solicitação de adendos
  public function insertRegistros(){
    $obDatabase = new Database('solicitacao_adendos');
    $obDatabase->insert([
                        'idproj' => $this->idproj,
                        'verProj' => $this->verProj,
                        'id_estadoProj' => $this->id_estadoProj,
                        'id_alteracao' => $this->id_alteracao,
                        'dado_orig' => $this->dado_orig,
                        'dado_novo' => $this->dado_novo,
                        'solicitante_nome' => $this->solicitante_nome,
                        'solicitante_id' => $this->solicitante_id,
                        'mensagem_solicitante' => $this->mensagem_solicitante,
                        'id_localValidador' => $this->id_localValidador,
                        'tipo_validador' => $this->tipo_validador,
                        // 'data_resultado' => $this->data_resultado,
                        'resultado' => $this->resultado,
                        ]);
    return true;
  }

  /**
   * Método responsável por atualizar a PROJETO no banco.
   *
   * @return bool
   */

  // atualiza a tabela após a avaliação do validador
  public function atualizar()
  {
      return (new Database('solicitacao_adendos'))->update('(id) = ( "'.$this->id.'" )',
          [
            'validador_nome' => $this->validador_nome,
            'validador_id' => $this->validador_id,
            'validador_cargo' => $this->validador_cargo,
            'mensagem_validador' => $this->mensagem_validador,
            'email_ca' => $this->email_ca,
            'data_resultado' => $this->data_resultado,
            'resultado' => $this->resultado,
          ]);
  }

  /**
  * Método responsável por obter as registros do banco de dados
  * @param  string $where
  * @param  string $order
  * @param  string $limit
  * @return array
  */
  // Exibe as informações
  public static function getRegistros($where = null, $order = null, $limit = null, $fields = '*'){
    return (new Database('solicitacao_adendos_v'))->select($where, $order, $limit, $fields)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }
}