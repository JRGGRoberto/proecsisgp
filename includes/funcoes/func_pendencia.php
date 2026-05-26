<?php
// Utilizada dentro da mailBody
// pois todo processo de aprovação/reprovação/solicitação passa por lá

require '../vendor/autoload.php';

require_once 'func_proxAvaliador.php';
require_once 'func_formatDateHour.php';

use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Entity\Pendencias;
use App\Entity\Projeto;
use App\Entity\solicitacao_adendos;
use App\Entity\UuiuD;

use App\Session\Login;
Login::requireLogin();

function enviarDados($id_ref, $id_recebedor, $cargo_recebedor, $data_limite, $recebedor_pendencia, $tipo_pendencia){
    $data_return = [
        'id_ref' => $id_ref,
        'id_recebedor' => $id_recebedor, // Se for pf ou ag vai para a pessoa, se não é para o cargo
        'cargo_recebedor' => $cargo_recebedor,
        'data_limite' => $data_limite,
        'recebedor_pendencia' => $recebedor_pendencia,
        'tipo_pendencia' => $tipo_pendencia
    ];
    return $data_return;
}

// Pendências que vão para os avaliadores
function avaliadores($id_ref, $tipo_pendencia, $cargo_recebedor = ''){
    
    // Valores fixos
    $recebedor_pendencia = "av"; // Avaliador
    $data_limite = dataMaxima('45'); // Passar a quantidade de dias máximos

    // Próximo Avaliador
    if ($tipo_pendencia == 'prop'){

        $avaliador = (new Projeto)->dadosAvaliacaoAtual($id_ref);

        $id_ref = $avaliador->id_ava;
        $cargo_recebedor = $avaliador->tp_instancia;
        $id_recebedor = $avaliador->id_instancia;

        $data_return = enviarDados($id_ref, $id_recebedor, $cargo_recebedor, $data_limite, $recebedor_pendencia, $tipo_pendencia);
        return $data_return;
    }

    // Dir Extensão e Cultura PROEC ou Chefe da DEC
    elseif ($tipo_pendencia == 'alt'){
        $where = 'id = "'.$id_ref.'"';
        $solicitacao = solicitacao_adendos::getRegistros($where);

        $cargo_recebedor = $solicitacao[0]->tipo_validador;
        $id_recebedor = $solicitacao[0]->id_localValidador;

        $data_return = enviarDados($id_ref, $id_recebedor, $cargo_recebedor, $data_limite, $recebedor_pendencia, $tipo_pendencia);
        return $data_return;
    }

}

// Formulários que podem ser reprovados e voltam para o dono do projeto
function dono($id_ref, $tipo_pendencia, $cargo_recebedor = ''){
        
    // Valores fixos
    $recebedor_pendencia = "aj";
    $data_limite = dataMaxima('45'); // Passar a quantidade de dias máximos
    
    if ($tipo_pendencia == 'prop'){
        $where = 'id = "'.$id_ref.'"';
        $dono = Projeto::getRegistros($where);

        $id_recebedor = $dono[0]->id_prof;

        $campi = Campi::getRegistro($dono[0]->para_avaliar);
        $colegiado = Colegiado::getRegistro($dono[0]->para_avaliar);
        $local = [
            'campi' => $campi,
            'colegiado' => $colegiado
        ];

        if ($local['colegiado'] == ''){
            $cargo_recebedor = 'ag';
        } 
        elseif ($local['campi'] == '') {
            $cargo_recebedor = 'pf';
        }

        $data_return = enviarDados($id_ref, $id_recebedor, $cargo_recebedor, $data_limite, $recebedor_pendencia, $tipo_pendencia);
        return $data_return;
    }

}

function verificaResultado($id_ref, $resultado, $tipo_pendencia, $cargo_recebedor = ''){
    
    if ($resultado == 'a' || $resultado == 'n'){
        $data_return = avaliadores($id_ref, $tipo_pendencia, $cargo_recebedor);
        return $data_return;
    }
    
    elseif ($resultado == 'r'){
        $data_return = dono($id_ref, $tipo_pendencia, $cargo_recebedor);
        return $data_return;
    }
}

function criarPendencia($id_ref, $resultado, $tipo_pendencia, $cargo_recebedor = ''){

    $data_return = verificaResultado($id_ref, $resultado, $tipo_pendencia, $cargo_recebedor);
    
    $newId = UuiuD::gera();
    $ObjPendencias = new Pendencias();
    // Gerar id
    $ObjPendencias->id = $newId;
    // Passado por parâmetro
    // Quando é avaliação de proposta o id_ref é de avaliação, quando é de ajuste é o id do projeto e de adendos o id é de solicita_adendos
    $ObjPendencias->id_ref = $data_return['id_ref']; 
    //Dados que faltam
    $ObjPendencias->id_recebedor = $data_return['id_recebedor']; // Pode ser pessoa ou cargo
    $ObjPendencias->cargo_recebedor = $data_return['cargo_recebedor']; // 'ca','ce','co','pf','ag','dc','proec'
    $ObjPendencias->data_limite = $data_return['data_limite']; // De acordo com a solicitação e pra quem vai
    $ObjPendencias->tipo_pendencia = $data_return['tipo_pendencia']; // 'av','aj','ntf'
    $ObjPendencias->recebedor_pendencia = $data_return['recebedor_pendencia']; // 'alt','prop','rp','rf'
    // Pega a hora de inserção
    $ObjPendencias->created_at = date('Y-m-d H:i:s');
    
    $ObjPendencias->insertRegistros();

    return true;
}

// Para excluir a pendência é preciso passar o ID de referência
// ID de avaliação/solicitacao_adendos/projeto ou relatorios
function excluirPendencia($id_ref, $tipo_pendencia){
    (new Pendencias)->excluir($id_ref, $tipo_pendencia);
    return true;
}