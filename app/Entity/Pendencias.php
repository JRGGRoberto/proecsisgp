<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Pendencias{

    public $id;
    public $id_ref;
    public $id_recebedor;
    public $cargo_recebedor;
    public $data_limite;
    public $recebedor_pendencia;
    public $tipo_pendencia;
    public $created_at;

    /**
     * Método responsável por cadastrar um novo Registro no banco
    * @return boolean
    */
    // Inserir no banco após a solicitação de adendos
    public function insertRegistros(){
        $obDatabase = new Database('tb_pendencias');
        $obDatabase->insert([
                            'id' => $this->id,
                            'id_ref' => $this->id_ref,
                            'id_recebedor' => $this->id_recebedor,
                            'cargo_recebedor' => $this->cargo_recebedor,
                            'data_limite' => $this->data_limite,
                            'recebedor_pendencia' => $this->recebedor_pendencia,
                            'tipo_pendencia' => $this->tipo_pendencia,
                            'created_at' => $this->created_at
                            ]);
        return true;
    }

    /**
     * Método responsável por excluir a pendência do banco.
     *
     * @return bool
     */
    public function excluir($id_ref, $tipo_pendencia)
    {
        return (new Database('tb_pendencias'))->delete(' id_ref = "'.$id_ref.'" AND tipo_pendencia = "'.$tipo_pendencia.'"');
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
        return (new Database('tb_pendencias'))->select($where, $order, $limit, $fields)
                                    ->fetchAll(PDO::FETCH_CLASS,self::class);
    }
}