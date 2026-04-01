<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

class Relatorio
{
    public $id;
    public $ver;
    public $idproj;
    public $regra;
    public $fase_atual;
    public $para_avaliar;
    public $tramitar;
    public $last_result;
    public $created_at;
    public $updated_at;
    public $user;

    private static $table = 'relats';

    public function cadastrar()
    {
        $this->id = UuiuD::gera();

        (new Database(self::$table))->insert([
            'id' => $this->id,
            'ver' => $this->ver,
            'idproj' => $this->idproj,
            'regra' => $this->regra,
            'fase_atual' => $this->fase_atual,
            'para_avaliar' => $this->para_avaliar,
            'tramitar' => $this->tramitar,
            'last_result' => 'n',
            'created_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);

        return $this->id;
    }

    public function atualizar()
    {
        return (new Database(self::$table))->update('id="'.$this->id.'"', [
            'fase_atual' => $this->fase_atual,
            'tramitar' => $this->tramitar,
            'last_result' => $this->last_result,
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);
    }

    public function salvarCompleto(array $detalhe)
    {
        if(empty($this->id)){
            $this->cadastrar();
        } else {
            $this->atualizar();
        }

        $tipo = RelatorioTipoResolver::getTipo($this->regra);

        if($tipo === 'final'){
            (new RelatorioDetalheFinal())->salvar($this->id, $detalhe);
        }

        if($tipo === 'parcial'){
            (new RelatorioDetalheParcial())->salvar($this->id, $detalhe);
        }

        return $this->id;
    }

    public static function getsAll($where = null)
    {
        return (new Database(self::$table))
            ->select($where)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getsFinais()
    {
        return (new Database(self::$table.' r'))
            ->select('rg.detalhe IN ("fi","pr","re")', null, null, 'r.*')
            ->join('regras rg', 'rg.id = r.regra AND rg.tp_regra = "relatorios"')
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getsParciais()
    {
        return (new Database(self::$table.' r'))
            ->select('rg.detalhe = "pa"', null, null, 'r.*')
            ->join('regras rg', 'rg.id = r.regra AND rg.tp_regra = "relatorios"')
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getRelat($id)
    {
        return RelatorioView::getById($id);
    }
}