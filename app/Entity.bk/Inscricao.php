<?php

namespace App\Entity;

use App\Db\Database;

class Inscricao
{
    public $id_can;
    public $id_prog;
    public $classif;
    public $cancelado;
    public $obs;
    public $created_at;
    public $updated_at;

    /**
     * Método responsável por cadastrar uma nova pessoa no banco.
     *
     * @return bool
     */
    public function cadastrar()
    {
        $obDatabase = new Database('inscricao');
        $obDatabase->insert([
            'id_can' => $this->id_can,
            'id_prog' => $this->id_prog,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    public static function get($id_can, $id_prog)
    {
        $where = ' id_can = "'.$id_can.'" and id_prog = "'.$id_prog.'" ';

        return (new Database('inscricao'))->select($where)
                                          ->fetchObject(self::class);
    }

    public function delete()
    {
        return (new Database('inscricao'))->delete(' (id_can, id_prog) = ("'.$this->id_can.'", "'.$this->id_prog.'" )');
    }

    /**
     * Método responsável por atualizar a Registro no banco.
     *
     * @return bool
     */
    public function posicao($num)
    {
        return (new Database('inscricao'))->update('(id_can, id_prog) = ("'.$this->id_can.'", "'.$this->id_prog.'" )',
            [
                'classif' => $num,
                'obs' => null,
                'cancelado' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Método responsável por atualizar a Registro no banco.
     *
     * @return bool
     */
    public function cancel($msg)
    {
        return (new Database('inscricao'))->update('(id_can, id_prog) = ("'.$this->id_can.'", "'.$this->id_prog.'" )',
            [
                'classif' => null,
                'obs' => $msg,
                'cancelado' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }
}
