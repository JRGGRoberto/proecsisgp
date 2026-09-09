<?php

namespace App\Entity;

use App\Db\Database;

class Avaliacoes
{
    public $id;
    public $id_proj;
    public $ver;
    public $regra_def;
    public $fase_seq;
    public $form;
    public $tp_instancia;
    public $id_instancia;
    public $resultado;
    public $updated_at;
    public $user;

    /**
     * Método responsável por obter as registros do banco de dados.
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function getRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('proj_avaliar'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntdRegistros($where = null)
    {
        return (new Database('proj_avaliar'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }

    /**
     * Método responsável por buscar um Registro com base em seu ID.
     *
     * @param int $id
     */
    public static function getRegistro($id)
    {
        return (new Database('avaliacoes'))->select('id =  "'.$id.'"')
                                      ->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um Registro com base em seu ID.
     */
    public static function getRegistroView($id_ava)
    {
        return (new Database('proj_avaliar'))->select('id_ava =  "'.$id_ava.'"')
                                      ->fetchObject(self::class);
    }

    /**
     * Método responsável por excluir a Registro do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('avaliacoes'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por atualizar a Registro no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('avaliacoes'))->update('id = "'.$this->id.'"', [
            'id_instancia' => $this->id_instancia,
            'resultado' => $this->resultado,
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);
    }

    public static function getRegistrosByProj($where = null, $order = null, $limit = null)
    {
        return (new Database('proj_avaliar'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
        
    public static function getLastAvaliacao($id_proj)
    {
        return (new Database('avalia_last'))->select('id_proj =  "'.$id_proj.'"')
                                      ->fetchObject(self::class);
    }
}
