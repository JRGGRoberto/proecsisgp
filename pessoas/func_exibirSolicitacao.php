<?php

require '../vendor/autoload.php';

use App\Entity\Solicita_Pessoas;

function listaPessoas($tipo) {

    $wherelistPessoa = 'tp_solicitacao = "'.$tipo.'" and resultado is null';
    $pessoalistPessoa = Solicita_Pessoas::getRegistros($wherelistPessoa);
    $listPessoa[] = null;
    foreach ($pessoalistPessoa as $pessoa) {
        $listPessoa[] = $pessoa->id_pessoa;
    }
    return $listPessoa;
}