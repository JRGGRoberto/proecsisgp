<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;
use App\Entity\Arquivo;
use App\Entity\RelParcial;




// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();


$t = $_GET['t'];
$id = $_GET['i'];

switch ($t) {
    case 1:
        define('TITLE', 'RELATÓRIO PARCIAL');
        break;
    case 2:
        define('TITLE', 'RELATÓRIO FINAL');
        break;
    default:
        header('location: index.php?status=error');
        exit;
}

$obProjeto = new Projeto();
$obProjeto = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);



// Quando a ação for para remover anexo
if (isset($_POST['acao']) == 'removeAnexo') {
    // Recuperando nome do arquivo
    $arquivo = $_POST['arquivo'];
    // Caminho dos uploads
    $caminho = '../upload/uploads/';
    // Verificando se o arquivo realmente existe
    if (file_exists($caminho.$arquivo) and !empty($arquivo)) {
        // Removendo arquivo
        unlink($caminho.$arquivo);
    }
    // Finaliza a requisição
    exit;
}


// VALIDAÇÃO DO POST
if (isset($_POST['titulo'])) {
    // $obProjeto->ver          =  $_POST['ver'];
    $obProjeto->id_prof = $user['id'];
    $obProjeto->nome_prof = $user['nome'];
    $obProjeto->tipo_exten = $t;
    $obProjeto->titulo = $_POST['titulo'];
    $obProjeto->tide = $_POST['tide'];
    $obProjeto->vigen_ini = $_POST['vigen_ini'];
    $obProjeto->vigen_fim = $_POST['vigen_fim'];


    // sempre que cadastrar "para avaliar" ficará com o valor de -1.
    $obProjeto->para_avaliar = -1;
    // 'created_at' => $this->created_at,
    // 'updated_at' => date("Y-m-d H:i:s"),
    $obProjeto->user = $user['id'];


    $anexosJS = json_decode($_POST['anexosJS']);
    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = $_POST['tabela'];
        $dados->id_tab = $idprjP;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }

    header('location: index.php?status=success');
    exit;
}
$anex = '';



include '../includes/header.php';



if ($t == 1) {
    include __DIR__.'/includes/formParcial.php';
    $relatorio = new RelParcial();

    
} elseif ($t == 2) {
    include __DIR__.'/includes/formFinal.php';
    $relatorio = new ReFinal();

} else {
    header('location: index.php?status=error');
    exit;
}


echo '
<!-- The Modal -->
<div class="modal fade" id="modelEtapasAvala">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ordem de tramitação</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        *O responsável pelo preenchimento e encaminhamento é o coordenador da Proposta de Extensão
        <table class="table table-bordered">
  <thead class="thead-light">
    <tr>
      <th>Quem avalia</th>
      <th>Formulário</th>
    </tr>
  </thead>
  <tbody>'.
   $a = 'aa'
  .'</tbody>
</table>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<script>
$("#modelEtapasAvala").modal("show");
</script>

';

include '../includes/footer.php';
