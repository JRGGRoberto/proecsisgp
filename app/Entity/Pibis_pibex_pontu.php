<?php

namespace App\Entity;

use App\Db\Database;

class Pibis_pibex_pontu
{
    public $proj_id;
    public $aval_id;
    public $qn1;
    public $qn2;
    public $qn3;
    public $qn4;
    public $qn5;
    public $qn6;
    public $qn7;
    public $justificativa;
    public $doit;
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
        $obDatabase = new Database('pibis_pibex_pontu');
        $obDatabase->insert([
            'proj_id' => $this->proj_id,
            'aval_id' => $this->aval_id,
            'qn1' => $this->qn1,
            'qn2' => $this->qn2,
            'qn3' => $this->qn3,
            'qn4' => $this->qn4,
            'qn5' => $this->qn5,
            'qn6' => $this->qn6,
            'qn7' => $this->qn7,
            'justificativa' => $this->justificativa,
            'doit' => $this->doit,
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
        return (new Database('pibis_pibex_pontu'))->update('(proj_id, aval_id)  = ("'.$this->proj_id.'", "'.$this->aval_id.'") ', [
            'qn1' => $this->qn1,
            'qn2' => $this->qn2,
            'qn3' => $this->qn3,
            'qn4' => $this->qn4,
            'qn5' => $this->qn5,
            'qn6' => $this->qn6,
            'qn7' => $this->qn7,
            'justificativa' => $this->justificativa,
            'doit' => $this->doit,
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
        return (new Database('pibis_pibex_pontu'))->delete('(proj_id, aval_id)  = ("'.$this->proj_id.'", "'.$this->aval_id.'") ');
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
        return (new Database('pibixpibex'))->select($where, $order, $limit)
                                       ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter as professores do banco de dados.
     *
     * @return array
     */
    public static function get($id, $aval_id)
    {
        $where = '(proj_id, aval_id) = ("'.$id.'", "'.$aval_id.'" ) ';

        return (new Database('pibis_pibex_pontu'))->select($where)
                                         ->fetchObject(self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntd($where = null)
    {
        return (new Database('pibixpibex'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }
}
