<?php

namespace App\Entity;

use App\Db\Database;

class Pibis_pibex_proj
{
    public $id;
    public $nome;
    public $link;
    public $programa;
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
        $newId = UuiuD::gera(); // exec('uuidgen -r');
        $obDatabase = new Database('pibis_pibex_proj');
        $obDatabase->insert([
            'id' => $newId,
            'nome' => $this->nome,
            'programa' => $this->programa,
            'link' => $this->link,
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
        return (new Database('pibis_pibex_proj'))->update('id = "'.$this->id.'" ', [
            'nome' => $this->nome,
            'link' => $this->link,
            'programa' => $this->programa,
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
        return (new Database('pibis_pibex_proj'))->delete('id = '.$this->id);
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
        return (new Database('pibis_pibex_proj'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @return array
     */
    public static function get($id)
    {
        $where = ' id = "'.$id.'" ';

        return (new Database('pibis_pibex_proj'))->select($where)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntd($where = null)
    {
        return (new Database('pibis_pibex_proj'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}
