<?php
// API que faz atualização na tabela projetos e na tabela solicitacao_adendos
// Modifica os dados se forem aprovados e informa quem autorizou a modificação.
// Utilizado em 'solicitaAlteracao/includes/listagemAtualizar.php' passando os parâmetros por $_GET

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Outros;
use App\Entity\Projeto; 
use App\Entity\solicitacao_adendos;
use App\Entity\EmailService;

Login::requireLogin();
$user = Login::getUsuarioLogado();

// Inicia sessão para passar mensagem de aprovação no front-end
session_start();

// Dados que serão atualizados na tabela projetos (apenas se aprovar)
$dadosSolicitacao = solicitacao_adendos::getRegistros('id = "'.$_GET['idAdendos'].'"');
$idLocal = $dadosSolicitacao[0]->id_localValidador;
// $solicitante_nome = $dadosSolicitacao[0]->solicitante_nome;
$dado_novo = $dadosSolicitacao[0]->dado_novo;
$idproj = $dadosSolicitacao[0]->idproj;
$verProj = $dadosSolicitacao[0]->verProj;

// Pega o campo da tabela que será alterado
$qryCampo = Outros::q('select campoAlterado from campos_editaveis_projetos where id = "'.$_GET['campo'].'"');
$campoAlterado = $qryCampo->campoAlterado;

// Pega se for feito por um cargo especial
require_once '../includes/funcoes/func_verificaCargosEspeciais.php';
if ($campoAlterado == 'id_prof'){

    // Pega o nome do novo dono do projeto
    require_once '../includes/funcoes/func_recuperarDadosPessoas.php';
    $paramns['idPessoa'] = $dado_novo;
    $nome = recuperarDadosPessoas($paramns);
    $nome = $nome[0]['nome'];

    $cargo = localCargosEspeciais($idLocal);
    $cargo = $cargo[0]->nomeEspecificacoes;
    $location = 'PROEC';
} else {
    $cargo = $user['tipo'];
    $location = 'DEC';
}

// Dados que serão inseridos na tabela solicitacao_adendos (aprovando ou não)
$validador_id = $user['id'];
$validador_nome = $user['nome'];
$validador_cargo = $cargo;
$email_ca = $user['email'];
$mensagem_validador = $_POST['mensagem'] ?? '';
$resultado = $_POST['resultado'] ?? '';

require_once '../includes/funcoes/func_mudaAbreviacao.php';
$hora = mudaAbreviacaoHoraEstatica('ultimaHora');

// Formata para não acabar no dia as 00h00 e sim as 23h59
if ($campoAlterado === 'vigen_fim' || $campoAlterado === 'vige_ini') {
    $dado_novo = $dado_novo.$hora;
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

$email = new EmailService();
// Se o resultado for aprovado, é atualizado na tabela projeto
if ($resultado === 'a'){
    $projetos = new Projeto();
    $projetos = Projeto::getProjeto($idproj, $verProj);
    $projetos->$campoAlterado = $dado_novo;

    if ($projetos->atualizar() == 1){
        updateAdendos($validador_id, $validador_nome, $validador_cargo, $email_ca, $mensagem_validador, $resultado);
        // Envio de email de confirmação
        $enviado = $email->analiseAlteracaoPropostas(
            $_GET['idAdendos'],
            $resultado,
            $user['nome'],
            $user['email']
        );

        if ($enviado == 'avaliador' || $enviado == 'autor' || $enviado == 'novo autor') {
            $_SESSION['msg'] = "Erro ao enviar e-mail de confirmação para o ".$enviado." da proposta";
        }

        $_SESSION['msg'] = 'Avaliação realizada com sucesso!';
    } else {
        $_SESSION['msg'] = 'Erro ao realizar avaliação';
    }
} elseif ($resultado === 'r') {
    updateAdendos($validador_id, $validador_nome, $validador_cargo, $email_ca, $mensagem_validador, $resultado);
    // Envio de email de confirmação
    $email->analiseAlteracaoPropostas(
        $_GET['idAdendos'],
        $resultado,
        $user['nome'],
        $user['email']
    );
    if (!$enviado) {
        $_SESSION['msg'] = "Erro ao enviar e-mail de confirmação";
    }
    $_SESSION['msg'] = 'Avaliação realizada com sucesso!';
}
else {
    $_SESSION['msg'] = 'Não foi possível realizar essa avaliação, tente novamente';
}

header('Location: ../solicitaAlteracao/index.php?tipo=atualizar&solicita='.$location.'&idLocal='.urlencode($idLocal));
exit;