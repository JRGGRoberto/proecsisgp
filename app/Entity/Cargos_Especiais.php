<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Cargos_Especiais{

    // Variaveis passadas para a view
    public $id;
    public $nomeEspecificacoes;
    public $siglaReitoria;
    public $emailCargo;
    public $nome;
    public $emailPessoa;
    public $tipo;
    public $campus;

    /**
     * Método responsável por obter as registros do banco de dados
    * @param  string $where
    * @param  string $order
    * @param  string $limit
    * @return array
    */
    // Exibe as informações
    public static function getRegistros($where = null, $order = null, $limit = null, $fields = '*'){
    return (new Database('ocupantesCargosEspeciais_v'))->select($where, $order, $limit, $fields)
                                    ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

}