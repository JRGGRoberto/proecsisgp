<?php

namespace App\Entity;

use App\Db\Database;

abstract class RelatorioDetalhe
{
    public $id;
    public $ver;
    public $visita_tec_qtd;
    public $created_at;
    public $updated_at;
    public $user;

    protected $table;

    abstract protected function validar(): void;

    public function salvar()
    {
        $this->validar();

        $db = new Database($this->table);

        $this->updated_at = date('Y-m-d H:i:s');

        $dados = get_object_vars($this);

        $existe = $db->select('id="'.$this->id.'"')->fetchObject();

        if ($existe) {
            $db->update('id="'.$this->id.'"', $dados);
        } else {
            $this->created_at = date('Y-m-d H:i:s');
            $db->insert($dados);
        }
    }
}
