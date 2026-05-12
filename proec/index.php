<?php
require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

use App\Entity\CompararAlunos;
$idPermitido = CompararAlunos::getIdPermitidos();

// Garante que só entra quem pode 
require_once '../includes/funcoes/func_verificaCargosEspeciais.php';
$cargosEspeciais = dadosCargosEspeciais($user['CargoEspecial']);
if ($user['CargoEspecial'] == '0' || empty($cargosEspeciais)){
    echo "<script>location.replace('../home');</script>";
    exit;
}


function btnVerificarBolsistas($idPermitido, $user){
    // Colocar os outros permitidos ou os ADM para acesso à PROEC

    //se a pessoa for permitida, ela entrará aqui para colocar as tabelas e ver se há alunos repetidos em bolsas 
    //As pessoas permitidas estão em CompararAlunos.php 
    if (in_array($user['id'], $idPermitido, true)) {
        $vlrBtn = '<a class="btn btn-dark w-100 mb-1" href="../verificar_bolsistas/index.php">Verificar alunos bolsistas</a>';
    } else {
        $vlrBtn = null;
    }

    return $vlrBtn;
    
}

include '../includes/header.php';
include './includes/front.php';
include '../includes/footer.php';  
?>