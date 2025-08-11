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
        // INSERIR A REGISTRO NO BANCO
        $newId = UuiuD::gera(); // exec('uuidgen -r');
        $obDatabase = new Database('inscricao');
        $obDatabase->insert([
            'id_can' => $this->id_can,
            'if_prog' => $this->if_prog,
        ]);

        // RETORNAR SUCESSO
        return true;
    }
}
