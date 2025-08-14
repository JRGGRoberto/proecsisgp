<?php

namespace App\Entity;

use App\Db\Database;

class Inscricao
{
    public $id_can;
    public $if_prog;

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
            'if_prog' => $this->if_prog,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    public static function get($id_can, $if_prog)
    {
        $where = ' id_can = "'.$id_can.'" and if_prog = "'.$if_prog.'" ';

        return (new Database('inscricao'))->select($where)
                                          ->fetchObject(self::class);
    }

    public function delete()
    {
        return (new Database('inscricao'))->delete(' (id_can, if_prog) = ("'.$this->id_can.'", "'.$this->if_prog.'" )');
    }
}
