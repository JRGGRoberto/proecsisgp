<?php
// Função que realiza o envio de alteração de projetos para a tabela solicitacao_adendos
// Dados são processados e enviados por meio do $ObjSolicitacao->insertRegistros
// O input: $input = ["para_avaliar" => "", "campo" => "", "valorNovo" => "", "valorAtual" => "", "idProj" => "", "msgSolicita" => ""];
require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Outros;
use App\Entity\solicitacao_adendos;
use App\Entity\Professor;
use App\Entity\Ca_Ce_Co;
use App\Entity\UuiuD;

Login::requireLogin();

function enviaAlteracao($input, $user){

    $userId = $user['id'];

    $valorNovo = trim(strip_tags($input['valorNovo']));
    $msgSolicitacao = trim(strip_tags($input['msgSolicita']));
    $campo = $input['campo'];
    $valorAtual = $input['valorAtual'];
    $idProjeto = $input['idProj'];

    // Aqui vê se é professor ou agente
    $tipoPessoa = null;
    $whrPessoa = 'id = "'.$userId.'"';
    $fldsPessoa = 'tipo';
    $pessoa = Professor::getProfessores($whrPessoa,null,null,$fldsPessoa);
    $tipoPessoa = $pessoa[0]->tipo; 

    // Aqui recebe o valor do id campus ($ca_id)
    $ca_id = null;
    if ($tipoPessoa == 'pf'){
        $whrCCC = 'co_id = "'.$input['para_avaliar'].'"';
        $fldsCCC = 'ca_id';
        $ca = Ca_Ce_Co::getRegistros($whrCCC,'','',$fldsCCC);
        $ca_id = $ca[0]->ca_id;
    } elseif ($tipoPessoa == 'ag') {
        $ca_id = $input['para_avaliar'];
    }

    if ($campo == 'id_prof') {
        // Aqui envia a alteração só para o cargo "Diretor de Programas e Projetos de Extensão" da PROEC
        $local = ', ocev.idLocalCargo as id_localValidador'; // Deixar a virgula aqui para não quebrar a query
        $join = 'join ocupantesCargosEspeciais_v ocev on ocev.id = "6d7582d1-3998-11f1-aed4-66a0b0dd1af7"';
    } else {
        $local = null;
        $join = null;
    }

    $qryEnvia = '
        SELECT 
            pm.ver as verProj,
            eep.id as id_estadoProj,
            cep.id as id_alteracao,
            u.nome as solicitante_nome
            '.$local.' 
        from projmaster pm 
        join campos_editaveis_projetos cep on cep.campoAlterado = "'.$campo.'" 
        join estados_editaveis_projetos eep on eep.estado = pm.estado and eep.campos_editaveis = cep.id
        '.$join.'
        join usuarios u on u.id = "'.$userId.'"
        where pm.id = "'.$idProjeto.'";  
    ';
    $resultEnvia = Outros::q($qryEnvia);

    $newId = UuiuD::gera();

    $ObjSolicitacao = new solicitacao_adendos();
    //gerar id
    $ObjSolicitacao->id = $newId;
    //inserir o que vem do backend
    $ObjSolicitacao->solicitante_id = $userId;                      
    $ObjSolicitacao->dado_novo = $valorNovo;
    $ObjSolicitacao->dado_orig = $valorAtual;
    $ObjSolicitacao->idproj = $idProjeto;
    $ObjSolicitacao->mensagem_solicitante = $msgSolicitacao;
    //inserir o que vem da consulta SQL
    $ObjSolicitacao->verProj = $resultEnvia->verProj;
    $ObjSolicitacao->id_estadoProj = $resultEnvia->id_estadoProj;
    $ObjSolicitacao->id_alteracao = $resultEnvia->id_alteracao;
    $ObjSolicitacao->solicitante_nome = $resultEnvia->solicitante_nome;
    if (empty($resultEnvia->id_localValidador)){
        $ObjSolicitacao->id_localValidador = $ca_id;
    } else {
        $ObjSolicitacao->id_localValidador = $resultEnvia->id_localValidador;
    }
    //dados que vão por padrão
    if ($ObjSolicitacao->id_alteracao == 'cbe68648-39c2-11f1-aed4-66a0b0dd1af7'){
        $ObjSolicitacao->tipo_validador = 'proec';
    } else {
        $ObjSolicitacao->tipo_validador = 'ca';
    }
    $ObjSolicitacao->resultado = 'n';

    if (!$ObjSolicitacao->insertRegistros()) {
        // throw new Exception("Erro ao inserir solicitação no banco");
        throw new Exception("Erro ao finalizar solicitação, tente novamente.");
    }

    require_once '../includes/funcoes/func_pendencia.php';
    criarPendencia($newId, 'n', 'alt'); // Cria a pendência para o avaliador sendo PROEC ou DEC;

    return $ObjSolicitacao;
}
