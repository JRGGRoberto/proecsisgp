<?php

namespace App\Entity;

use App\Db\Database;

class Relatorio
{
    // Exclusivo dos relats
    public $id;
    public $ver;
    public $idproj;
    public $regra;
    public $tipo;
    public $fase_atual;
    public $fases;
    public $para_avaliar;
    public $tramitar;
    public $last_result;
    public $created_at;
    public $updated_at;
    public $user;

    // Comum para os Parciais e Finais
    public $visita_tec_qtd;
    public $atvd_prox_per;

    // Att Parcial
    public $periodo_ini;
    public $periodo_fim;
    public $atvd_per;
    public $alteracoes;

    // Att Final
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

    private static $table = 'relats';
    private $tblDetalhe = '';

    private function dropAttributes($tp)
    {
        switch ($tp) {
            case 'rel_detal_final': // remover dos parciais para deixar apenas dos finais
                unset($this->periodo_ini);
                unset($this->periodo_fim);
                unset($this->atvd_per);
                unset($this->alteracoes);
                break;
            case 'rel_detal_parcial':  // remover dos finais para deixar apenas do parcial
                unset($this->periodo_renov_ini);
                unset($this->periodo_renov_fim);
                unset($this->periodo_prorroga_fim);
                unset($this->ch_semanal);
                unset($this->dim_mem_com_ex);
                unset($this->dim_disc);
                unset($this->dim_doce);
                unset($this->dim_agent_estag);
                unset($this->atividades);
                unset($this->rel_tec_cien_executado);
                unset($this->divulgacao);
                unset($this->rel_finac);
                break;
        }
    }

    private function getTipo()
    {
        $sql = 'select detalhe
                 from  regras  
                 where   tp_regra  = "relatorios"
                and id =  "'.$this->regra.'" limit 1';

        $tp = Outros::q($sql);

        $this->tipo = $tp->detalhe;

        if ($tp->detalhe == 'pa') {
            $this->tblDetalhe = 'rel_detal_parcial';
        } else {
            $this->tblDetalhe = 'rel_detal_final';
        }
        $this->tipo = $tp->detalhe;
        $this->dropAttributes($this->tblDetalhe);

        return Outros::q($sql);
    }

    private function cadastrarDetParc($id, $ver)
    {
        (new Database($this->tblDetalhe))->insert([
            'id' => $id,
            'ver' => $ver,
            'periodo_ini' => $this->periodo_ini,
            'periodo_fim' => $this->periodo_fim,
            'atvd_per' => $this->atvd_per,
            'alteracoes ' => $this->alteracoes,
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
            'visita_tec_qtd' => $this->visita_tec_qtd,
            'atvd_prox_per' => $this->atvd_prox_per,
        ]);
    }

    private function cadastrarDetFinal($id, $ver)
    {
        (new Database($this->tblDetalhe))->insert([
            'id' => $id,
            'ver' => $ver,
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
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
            'visita_tec_qtd' => $this->visita_tec_qtd,
            'atvd_prox_per' => $this->atvd_prox_per,
        ]);
    }

