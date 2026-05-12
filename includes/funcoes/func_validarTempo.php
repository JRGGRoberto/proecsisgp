<?php
// Funções prontas utilizada para as verificações necessárias de tempo em php
// Feitas em um código para auxilio da manutenção do sistema

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();

// Utilizar essa função para validar se a data é maior que 1 ano
function dataMaiorUmAno($dataInicial, $dataFinal) {

    [$y1, $m1, $d1] = array_map('intval', explode('-', $dataInicial));
    // $arrInicial = [$y1, $m1, $d1];

    [$y2, $m2, $d2] = array_map('intval', explode('-', $dataFinal));
    // $arrFinal = [$y2, $m2, $d2];

    if ($y2 == $y1){
        return false ;
    } elseif ($y2 > $y1) {
        if ($m2 < $m1){
            return false ;
        } elseif ($m2 >= $m1){
            if ($d2 < $d1){
                return false;
            } else {
                return true ;
            }
        }
    }
}


// Utilizar essa função para ver se a data desejada é 7 dias menor que a data atual
function dataSemanaAntes($dataDesejada, $dataAtual) {

    [$y1, $m1, $d1] = array_map('intval', explode('-', $dataDesejada));
    // $arrInicial = [$y1, $m1, $d1];

    [$y2, $m2, $d2] = array_map('intval', explode('-', $dataAtual));
    // $arrFinal = [$y2, $m2, $d2];


    if ($y2 == $y1){
        if ($m2 == $m1){
            if ($d2 >= $d1+6){
                return true;
            }
        }
    }

}