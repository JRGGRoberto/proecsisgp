<?php
// API que recebe os dados do formulário "formSAP" em listagem.php
// Chama a função em '../includes/funcoes/func_enviaAlteracao.php'
// Após isso retorna o status para o front se a solicitação de inserção na função der certo
// Para a utilização é necessário enviar os dados via POST

require '../vendor/autoload.php';

use App\Entity\EmailService;
use App\Session\Login;

header('Content-Type: application/json');

// input teste de DEC JSON
// $json = '{
//     "para_avaliar": "1832d052-39eb-11ed-9793-0266ad9885af",
//     "campo": "vigen_fim",
//     "valorNovo": "2026-09-12",
//     "valorAtual": "30/09/2026",
//     "idProj": "054c09ff-2642-45cb-8e82-8805a86c32a1",
//     "msgSolicita": "Gostaria de atualizar o título para refletir melhor o objetivo"
// }';

// // input teste de PROEC
// $json = '{
//     "para_avaliar": "c3bc22e0-3b64-11ed-9793-0266ad9885af",
//     "campo": "id_prof",
//     "valorNovo": "28577ac6-cc50-4ca3-82d5-2496f6bf0e2c", //ARTHUR GUIRRO
//     // "valorNovo": "bfd757a5-4f2d-4a10-87a8-a872ae69f1fd", //MATHEUS ESCOBOZO GUIZILINI
//     // "valorAtual": "ARTHUR GUIRRO",
//     "valorAtual": "MATHEUS ESCOBOZO GUIZILINI",
//     "idProj": "184d06d4-acb1-4ed3-89c2-0237a0457f3e",
//     "msgSolicita": "Gostaria de atualizar o coordenador"
// }';


try {
    Login::requireLogin();
    $user = Login::getUsuarioLogado();

    // $input = json_decode($json, true); // Teste
    $input = json_decode(file_get_contents('php://input'), true); // Original

    // Validação do input enviado
    if (in_array(null, $input, true)) {
        throw new Exception('Um ou mais campos obrigatórios estão nulos ou não foram informados!');
    }
    if (!$input) {
        // throw new Exception("JSON inválido"); //
        throw new Exception('Dados inválidos ou inexistentes!');
    }

    require_once '../includes/funcoes/func_enviaAlteracao.php';
    $ObjSolicitacao = enviaAlteracao($input, $user);

    $email = new EmailService();
    $enviado = $email->solicitacaoAlteracaoPropostas(
        $ObjSolicitacao->id,
        $user['email'],
        $user['nome']
    );

    if ($enviado == 'avaliador' || $enviado == 'autor' ) {
        throw new Exception('Erro ao enviar e-mail de confirmação para o '.$enviado.' da proposta');
        echo json_encode([
            'status' => 'error',
        ]);
    } elseif ($enviado == 'passou') {
        echo json_encode([
            'status' => 'ok',
            // 'envia' => $enviado, // dbg
            // 'debug_input' => $input, // dbg
        ]);
    }
} catch (Exception $e) {
    // http_response_code(500);

    echo json_encode([
        'status' => 'erro',
        'msg' => $e->getMessage(),
        // 'envia' => 'erro envia', // dbg
        // 'text' => $e->getTraceAsString(), // dbg
    ]);
    exit;
}
