<?php

namespace App\Entity;

use App\Db\Database;

class RelatorioMapper
{
    public static function carregar(string $id): ?Relatorio
    {
        $rel = (new Database('relats'))
            ->select('id="'.$id.'"')
            ->fetchObject(Relatorio::class);

        if (!$rel) {
            return null;
        }

        $tipo = RelatorioTipo::resolver($rel->regra);

        $detalhe = (new Database($tipo['tabela']))
            ->select('(id, ver) = ("'.$rel->id.'", '.$rel->ver.')')
            ->fetchObject();

        if ($detalhe) {
            foreach ($detalhe as $k => $v) {
                $rel->$k = $v;
            }
        }

        return $rel;
    }
}
