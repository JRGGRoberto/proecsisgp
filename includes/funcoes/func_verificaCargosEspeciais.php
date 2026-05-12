<?php
// API para inserir um campo na tabela 

require '../vendor/autoload.php';
use App\Entity\Cargos_Especiais;

// Pegar os dados apenas da PROEC
function idPessoaOcupante($userId){
    $where = 'idPessoaOcupante = "'.$userId.'"';
    $registros = new Cargos_Especiais;
    $registrosPessoas = $registros->getRegistros($where);
    return $registrosPessoas;
}

// Limitando só pro Diretor de Projetos e Extensão da PROEC
function dadosCargosEspeciais($cargoId){
    $where = 'id = "'.$cargoId.'" and siglaReitoria = "PROEC" and nomeEspecificacoes = "Diretor de Programas e Projetos de Extensão"';
    $registros = new Cargos_Especiais;
    $registrosCargo = $registros->getRegistros($where);
    return $registrosCargo;
}

// Pegar o responsável por local
function localCargosEspeciais($LocalId){
    $where = 'idLocalCargo = "'.$LocalId.'" and siglaReitoria = "PROEC" and nomeEspecificacoes = "Diretor de Programas e Projetos de Extensão"';
    $fields = 'nomeEspecificacoes';
    $registros = new Cargos_Especiais;
    $registrosCargo = $registros->getRegistros($where,'','',$fields);
    return $registrosCargo;
}