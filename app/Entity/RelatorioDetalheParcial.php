<?php

namespace App\Entity;

use App\Db\Database;

class RelatorioDetalheParcial
{
    public function salvar($id, $dados)
    {
        $db = new Database('rel_detal_parcial');

        $existe = $db->select('id="'.$id.'"')->fetchObject();

        $dados['id'] = $id;

        if ($existe) {
            $db->update('id="'.$id.'"', $dados);
        } else {
            $db->insert($dados);
        }
    }
}
