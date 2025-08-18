<?php

require '../vendor/autoload.php';
use App\Entity\Candidato;
use App\Entity\Inscricao;

$options = '';
$idCand = '';

$cpf = $_POST['cpf'];
$cand = Candidato::getCPF($cpf);
$msg = '';

if (!$cand) {
    $cand = new Candidato();
    $idCand = null;
    $evento = 'cadastrar';
} else {
    $evento = 'editar';
    $cand2 = (object) Candidato::getCPF($_POST['cpf']);
    $idCand = $cand2->id;
}

$ip = 'ααα.ABC.XYZ.ΩΩΩ';

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (isset($_POST['nome'])) {
    $cand->nome = $_POST['nome'];
    $cand->rg = $_POST['rg'];
    $cand->cpf = $_POST['cpf'];
    $cand->dt_nasc = $_POST['dt_nasc'];
    $cand->ender = $_POST['ender'];
    $cand->bairro = $_POST['bairro'];
    $cand->cidade = $_POST['cidade'];
    $cand->uf = $_POST['uf'];
    $cand->cep = $_POST['cep'];
    $cand->tel1 = $_POST['tel1'];
    $cand->tel2 = $_POST['tel2'];
    $cand->email = $_POST['email'];
    $cand->curso = $_POST['curso'];
    $cand->serie = $_POST['serie'];
    $cand->ip_address = $ip;

    if ($evento == 'cadastrar') {
        $idCand = $cand->cadastrar();
        $msg = '
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Success!</strong> Cadastro de usuário realizado
        </div>';
    } else {
        $cand->atualizar();
        $msg = '
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Success!</strong> Dados de usuário atualizado
        </div>';
    }

    if ($_POST['inscricao'] != -1) {
        $inscricao = new Inscricao();
        $inscricao->id_can = $idCand;
        $inscricao->id_prog = $_POST['inscricao'];
        $inscricao->cadastrar();
        $msg = '
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Success!</strong> Inscrição no programa realizada
        </div>';
    }
}

if (isset($_POST['id_cand_del'])) {
    $idCand = $_POST['id_cand_del'];
    $idProg = $_POST['id_prog_del'];
    $inscricao = Inscricao::get($idCand, $idProg);
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
    $cand = (object) Candidato::get($idCand);
    $cpf = $cand->cpf;
}

include '../includes/headers.php';
echo $msg;
echo '
<script>
   cand_id = "'.$idCand.'";
</script>';
include __DIR__.'/includes/formulario.php';
include '../includes/footer.php';
