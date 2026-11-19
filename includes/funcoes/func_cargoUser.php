<?php

function tipoCargoUser($abreviacao, $tipo = null)
{
        
    if ($abreviacao == '0') {
        if ($tipo == 'prof') {
            $abrevia = 'Professor' ;
        } else {
            $abrevia = 'Agente';
        }
        return $abrevia;
    } else {

        $abrevia = [
            '1' => 'Coordenador de Colegiado',
            '2' => 'Diretor de Centro de Área',
            '3' => 'Chefe de Divisão',
            '4' => 'Diretor de Campus',
        ];
        
        return $abrevia[$abreviacao];

    }
}