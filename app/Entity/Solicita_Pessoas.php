<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Solicita_Pessoas{

    public $id;
    public $tp_solicitacao;
    public $tp_cadastro;
    public $id_solicitador;
    public $id_avaliador;
    public $resultado;
    public $id_pessoa;
    public $nome;
    public $cpf;
    public $titulacao;
    public $lattes;
    public $email;
    public $telefone;
    public $ca_id;
    public $co_id;
    public $cat_func;
    public $rt;
    public $portaria;
    public $ano_letivo;
    public $vinculo_remocao;
    public $data_solicitacao;

    /**
     * Método responsável por cadastrar um novo Registro no banco
    * @return boolean
    */
    // Inserir no banco após a solicitação de adendos
    public function insertRegistros(){
        $obDatabase = new Database('tb_solicita_pessoa');
        $obDatabase->insert(
            [
                'id' => $this->id,
                'tp_solicitacao' => $this->tp_solicitacao,
                'tp_cadastro' => $this->tp_cadastro,
                'id_solicitador' => $this->id_solicitador,
                'id_pessoa' => $this->id_pessoa,
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'titulacao' => $this->titulacao,
                'lattes' => $this->lattes,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'ca_id' => $this->ca_id,
                'co_id' => $this->co_id,
                'cat_func' => $this->cat_func,
                'rt' => $this->rt,
                'portaria' => $this->portaria,
                'ano_letivo' => $this->ano_letivo,
                'vinculo_remocao' => $this->vinculo_remocao,
                'data_solicitacao' => $this->data_solicitacao,
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
        return (new Database('tb_solicita_pessoa'))->update('(id) = ( "'.$this->id.'" )',
            [
                'id_avaliador' => $this->id_avaliador,
                'resultado' => $this->resultado
            ]);
    }

    /**
     * Método responsável por excluir a professor do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('tb_solicita_pessoa'))->delete('id_pessoa = "'.$this->id_pessoa.'"');
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
        return (new Database('tb_solicita_pessoa'))->select($where, $order, $limit, $fields)
                                    ->fetchAll(PDO::FETCH_CLASS,self::class);
    }


    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntdPessoas($where = null)
    {
        return (new Database('tb_solicita_pessoa'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}