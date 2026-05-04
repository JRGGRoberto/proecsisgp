<?php
// API que faz atualização na tabela projetos e na tabela solicitacao_adendos
// Modifica os dados se forem aprovados e informa quem autorizou a modificação.

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Outros;
use App\Entity\Projeto; 
use App\Entity\solicitacao_adendos;

Login::requireLogin();
$user = Login::getUsuarioLogado();

// Inicia sessão para passar mensagem de aprovação no front-end
session_start();

//dados que serão inseridos na tabela solicitacao_adendos (aprovando ou não)
$validador_id = $user['id'];
$validador_nome = $user['nome'];
$validador_cargo = $user['tipo'];
$email_ca = $user['email'];
$mensagem_validador = $_POST['mensagem'] ?? '';
$resultado = $_POST['resultado'] ?? '';

// Pega o campo da tabela que será alterado
$qryCampo = Outros::q('select campoAlterado from campos_editaveis_projetos where id = "'.$_GET['campo'].'"');
$campoAlterado = $qryCampo->campoAlterado;

//dados que serão atualizados na tabela projetos (apenas se aprovar)
$dadosSolicitacao = solicitacao_adendos::getRegistros('id = "'.$_GET['idAdendos'].'"');
$idLocal = $dadosSolicitacao[0]->id_localValidador;
$dado_novo = $dadosSolicitacao[0]->dado_novo;
$idproj = $dadosSolicitacao[0]->idproj;
$verProj = $dadosSolicitacao[0]->verProj;

// Formata para não acabar no dia as 00h00 e sim as 23h59
if ($campoAlterado === 'vigen_fim' || $campoAlterado === 'vige_ini') {
    $dado_novo = $dado_novo.' 23:59:00.000';
}

// Atualiza a tabela solicitacao_adendos
function updateAdendos($validador_id, $validador_nome, $validador_cargo, $email_ca, $mensagem_validador, $resultado)
{
    $data = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

    $adendo = new solicitacao_adendos();
    $adendo->id = $_GET['idAdendos'];
    $adendo->validador_id = $validador_id;
    $adendo->validador_nome = $validador_nome;
    $adendo->validador_cargo = $validador_cargo;
    $adendo->email_ca = $email_ca;
    $adendo->mensagem_validador = $mensagem_validador;
    $adendo->resultado = $resultado;
    $adendo->data_resultado = $data->format('Y-m-d H:i:s.v');
    $adendo->atualizar();
}


// Se o resultado for aprovado, é atualizado na tabela projeto
if ($resultado === 'a'){
    $projetos = new Projeto();
    $projetos = Projeto::getProjeto($idproj, $verProj);
    $projetos->$campoAlterado = $dado_novo;
    if ($projetos->atualizar() == 1){
        updateAdendos($validador_id, $validador_nome, $validador_cargo, $email_ca, $mensagem_validador, $resultado);
        $_SESSION['msg'] = 'Avaliação realizada com sucesso!';
    }
} elseif ($resultado === 'r') {
    updateAdendos($validador_id, $validador_nome, $validador_cargo, $email_ca, $mensagem_validador, $resultado);
    $_SESSION['msg'] = 'Avaliação realizada com sucesso!';
}
else {
    $_SESSION['msg'] = 'Não foi possível realizar essa avaliação, tente novamente';
}

// echo '<pre>';
// print_r($idLocal);
// echo '</pre>';

header('Location: ../solicitaAlteracao/atualiza_proj.php?tipo=atualizar&idLocal=' . urlencode($idLocal));
exit;