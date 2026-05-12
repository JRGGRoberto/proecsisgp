<?php

namespace App\Entity;

use App\Db\Database;

class RelatorioTipoResolver
{
    public static function getTipo($regra): string
    {
        $row = (new Database('regras'))
            ->select('id="'.$regra.'" AND tp_regra="relatorios"', null, null, 'detalhe')
            ->fetchObject();

        if (!$row) {
            throw new \Exception('Regra não encontrada: '.$regra);
        }

        if ($row->detalhe === 'pa') {
            return 'parcial';
        }

        if (in_array($row->detalhe, ['fi', 'pr', 're'])) {
            return 'final';
        }

        throw new \Exception('Tipo inválido para regra: '.$regra);
    }
}