    public function cadastrar()
    {
        $this->id = UuiuD::gera();
        $ver = 0;

        $this->getTipo();

        (new Database(self::$table))->insert([
            'id' => $this->id,
            'ver' => $ver,
            'idproj' => $this->idproj,
            'regra' => $this->regra,
            'tipo' => $this->tipo,
            'fase_atual' => $this->fase_atual,
            'para_avaliar' => $this->para_avaliar,
            'tramitar' => $this->tramitar,
            'last_result' => 'n',
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);

        switch ($this->tblDetalhe) {
            case 'rel_detal_parcial':
                $this->cadastrarDetParc($this->id, $ver);

                break;
            case 'rel_detal_final':
                $this->cadastrarDetFinal($this->id, $ver);
                break;
            default: return;
        }

        return $this->id;
    }

    public static function getAll($where = null)
    {
        return (new Database(self::$table))->select($where)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function getId($id)
    {
        $chave = (new Database(self::$table))->select('id = "'.$id.'" ')
                                      ->fetchObject(self::class);
        $chave->getTipo();

        $this->id = $chave->id;
        $this->ver = $chave->ver;
        $this->idproj = $chave->idproj;
        $this->regra = $chave->regra;
        $this->tipo = $chave->tipo;
        $this->fase_atual = $chave->fase_atual;
        $this->fases = $chave->fases;
        $this->para_avaliar = $chave->para_avaliar;
        $this->tramitar = $chave->tramitar;
        $this->atvd_prox_per = $chave->atvd_prox_per;
        $this->visita_tec_qtd = $chave->visita_tec_qtd;
        $this->last_result = $chave->last_result;
        $this->created_at = $chave->created_at;
        $this->user = $chave->user;

        $detalhes = (new Database($chave->tblDetalhe))->select(' (id, ver ) = ("'.$id.'", "'.$chave->ver.'") ')
                                     ->fetchObject(self::class);

        if ($chave->tblDetalhe == 'rel_detal_parcial') {
            $this->periodo_ini = $detalhes->periodo_ini;
            $this->periodo_fim = $detalhes->periodo_fim;
            $this->atvd_per = $detalhes->atvd_per;
            $this->alteracoes = $detalhes->alteracoes;
            $this->visita_tec_qtd = $detalhes->visita_tec_qtd;
            $this->atvd_prox_per = $detalhes->atvd_prox_per;
        } elseif ($chave->tblDetalhe == 'rel_detal_final') {
            $this->periodo_renov_ini = $detalhes->periodo_renov_ini;
            $this->periodo_renov_fim = $detalhes->periodo_renov_fim;
            $this->periodo_prorroga_fim = $detalhes->periodo_prorroga_fim;
            $this->ch_semanal = $detalhes->ch_semanal;
            $this->dim_mem_com_ex = $detalhes->dim_mem_com_ex;
            $this->dim_disc = $detalhes->dim_disc;
            $this->dim_doce = $detalhes->dim_doce;
            $this->dim_agent_estag = $detalhes->dim_agent_estag;
            $this->atividades = $detalhes->atividades;
            $this->rel_tec_cien_executado = $detalhes->rel_tec_cien_executado;
            $this->divulgacao = $detalhes->divulgacao;
            $this->rel_finac = $detalhes->rel_finac;
            $this->visita_tec_qtd = $detalhes->visita_tec_qtd;
            $this->atvd_prox_per = $detalhes->atvd_prox_per;
        } else {
            return $this;
        }
        unset($chave);
        unset($detalhes);

        return $this;
    }

    public function atualizar()
    {
        $chave = (new Database(self::$table))->select('(id, ver) = ("'.$this->id.'", "'.$this->ver.'" )')
                                      ->fetchObject(self::class);
        $chave->getTipo();
        $arrayDetalhe = [];

        (new Database(self::$table))->update('(id, ver) = ( "'.$chave->id.'", '.$chave->ver.' )',
            [
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]);

        if ($chave->tblDetalhe == 'rel_detal_parcial') {
            $arrayDetalhe +=
            [
                'id' => $this->id,
                'ver' => $this->ver,
                'periodo_ini' => $this->periodo_ini,
                'periodo_fim' => $this->periodo_fim,
                'atvd_per' => $this->atvd_per,
                'alteracoes ' => $this->alteracoes,
                'created_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,

                'visita_tec_qtd' => $this->visita_tec_qtd,
                'atvd_prox_per' => $this->atvd_prox_per,
            ];
        } elseif ($chave->tblDetalhe == 'rel_detal_final') {
            $arrayDetalhe += [
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
                'created_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
                'visita_tec_qtd' => $this->visita_tec_qtd,
                'atvd_prox_per' => $this->atvd_prox_per,
            ];
        }

        return (new Database($chave->tblDetalhe))->update('(id, ver) = ( "'.$chave->id.'", '.$chave->ver.' )',
            $arrayDetalhe);
    }

    public function excluir()
    {
        if (in_array($this->fase_atual, [null, 0])) {
            $this->getTipo();
            (new Database($this->tblDetalhe))->delete('(id, ver) = ( "'.$this->id.'", '.$this->ver.' )');
            (new Database(self::$table))->delete('(id, ver) = ( "'.$this->id.'", '.$this->ver.' )');

            return true;
        }

        return false;
    }

    public function submeter()
    {
        if (in_array($this->fase_atual, [null, 0])) {
            $para_Fase = 1;
        } else {
            $para_Fase = $this->fase_atual;
        }

        $qntFases = RegrasDef::getQntdRegistros('id_reg = "'.$this->regra.'" ');

        (new Database(self::$table))->update('id =  "'.$this->id.'" ',
            [
                'last_result' => 'n',
                'tramitar' => 1,
                'fases' => $qntFases,
                'fase_atual' => $para_Fase,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]);

        (new Database())->execute(
            '
            INSERT INTO avaliacoes_rel
               (id, id_rel, ver, regra_def, fase_seq, form, tp_instancia, id_instancia, resultado)
            SELECT
                id, id_rel, ver, regra_def, fase_seq, form, tp_avaliador, id_instancia, last_result
            FROM 
                to_avaliar_rel
            where
              id_rel = "'.$this->id.'"
              and fase_seq = "'.$para_Fase.'"
            '
        );
    }

    public function aprovar()
    {
        // Encaminhar para próxima instancia ou
        // # Aprovar = Publicar
        $para_Fase = $this->fase_atual;

        $resultado = 'n';
        // Encaminhar para próxima instancia ou
        if ($this->fase_atual < $this->fases) {
            ++$para_Fase;
            (new Database())->execute(
                '
                INSERT INTO avaliacoes_rel
                   (id, id_rel, ver, regra_def, fase_seq, form, tp_instancia, id_instancia, resultado)
                SELECT
                    id, id_rel, ver, regra_def, fase_seq, form, tp_avaliador, id_instancia, last_result
                FROM 
                    to_avaliar_rel
                where
                  id_rel = "'.$this->id.'"
                  and fase_seq = "'.$para_Fase.'"
                '
            );
        } elseif ($this->fase_atual == $this->fases) {
            $resultado = 'a';
        }

        (new Database(self::$table))->update('id =  "'.$this->id.'" ',
            [
                'last_result' => $resultado,
                'tramitar' => 1,
                'fase_atual' => $para_Fase,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]);
    }

    public function adequacoes()
    {
        (new Database(self::$table))->update('id =  "'.$this->id.'" ',
            [
                'last_result' => 'r',
                'tramitar' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
                'ver' => ++$this->ver,
            ]);

        $this->getTipo();
        if ($this->tipo == 'pa') {
            $this->cadastrarDetParc($this->id, $this->ver++);
        } else {
            $this->cadastrarDetFinal($this->id, $this->ver++);
        }
    }
}
