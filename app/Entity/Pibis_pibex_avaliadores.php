<?php

namespace App\Entity;

use App\Db\Database;

class Pibis_pibex_avaliadores
{
    public $id;
    public $ativo;
    public $created_at;
    public $updated_at;
    public $user;

    /**
     * Método responsável por cadastrar uma nova pessoa no banco.
     *
     * @return bool
     */
    public function cadastrar()
    {
        // INSERIR A REGISTRO NO BANCO
        $obDatabase = new Database('pibis_pibex_avaliadores');
        $obDatabase->insert([
            'id' => $this->id,
            'ativo' => $this->ativo,
            'created_at' => date('Y-m-d H:i:s'),
            //  'updated_at' => $this->updated_at,
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar REGISTRO no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('pibis_pibex_avaliadores'))->update('id = "'.$this->id.'" ', [
            'ativo' => $this->ativo,
            // 'created_at' => $this->created_at,
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);
    }

    /**
     * Método responsável por excluir a professor do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('pibis_pibex_avaliadores'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function gets($where = null, $order = null, $limit = null)
    {
        return (new Database('pibis_pibex_avaliadores'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @return array
     */
    public static function get($id, $where = null)
    {
        $where1 = ' id = "'.$id.'" '.($where ? ' AND '.$where : '');

        return (new Database('pibis_pibex_avaliadores'))->select($where1)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntd($where = null)
    {
        return (new Database('pibis_pibex_avaliadores'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}
