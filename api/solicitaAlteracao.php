<?php
// API que exibe os dados para a solicitação de alteração

require '../vendor/autoload.php';
use App\Session\Login;
use App\Entity\Outros;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();
$userId = $user['id'];
$idproj = $_GET['idproj'];

$campoOriginal = '
SELECT
    pm.titulo,
    pm.tide,
    pm.vigen_ini,
    pm.vigen_fim
FROM projmaster pm
WHERE pm.id = "'.$idproj.'"';

$valorOrig = Outros::qry($campoOriginal);
$dados = $valorOrig[0];

$qryProj = '
SELECT 
    cep.tipo_doc,
    cep.campoAlterado,
    cep.nomeExibicao,
    cep.mensagemAltera,
    cep.tipoCampo,
    pm.campus
FROM projmaster pm
JOIN estados_editaveis_projetos eep 
    ON pm.estado = eep.estado
JOIN campos_editaveis_projetos cep 
    ON FIND_IN_SET(cep.id, eep.campos_editaveis)
WHERE pm.id = "'.$idproj.'"
';

$resultProj = Outros::qry($qryProj);

foreach ($resultProj as &$row) {
    $campo = $row->campoAlterado;

    if (isset($dados->$campo)) {
        $row->valor_campo = $dados->$campo;
    } else {
        $row->valor_campo = null;
    }
}

echo json_encode($resultProj);

