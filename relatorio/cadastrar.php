<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;

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


use App\Entity\Arquivo;
use App\Entity\Equipe;
use App\Entity\Palavras;

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

    if (($user['tipo'] == 'professor') || $user['tipo'] == 'prof') {
        $regra = '6204ba97-7f1a-499e-a17d-118d305bf7e4';
    } elseif ($user['tipo'] == 'agente') {
        $regra = 'a45daba2-12ec-11ef-b2c8-0266ad9885af';
    }
    $obProjeto->regras = $regra;

    if (in_array($t, $anexoII)) {
        if ($_POST['ch_semanal'] == null) {
            $obProjeto->ch_semanal = 0;
        } else {
            $obProjeto->ch_semanal = $_POST['ch_semanal'];
        }

        $obProjeto->referencia = $_POST['referencia'];

        $cnpq_garea = 0;
        try {
            $cnpq_garea = intval($_POST['cnpq_garea']);
        } catch (Exception $e) {
            $cnpq_garea = 0;
        }
        $obProjeto->cnpq_garea = $cnpq_garea;

        $obProjeto->cnpq_area = $_POST['cnpq_area'];
        $obProjeto->cnpq_sarea = $_POST['cnpq_sarea'] ?? 0;

        
    }

    $obProjeto->area_extensao = $_POST['area_extensao'];
    $obProjeto->linh_ext = $_POST['linh_ext'];

    $obProjeto->contribuicao = $_POST['contribuicao'];

    if (in_array($t, $anexoIII)) {
        if ($_POST['ch_total'] == null) {
            $obProjeto->ch_total = 0;
        } else {
            $obProjeto->ch_total = $_POST['ch_total'];
        }
    }

    $obProjeto->obs = $_POST['obs'];

    $obProjeto->resumo = $_POST['resumo'];
    // $obProjeto->descricao    =  $_POST['descricao'];
    $obProjeto->objetivos = $_POST['objetivos'];
    $obProjeto->public_alvo = $_POST['public_alvo'];
    $obProjeto->metodologia = $_POST['metodologia'];
    // $obProjeto->prodserv_espe   =  $_POST['prodserv_espe'];

    // $obProjeto->contrap_nofinac =  $_POST['contrap_nofinac'];
    $obProjeto->municipios_abr = $_POST['municipios_abr'];
    // $obProjeto->n_cert_prev     =  $_POST['n_cert_prev'];
    $obProjeto->data = $_POST['data'];
    // $obProjeto->outs_info       =  $_POST['outs_info'];
    $obProjeto->acec = $_POST['acec'];
    $obProjeto->vinculo = $_POST['vinculo'];

    if ($obProjeto->vinculo == 'S') {
        $obProjeto->tituloprogvinc = $_POST['tituloprogvinc'];
    }

    $obProjeto->finac = $_POST['finac'];
    if ($obProjeto->finac == 'S') {
        $obProjeto->finacorgao = $_POST['finacorgao'];
        $obProjeto->finacval = $_POST['finacval'];
    }

    $obProjeto->justificativa = $_POST['justificativa'];
    $obProjeto->cronograma = $_POST['cronograma'];

    if (in_array($t, $anexoII)) {
        $obProjeto->referencia = $_POST['referencia'];
    }

    /*
    $obProjeto->parceria       =  $_POST['parceria'];
    if($obProjeto->parceria == 'S'){
      $obProjeto->parcaatribuic  =  $_POST['parcaatribuic'];
      $obProjeto->parcanomes     =  $_POST['parcanomes'];
    }
*/

    $palav1 = $_POST['palav1'];
    $palav2 = $_POST['palav2'];
    $palav3 = $_POST['palav3'];

    // sempre que cadastrar "para avaliar" ficará com o valor de -1.
    $obProjeto->para_avaliar = -1;
    // 'created_at' => $this->created_at,
    // 'updated_at' => date("Y-m-d H:i:s"),
    $obProjeto->user = $user['id'];

    $idprjP = $obProjeto->cadastrar();

    if (strlen($palav1) > 0) {
        $ObjPalav1 = new Palavras();
        $ObjPalav1->incluir($idprjP, $palav1);
    }
    if (strlen($palav2) > 0) {
        $ObjPalav2 = new Palavras();
        $ObjPalav2->incluir($idprjP, $palav2);
    }
    if (strlen($palav3) > 0) {
        $ObjPalav3 = new Palavras();
        $ObjPalav3->incluir($idprjP, $palav3);
    }

    $equipeJS = $_POST['equipeJS'];
    $arrEq = json_decode($equipeJS, true);
    $index = 1;
    foreach ($arrEq as $key => $memb) {
        $objMembro = new Equipe();
        $objMembro->incluir(
            $index,
            $idprjP,
            $memb['nome'],
            $memb['instituicao'],
            $memb['formacao'],
            $memb['funcao'],
            $memb['tel'],
            $memb['dtinicio'],
            $memb['dtfim']
        );
        ++$index;
    }

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

$scriptVars =
"<script>
  let equipe = []; 
  let dataAtual = new Date();
  document.getElementById('vigen_ini').valueAsDate = dataAtual;
  document.getElementById('dateAssing').valueAsDate = dataAtual;
  dataAtual.setFullYear(dataAtual.getFullYear() + 1);
  document.getElementById('vigen_fim').valueAsDate = dataAtual;
  
</script>";

include '../includes/header.php';

if ($t == 1) {
    include __DIR__.'/includes/formParcial.php';

    
} elseif ($t == 2) {
    include __DIR__.'/includes/formFinal.php';
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
