<?php

namespace App\Entity;

class RelatorioDetalheParcial extends RelatorioDetalhe
{
    public $periodo_ini;
    public $periodo_fim;
    public $atvd_per;
    public $alteracoes;

    protected $table = 'rel_detal_parcial';

    protected function toArray(): array
    {
        return [
            'id' => $this->id,
            'ver' => $this->ver,
            'periodo_ini' => $this->periodo_ini,
            'periodo_fim' => $this->periodo_fim,
            'atvd_per' => $this->atvd_per,
            'alteracoes' => $this->alteracoes,
            'visita_tec_qtd' => $this->visita_tec_qtd,
            'atvd_prox_per' => $this->atvd_prox_per,
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ];
    }
}
