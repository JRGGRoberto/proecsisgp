<?php

namespace App\Entity;

use App\Db\Database;

abstract class RelatorioDetalhe
{
    public $id;
    public $ver;
    public $user;
    public $visita_tec_qtd;
    public $atvd_prox_per;

    protected $table;

    abstract protected function toArray(): array;

    public function salvar()
    {
        $dados = $this->toArray();

        (new Database($this->table))->insert($dados);
    }

    public function atualizar()
    {
        $dados = $this->toArray();

        (new Database($this->table))->update(
            '(id, ver) = ("'.$this->id.'", '.$this->ver.')',
            $dados
        );
    }
}
