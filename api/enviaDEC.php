<?php
require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Outros;

Login::requireLogin();
$user = Login::getUsuarioLogado();
$userId = $user['id'];
$input = json_decode(file_get_contents("php://input"), true);

try {
    $campo           = $input['campo'];
    $valorNovo       = $input['valorNovo'];
    $valorAtual      = $input['valorAtual'];
    $idProjeto       = $input['idProj'];
    $msgSolicitacao  = $input['msgSolicita']; 
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

    if ($campo === null || $valorNovo === null || $idProjeto === null || $msgSolicitacao === null) {
        throw new Exception('Dados obrigatórios não informados.');
    } else {

        $qryEnvia = '
            SELECT 
                pm.ver as verProj,
                ee.id as id_estadoProj,
                ad.id as id_alteracao,
                u.nome as solicitante_nome,
                u.tipo as solicitante_cargo,
                u.lota_id as id_localValidador
            from projmaster pm 
            join altera_docs ad on ad.campoAlterado = "'.$campo.'" 
            join editar_estados ee on ee.estado = pm.estado and ee.campos_editaveis = ad.id
            join usuarios u on u.id = "'.$userId.'"
            where pm.id = "'.$idProjeto.'";  
        ';

        $resultEnvia = Outros::q($qryEnvia);

        $qryINSERT = '
        INSERT INTO historico_altera (
            id,
            idproj,
            verProj,
            id_estadoProj,
            id_alteracao,
            dado_orig,
            dado_novo,
            solicitante_nome,
            solicitante_id,
            solicitante_cargo,
            mensagem_solicitante,
            validador_nome,
            validador_id,
            validador_cargo,
            mensagem_validador,
            id_localValidador,
            tipo_validador,
            email_ca,
            data_resultado,
            resultado,
            data_solicitacao
        )
        VALUES (
            uuid(),
            "'.$idProjeto.'",
            "'.$resultEnvia->verProj.'",
            "'.$resultEnvia->id_estadoProj.'",
            "'.$resultEnvia->id_alteracao.'",
            "'.$valorAtual.'",
            "'.$valorNovo.'",
            "'.$resultEnvia->solicitante_nome.'",
            "'.$userId.'",
            "'.$resultEnvia->solicitante_cargo.'",
            "",
            "",
            "",
            "",
            "",
            "'.$resultEnvia->id_localValidador.'",
            "ca",
            "",
            null,
            "n",
            "'.$data->format('Y-m-d H:i:s').'"
        )';

        $insert = Outros::qry($qryINSERT);
        
        echo json_encode([
            "status" => "ok",
            $insert
        ]);

    }

} catch (Exception $e) {
    echo json_encode([
        "status" => "erro",
    ]);
}