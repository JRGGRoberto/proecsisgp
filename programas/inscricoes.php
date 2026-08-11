<?php

include '../vendor/autoload.php';

use App\Entity\Candidato;
use App\Entity\Inscricao;
use App\Session\LoginCandidato;

$tipo = $_GET['tp'];
$filtro = '';
switch ($tipo) {
    case 'pibis':
        $filtro = 'pibis';
        break;
    case 'pibex':
        $filtro = 'pibex';
        break;
    default:
        $filtro = '';
}

$options = '';

$user = LoginCandidato::getUsuarioLogado();

echo '
<script>
  cand_id = "'.$user['id'].'";
   filtro = "'.$filtro.'"
</script>';
// echo '<pre>';
// print_r($user['id']);
// echo '</pre>';

$cpf = $user['cpf'] ?? null;
// print_r($cpf);
if (!$cpf) {
    exit('CPF não encontrado na sessão');
}

$senha = $_POST['senha'] ?? null;

$cand = Candidato::getCpf($cpf);

$msg = '';
if (!$cand) {
    $cand = new Candidato();
    $user['id'] = null;
    $evento = 'cadastrar';
} else {
    $evento = 'editar';
    $cand2 = (object) Candidato::getCpf($cpf);
    $user['id'] = $cand2->id;
    // header('location: cadastrar.php?erro=1');
}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;

if (isset($_POST['inscricao']) && $_POST['inscricao'] != -1) {
    $inscricao = new Inscricao();
    //   echo '<pre>';
    // print_r($inscricao);
    // echo '</pre>';
    // exit;
    $inscricao->id_can = $user['id'];
    $inscricao->id_prog = $_POST['inscricao'];
    $inscricao->cadastrar();
    $msg = '
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Success!</strong> Inscrição no programa realizada
    </div>
  ';
}

if (isset($_POST['id_cand_del'])) {
    $user['id'] = $_POST['id_cand_del'];
    $idProg = $_POST['id_prog_del'];
    $inscricao = Inscricao::get($user['id'], $idProg);
    if ($inscricao) {
        $inscricao->delete();
        $msg = '
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> Remoção da inscrição do programa realizada com sucesso.
      </div>
    ';
    } else {
        $msg = '
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Success!</strong> Inscrição não encontrada ou já removida.
    </div>
    ';
    }
    $cand = (object) Candidato::get($user['id']);
    $cpf = $cand->cpf;
}

include '../includes/headerCand.php';
echo $msg;
echo '
<script>
   cand_id = "'.$user['id'].'";
</script>';

include __DIR__.'/includes/formInscricao.php';
include '../includes/footer.php';
