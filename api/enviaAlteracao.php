<?php
// API que recebe os dados do formulário "formSAP" em listagem.php
// Chama a função em '../includes/funcoes/func_enviaAlteracao.php'
// Após isso retorna o status para o front se a solicitação de inserção na função der certo
// Para a utilização é necessário enviar os dados via POST

require '../vendor/autoload.php';

use App\Entity\EmailService;
use App\Session\Login;

header('Content-Type: application/json');

// // input teste de DEC
// $input = [
//     "para_avaliar" => "c3bc2bb3-3b64-11ed-9793-0266ad9885af",
//     "campo" => "vigen_fim",
//     // "campo" => null,
//     "valorNovo" => "Novo título do projeto",
//     "valorAtual" => "Título antigo",
//     "idProj" => "3dbee76d-f26a-448e-9826-ceda2b41251e",
//     "msgSolicita" => "Gostaria de atualizar o título para refletir melhor o objetivo"
// ];

// // input teste de PROEC
// $input = [
//     "para_avaliar" => "c3bc22e0-3b64-11ed-9793-0266ad9885af",
//     "campo" => "id_prof",
//     "valorNovo" => "bfd757a5-4f2d-4a10-87a8-a872ae69f1fd",
//     "valorAtual" => "ARTHUR GUIRRO",
//     "idProj" => "94b174fd-c57f-4703-bb77-77801c3dc942",
//     "msgSolicita" => "Gostaria de atualizar o coordenador"
// ];

try {
    Login::requireLogin();
    $user = Login::getUsuarioLogado();

    $input = json_decode(file_get_contents("php://input"), true);

    // Validação do input enviado
    if (in_array(null, $input, true)) {
        throw new Exception("Um ou mais campos obrigatórios estão nulos ou não foram informados!");
    }
    if (!$input) {
        // throw new Exception("JSON inválido");
        throw new Exception("Dados inválidos ou inexistentes!");
    }

    require_once '../includes/funcoes/func_enviaAlteracao.php';
    $ObjSolicitacao = enviaAlteracao($input, $user);

    $email = new EmailService();
    $enviado = $email->solicitacaoAlteracaoPropostas(
        $ObjSolicitacao->id,
        $user['email'],
        $user['nome']
    );

    if (!$enviado) {
        throw new Exception("Erro ao enviar e-mail de confirmação");
    }

    echo json_encode([
        "status" => "ok",
        // "debug_input" => $input
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "status" => "erro",
        "msg" => $e->getMessage(),
        // "trace" => $e->getTraceAsString() //Debug
    ]);
    exit;
}