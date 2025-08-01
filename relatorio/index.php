<?php

require '../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Entity\Outros;
use App\Entity\Projeto;
use App\Session\Login;

$user = Login::getUsuarioLogado();

$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
            break;
    }
}

// VALIDAÇÃO DO ID
if (!isset($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}
$id = $_GET['id'];

// CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto1 = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto1->ver);

$novoBTNs = '';
$opcoes = [
    'pa' => '<a class="dropdown-item btn-sm" href="./cadastrarp.php?t=1&i='.$obProjeto->id.'">Relatório parcial</a>',
    're' => '<a class="dropdown-item btn-sm" href="./cadastrarf.php?t=2&i='.$obProjeto->id.'&f=re">Relatório final com pedido de Renovação</a>',
    'pr' => '<a class="dropdown-item btn-sm" href="./cadastrarf.php?t=2&i='.$obProjeto->id.'&f=pr">Relatório final com pedido de Prorrogação</a>',
    'fi' => '<a class="dropdown-item btn-sm" href="./cadastrarf.php?t=2&i='.$obProjeto->id.'&f=fi">Relatório final</a>',
];

function chEstado($op, &$opcoes)
{
    switch ($op) {
        case 're':
            unset($opcoes['pa']);
            unset($opcoes['re']);
            unset($opcoes['pr']);
            unset($opcoes['fi']);
            break;
        case 'pr':
            unset($opcoes['re']);
            unset($opcoes['pr']);
            break;
        case 'fi':
            unset($opcoes['pa']);
            unset($opcoes['re']);
            unset($opcoes['pr']);
            unset($opcoes['fi']);
            break;
        default:
            return '';
    }

    return null;
}

$relatorios = Outros::qry('SELECT * FROM relatorios WHERE idproj = "'.$id.'"');

// remoção das oções de criar relatórios
foreach ($relatorios as $rel) {
    chEstado($rel->tipo, $opcoes);
    if (in_array($rel->tipo, ['re', 'fi'])) { // como estes removem todos os outros, não precisa mais verificar
        break;
    }
    if ($rel->publicado == 0) {
        chEstado('fi', $opcoes);
        break;
    }
}

function formatData($data): string
{
    return substr($data, 8, 2).'/'.substr($data, 5, 2).'/'.substr($data, 0, 4);
}

$obProjeto->tipo_exten;
$tipoE = '';
switch ($obProjeto->tipo_exten) {
    case 1:
        $tipoE = 'Curso';
        break;
    case 2:
        $tipoE = 'Evento';
        break;
    case 3:
        $tipoE = 'Prestação de serviço';
        break;
    case 4:
        $tipoE = 'Programa';
        break;
    case 5:
        $tipoE = 'Projeto';
        break;
    default:
        $tipoE = '';
        break;
        exit;
}

$dataAtual = new DateTime('now');
$vigen_ini = date_create($obProjeto->vigen_ini);
$vigen_fim = date_create($obProjeto->vigen_fim);

if ($dataAtual < $vigen_ini) {
    // echo 'Não iniciou';
    unset($opcoes['pa']);
    unset($opcoes['re']);
    unset($opcoes['pr']);
    unset($opcoes['fi']);
    $msgInfoEstado = '<span class="badge badge-info float-right">Proposta não iniciada, não é possível criar relatórios</span>';
} elseif ($dataAtual >= $vigen_ini && $dataAtual <= $vigen_fim) {
    // echo 'Entre';
    unset($opcoes['re']);
    unset($opcoes['pr']);
    unset($opcoes['fi']);
    $msgInfoEstado = '<span class="badge badge-info">Projeto em execução, possível apenas criar relatórios parciais</span>';
} else {
    // echo 'fechado ';
    unset($opcoes['pa']);
    $msgInfoEstado = '<span class="badge badge-info">Projeto finalizado, possível apenas criar relatório final</span>';
}

if ($user['id'] != $obProjeto->id_prof) {  // verifica se o usuário é o dono do projeto
    unset($opcoes['pa']);
    unset($opcoes['re']);
    unset($opcoes['pr']);
    unset($opcoes['fi']);
}

include '../includes/header.php';
include __DIR__.'/includes/listagem.php';
include '../includes/footer.php';
