<?php
// API que cria uma solicitação na tabela solicitacao_adendos
require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Outros;
use App\Entity\solicitacao_adendos;

Login::requireLogin();
$user = Login::getUsuarioLogado();
$userId = $user['id'];
$input = json_decode(file_get_contents("php://input"), true);

try {

    $ObjSolicitacao = new solicitacao_adendos();

    $valorNovo = trim(strip_tags($input['valorNovo'] ?? '')); 
    $msgSolicitacao = trim(strip_tags($input['msgSolicita'] ?? '')); 
    if ($valorNovo === '' || $msgSolicitacao === ''){ 
        throw new Exception('Campos obrigatórios vazios.'); 
    }
    
    $campo           = $input['campo']; 
    $valorAtual      = $input['valorAtual']; 
    $idProjeto       = $input['idProj'];

    if ($campo === null || $valorNovo === null || $idProjeto === null || $msgSolicitacao === null) {
        throw new Exception('Dados obrigatórios não informados.');
    } else {
        $qryEnvia = '
            SELECT 
                pm.ver as verProj,
                eep.id as id_estadoProj,
                cep.id as id_alteracao,
                u.nome as solicitante_nome,
                u.lota_id as id_localValidador
            from projmaster pm 
            join campos_editaveis_projetos cep on cep.campoAlterado = "'.$campo.'" 
            join estados_editaveis_projetos eep on eep.estado = pm.estado and eep.campos_editaveis = cep.id
            join usuarios u on u.id = "'.$userId.'"
            where pm.id = "'.$idProjeto.'";  
        ';
        $resultEnvia = Outros::q($qryEnvia);
        
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
        $ObjSolicitacao->id_localValidador = $resultEnvia->id_localValidador;
        //dados que vão por padrão
        $ObjSolicitacao->tipo_validador = 'ca';
        $ObjSolicitacao->resultado = 'n';

        $ObjSolicitacao->insertRegistros();

        echo json_encode([
            "status" => "ok",
            // "debug" => $ObjSolicitacao
        ]);        
        
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage()
    ]);
}