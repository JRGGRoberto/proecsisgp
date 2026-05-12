<?php
// Função utilizada para pegar os professores de determinado colegiado ou de agentes de determinados campus
// Para utilizar a API é necessário passar o ID do local (colegiado ou campus) e o tipo (pf ou ag) ou o id da pessoa

require '../vendor/autoload.php';

use \App\Entity\Professor;

function recuperarDadosPessoas($params) {
    $resultado = [];

    if (!empty($params['idLocal']) && !empty($params['tipo'])) {

        $local = $params['idLocal'];
        $tipo = $params['tipo'];

        $campo = ($tipo == 'pf') ? 'id_colegiado' : 'ca_id';

        $where = $campo.' = "'.$local.'" and tipo = "'.$tipo.'" and ativo = 1';
        $fields = 'id, nome, email, tipo';

        $registros = Professor::getProfessores($where,null,null,$fields);

        foreach ($registros as $value) {
            $resultado[] = [
                "id" => $value->id,
                "nome" => $value->nome,
                "email" => $value->email,
                "tipo" => $value->tipo
            ];
        }

    } elseif (!empty($params['idPessoa'])) {

        $id = $params['idPessoa'];

        $where = 'id = "'.$id.'"';
        $fields = 'id, nome, email, tipo, co_id, ca_id';

        $registros = Professor::getProfessores($where,null,null,$fields);

        $resultado[] = [
            "id" => $registros[0]->id,
            "nome" => $registros[0]->nome,
            "email" => $registros[0]->email,
            "tipo" => $registros[0]->tipo
            // "co_id" => $registros[0]->co_id,
            // "ca_id" => $registros[0]->ca_id
        ];
    }

    return $resultado;
}
