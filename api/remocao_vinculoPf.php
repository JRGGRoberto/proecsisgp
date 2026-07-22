<?php

// API que é usada no desativacaoPf junto ou o outro fetch

require '../vendor/autoload.php';

use App\Entity\Professor;
use App\Entity\Vinculo;

$where = 'id = "'.$_GET['prof_id'].'"';
$prof = Professor::getProfessores($where);
$prof[0]->ativo = 0;

$vinculo = Vinculo::get($_GET['vinculo_id']);

if ($vinculo && $prof) {

    $prof[0]->atualizarAtivo();
    $vinculo->excluir();

    echo json_encode([
        'status' => 'ok'
    ]);
    exit;
}
echo json_encode([
    'status' => 'error'
]);