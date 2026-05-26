<?php
// Função utilizada para pegar os professores de determinado colegiado ou de agentes de determinados campus
// Para utilizar a API é necessário passar o ID do local (colegiado ou campus) e o tipo (pf ou ag) ou o id da pessoa

require '../vendor/autoload.php';

// A variavel $value recebe 'yyyy-mm-dd hh:mm:ss' e separa em $dados [[0],[1]]
function separarDataHora($value)
{
    $dados = explode(' ', $value);
    return $dados;
}

// A variavel $value recebe 'yyyy-mm-dd hh:mm:ss' ou 'yyyy-mm-dd'

function formatarData($value)
{
    $data = separarDataHora($value);
    if (isset($data[1])) {
        $value = $data[0];
    }
    [$y, $m, $d] = explode('-', $value);
    return $d.'/'.$m.'/'.$y;
}

// A variavel $value recebe 'yyyy-mm-dd hh:mm:ss' ou 'hh:mm:ss'
function formatarHora($value){
    $hora = separarDataHora($value);
    if (isset($hora[1])){
        $value = $hora[1];
    }
    [$h, $m, $s] = explode(':', $value);
    return  $h.':'.$m;
}

// A variavel $value recebe 'yyyy-mm-dd hh:mm:ss'
function formatarDataHora($value){
    $data = formatarData($value);
    $hora = formatarHora($value);
    return $data.' '.$hora;
}

function dataMaxima($qntDias){
    $data = new DateTime();
    $data->modify("+{$qntDias} days"); // Soma os dias
    $data->setTime(23, 59, 59); // Define horário final
    return $data->format('Y-m-d H:i:s');
}