<?php

namespace App\Entity;

use App\Db\Database;

class RelatorioTipo
{
    public static function resolver(string $regra): array
    {
        $row = (new Database('regras'))
            ->select('id="'.$regra.'" AND tp_regra="relatorios"', null, null, 'detalhe')
            ->fetchObject();

        if (!$row) {
            throw new \Exception('Regra inválida: '.$regra);
        }

        $tipo = $row->detalhe;

        return [
            'tipo' => $tipo,
            'tabela' => ($tipo === 'pa') ? 'rel_detal_parcial' : 'rel_detal_final',
        ];
    }
}
