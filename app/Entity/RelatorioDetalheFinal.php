<?php

namespace App\Entity;

class RelatorioDetalheFinal extends RelatorioDetalhe
{
    public $tipo;
    public $periodo_renov_ini;
    public $periodo_renov_fim;
    public $periodo_prorroga_fim;
    public $ch_semanal;
    public $dim_mem_com_ex;
    public $dim_disc;
    public $dim_doce;
    public $dim_agent_estag;
    public $atividades;
    public $atvd_prox_per;
    public $rel_tec_cien_executado;
    public $divulgacao;
    public $rel_finac;

    protected $table = 'rel_detal_final';

    protected function validar(): void
    {
        if(empty($this->id)){
            throw new \Exception("ID é obrigatório");
        }

        if(!in_array($this->tipo, ['fi','pr','re'])){
            throw new \Exception("Tipo inválido para relatório final");
        }

        if($this->ch_semanal !== null && $this->ch_semanal < 0){
            throw new \Exception("Carga horária inválida");
        }

        if($this->visita_tec_qtd !== null && $this->visita_tec_qtd < 0){
            throw new \Exception("Visitas técnicas inválidas");
        }
    }
}