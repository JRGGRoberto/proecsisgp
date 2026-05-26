<?php

use App\Entity\Avaliacoes;

require '../vendor/autoload.php';

function ultimaAvaliacao($id_proj){
    $where = 'id_proj = "'.$id_proj.'"';
    $avaliacoes = Avaliacoes::getRegistros($where);
    if (empty($avaliacoes)){
        return null;
    }

    $maior = null;
    foreach ($avaliacoes as $data_avaliacao) {
        if (
            $maior === null ||
            // maior fase_seq
            $data_avaliacao->fase_seq > $maior->fase_seq ||
            // se fase_seq for igual, pega maior ver
            (
                $data_avaliacao->fase_seq == $maior->fase_seq &&
                $data_avaliacao->ver > $maior->ver
            )
        ) {
            $maior = $data_avaliacao;
        }
    }
    return $maior;
}

function penultimaAvaliacao($id_proj){
    $where = 'id_proj = "'.$id_proj.'"';
    $order = 'fase_seq';
    $avaliacoes = Avaliacoes::getRegistros($where,$order);
    if (empty($avaliacoes)) {
        return null;
    }

    usort($avaliacoes, function ($a, $b) {
        return [$a->fase_seq, $a->ver] <=> [$b->fase_seq, $b->ver];
    });

    $ultimo = end($avaliacoes);
    $penultimo = prev($avaliacoes);

    return $penultimo ?: null;
}

// $id_proj = '7e6ef643-3ae9-4083-8ef2-f5f13c11e834';
// $avalia = penultimaAvaliacao($id_proj);

// echo '<pre>';
// print_r($avalia);
// exit;
// echo '</pre>';