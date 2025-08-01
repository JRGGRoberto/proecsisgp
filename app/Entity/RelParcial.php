<?php

namespace App\Entity;

use App\Db\Database;
use App\Session\Login;

Login::requireLogin();

class RelParcial
{
    public $id;
    public $idproj;
    public $periodo_ini;
    public $periodo_fim;
    public $atvd_per;
    public $alteracoes;
    public $atvd_prox_per;

    public $tramitar;
    public $last_result;
    public $etapa;
    public $etapas;

    public $created_at;
    public $updated_at;
    public $user;

    /**
     * Método responsável por cadastrar uma nova pessoa no banco.
     *
     * @return varchar
     */
    public function cadastrar()
    {
        // INSERIR A REGISTRO NO BANCO
        $newId = UuiuD::gera(); // exec('uuidgen -r');
        $obDatabase = new Database('rel_parcial');
        $obDatabase->insert([
            'id' => $newId,
            'idproj' => $this->idproj,
            'periodo_ini' => $this->periodo_ini,
            'periodo_fim' => $this->periodo_fim,
            'atvd_per' => $this->atvd_per,
            'alteracoes' => $this->alteracoes,
            'atvd_prox_per' => $this->atvd_prox_per,

            'tramitar' => $this->tramitar,
            'last_result' => 'n',
            'created_at' => date('Y-m-d H:i:s'),
            //  'updated_at'  => $this->updated_at,
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return $newId;
    }

    /**
     * Método responsável por atualizar REGISTRO no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('rel_parcial'))->update('id = "'.$this->id.'" ', [
            'idproj' => $this->idproj,
            'periodo_ini' => $this->periodo_ini,
            'periodo_fim' => $this->periodo_fim,
            'atvd_per' => $this->atvd_per,
            'alteracoes' => $this->alteracoes,
            'atvd_prox_per' => $this->atvd_prox_per,
            'tramitar' => $this->tramitar,
            'last_result' => $this->last_result,
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);
    }

    /**
     * Método responsável por excluir a relatório_parcial do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('rel_parcial'))->delete('id = "'.$this->id.'"');
    }

    /**
     * Método responsável por obter as relatório_parcial do banco de dados.
     *
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function gets($where = null, $order = null, $limit = null)
    {
        return (new Database('rel_parcial'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as relatório_parcial do banco de dados.
     *
     * @return array
     */
    public static function get($id)
    {
        $where = ' id = "'.$id.'" ';

        return (new Database('rel_parcial'))->select($where)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntd($where = null)
    {
        return (new Database('rel_parcial'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}
