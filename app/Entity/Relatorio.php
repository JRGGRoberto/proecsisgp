<?php

namespace App\Entity;

use App\Db\Database;

class Relatorio
{
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

    public $visita_tec_qtd;
    public $atvd_prox_per;

    // parcial
    public $periodo_ini;
    public $periodo_fim;
    public $atvd_per;
    public $alteracoes;

    // final
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

    private function criarDetalhe()
    {
        $tipo = RelatorioTipo::resolver($this->regra);

        $this->tipo = $tipo['tipo'];

        if ($this->tipo === 'pa') {
            return new RelatorioDetalheParcial();
        }

        return new RelatorioDetalheFinal();
    }

    private function popularDetalhe(RelatorioDetalhe $det)
    {
        foreach (get_object_vars($this) as $k => $v) {
            if (property_exists($det, $k)) {
                $det->$k = $v;
            }
        }

        $det->id = $this->id;
        $det->ver = $this->ver;
        $det->user = $this->user;
    }

    public function cadastrar()
    {
        $this->id = UuiuD::gera();
        $this->ver = 0;

        $det = $this->criarDetalhe();  // Para definir o $this->tipo

        (new Database(self::$table))->insert([
            'id' => $this->id,
            'ver' => $this->ver,
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

        $this->popularDetalhe($det);
        $det->salvar();

        return $this->id;
    }

    public function atualizar()
    {
        (new Database(self::$table))->update(
            '(id, ver) = ("'.$this->id.'", '.$this->ver.')',
            [
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]
        );

        $det = $this->criarDetalhe();
        $this->popularDetalhe($det);
        $det->atualizar();
    }

    public function excluir()
    {
        if (!in_array($this->fase_atual, [null, 0])) {
            echo 'se não tiver null ou 0 entra aqui';

            return false;
        }

        $tipo = RelatorioTipo::resolver($this->regra);

        (new Database($tipo['tabela']))
            ->delete('(id, ver) = ("'.$this->id.'", '.$this->ver.')');

        (new Database(self::$table))
            ->delete('(id, ver) = ("'.$this->id.'", '.$this->ver.')');

        return true;
    }

    public static function getById($id)
    {
        return RelatorioMapper::carregar($id);
    }

    public static function getAll($where = null)
    {
        return (new Database(self::$table))
            ->select($where)
            ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function adequacoes()
    {
        ++$this->ver;

        (new Database(self::$table))->update(
            'id = "'.$this->id.'"',
            [
                'last_result' => 'r',
                'tramitar' => 0,
                'ver' => $this->ver,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]
        );

        $det = $this->criarDetalhe();
        $this->popularDetalhe($det);
        $det->salvar();
    }

    public function aprovar()
    {
        $paraFase = $this->fase_atual;
        $resultado = 'n';

        if ($this->fase_atual < $this->fases) {
            ++$paraFase;
        } else {
            $resultado = 'a';
        }

        (new Database(self::$table))->update(
            'id = "'.$this->id.'"',
            [
                'last_result' => $resultado,
                'tramitar' => 1,
                'fase_atual' => $paraFase,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]
        );
    }

    public function submeter()
    {
        $qntFases = RegrasDef::getQntdRegistros('id_reg = "'.$this->regra.'"');

        $paraFase = (in_array($this->fase_atual, [null, 0])) ? 1 : $this->fase_atual;

        (new Database(self::$table))->update(
            'id = "'.$this->id.'"',
            [
                'last_result' => 'n',
                'tramitar' => 1,
                'fases' => $qntFases,
                'fase_atual' => $paraFase,
                'updated_at' => date('Y-m-d H:i:s'),
                'user' => $this->user,
            ]
        );

        AvaliaRelatorios::cadastrar($this->id, $paraFase);
    }
}
