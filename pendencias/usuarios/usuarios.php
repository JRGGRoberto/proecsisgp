<?php

use App\Entity\Propostas_Paradas;
use App\Entity\Relatorios_Parados;

$campusUser = $user['ca_nome'];

//pendencias dos cara do mesmo campus
$usuariosPropostas = Propostas_Paradas::getRegistrosPendentes($campusUser);
$usuariosRelatorios = Relatorios_Parados::getRegistrosPendentes($campusUser);

$usuariosPendentes = [];

//percorre as pendencias pelas propostas
foreach ($usuariosPropostas as $usuario) {
    $id = $usuario->avaliador_id;

    $usuariosPendentes[$id] = [
        'id' => $id,
        'nome' => $usuario->avaliador_nome,
        'email' => $usuario->avaliador_email,
        'funcao' => $usuario->avaliador_funcao,
        'projetos' => (int) $usuario->projetos_pendentes,
        'relatorios' => 0
    ];
}

foreach ($usuariosRelatorios as $usuario) {
    $id = $usuario->avaliador_id;

    //percorre pelos relatórios
    if (!isset($usuariosPendentes[$id])) {
        $usuariosPendentes[$id] = [
            'id' => $id,
            'nome' => $usuario->avaliador_nome,
            'email' => $usuario->avaliador_email,
            'funcao' => $usuario->avaliador_funcao,
            'projetos' => 0,
            'relatorios' => (int) $usuario->relatorios_pendentes
        ];
    } else {
        $usuariosPendentes[$id]['relatorios'] = (int) $usuario->relatorios_pendentes;
    }
}

//ordena por quantidade de pendencias
$totais = [];

foreach ($usuariosPendentes as $id => $usuario) {
    //associando total de pendencias por id do usuario
    $totais[$id] = $usuario['projetos'] + $usuario['relatorios'];
}

array_multisort($totais, SORT_DESC, $usuariosPendentes);

// Inicializa as listas de cada usuário
foreach ($usuariosPendentes as $id => $usuario) {
    $usuariosPendentes[$id]['lista_propostas'] = [];
    $usuariosPendentes[$id]['lista_relatorios'] = [];
}

// Busca todas as propostas pendentes do campus
$propostas = Propostas_Paradas::getRegistros(
    "resultado = 'e' AND campus = '".$campusUser."' AND avaliador_id IS NOT NULL"
);

// Distribui as propostas entre os usuários
foreach ($propostas as $proposta) {
    $id = $proposta->avaliador_id;

    if (isset($usuariosPendentes[$id])) {
        $usuariosPendentes[$id]['lista_propostas'][] = $proposta;
    }
}

// Busca todos os relatórios pendentes do campus
$relatorios = Relatorios_Parados::getRegistros(
    "resultado = 'n' AND campus = '".$campusUser."' AND avaliador_id IS NOT NULL"
);

// Distribui os relatórios entre os usuários
foreach ($relatorios as $relatorio) {
    $id = $relatorio->avaliador_id;

    if (isset($usuariosPendentes[$id])) {
        $usuariosPendentes[$id]['lista_relatorios'][] = $relatorio;
    }
}

require __DIR__ . '/includes/listagem_usuarios.php';