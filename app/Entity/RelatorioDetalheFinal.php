<?php

namespace App\Entity;

class RelatorioDetalheFinal extends RelatorioDetalhe
{
    public $periodo_renov_ini;
    public $periodo_renov_fim;
    public $periodo_prorroga_fim;
    public $ch_semanal;
    public $dim_mem_com_ex;
    public $dim_disc;
    public $dim_doce;
    public $dim_agent_estag;
    public $atividades;
    public $rel_tec_cien_executado;
    public $divulgacao;
    public $rel_finac;

    protected $table = 'rel_detal_final';

    protected function toArray(): array
    {
        return [
            'id' => $this->id,
            'ver' => $this->ver,
            'periodo_renov_ini' => $this->periodo_renov_ini,
            'periodo_renov_fim' => $this->periodo_renov_fim,
            'periodo_prorroga_fim' => $this->periodo_prorroga_fim,
            'ch_semanal' => $this->ch_semanal,
            'dim_mem_com_ex' => $this->dim_mem_com_ex,
            'dim_disc' => $this->dim_disc,
            'dim_doce' => $this->dim_doce,
            'dim_agent_estag' => $this->dim_agent_estag,
            'atividades' => $this->atividades,
            'rel_tec_cien_executado' => $this->rel_tec_cien_executado,
            'divulgacao' => $this->divulgacao,
            'rel_finac' => $this->rel_finac,
            'visita_tec_qtd' => $this->visita_tec_qtd,
            'atvd_prox_per' => $this->atvd_prox_per,
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ];
    }
}
