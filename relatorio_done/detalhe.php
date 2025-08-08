<?php

require '../vendor/autoload.php';
use App\Entity\RelFinal;
use App\Entity\RelParcial;

function getTipo($tp)
{
    $tipo1 = '';
    switch ($tp) {
        case 'fi':
            $tipo1 = 'Final';
            break;
        case 're':
            $tipo1 = 'Final renovação';
            break;
        case 'pr':
            $tipo1 = 'Final prorrogação';
            break;
        case 'pa':
            $tipo1 = 'Parcial';
            break;
        default:
            $tipo1 = 'error';

            return $tipo1;
            break;
    }
}

function prnDetalhe($id, $tp)
{
    $textoMsg = '';
    $finais = ['fi', 're', 'pr'];

    if ($tp == 'pa') {
        $dataRel = RelParcial::get($id);
        if ($dataRel instanceof RelParcial) {
            $textoMsg = '<a href="../relatorio/editarp.php?id='.$dataRel->id.'" class="btn btn-sm btn-success">Visualizar</a>';
        } else {
            return 'error';
        }
    } elseif (in_array($tp, $finais)) {
        $dataRel = RelFinal::get($id);
        if ($dataRel instanceof RelFinal) {
            $textoMsg = '<a href="../relatorio/editarf.php?id='.$dataRel->id.'" class="btn btn-sm btn-success">Visualizar</a>';
        } else {
            return 'error';
        }
    } else {
        return 'error';
    }

    return $textoMsg;
}
