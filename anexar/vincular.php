<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Arquivo;

Login::requireLogin();

$user = Login::getUsuarioLogado();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido');
}

$nomeRand = $_POST['anexo'];
$vinculos = $_POST['vinculos'];

if (!$nomeRand) {
    die('Anexo não informado');
}
if (empty($vinculos)) {
    die('Selecione um local para inserir o anexo');
}

// echo '<pre>';
// print_r($vinculos);
// echo '</pre>';
// exit;

$anexo = Arquivo::getArquivo($nomeRand);
if (!$anexo) {
    die('Anexo não encontrado');
}

$primeiro = true;

foreach ($vinculos as $vinculo) {

    [$tabela, $idTab] = explode('|', $vinculo, 2);
    if ($primeiro) {
        // update no primeiro
        $anexo->tabela = $tabela;
        $anexo->id_tab = $idTab;
        $anexo->user   = $user['id'];
        $anexo->atualizar();
        $primeiro = false;

    } else {
        // insert nos outros
        $novoAnexo = new Arquivo();
        $novoAnexo->nome_orig = $anexo->nome_orig;
        $novoAnexo->nome_rand = $anexo->nome_rand;
        $novoAnexo->size      = $anexo->size;
        $novoAnexo->tipo      = $anexo->tipo;
        $novoAnexo->error     = $anexo->error;
        $novoAnexo->tabela    = $tabela;
        $novoAnexo->id_tab    = $idTab;
        $novoAnexo->user      = $user['id'];
        $novoAnexo->cadastrar();
    }
}

header('Location: index.php');
exit;