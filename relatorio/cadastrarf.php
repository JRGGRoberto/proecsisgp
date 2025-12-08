<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Colegiado;
use App\Entity\Campi;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\RelFinal;
use App\Session\Login;
use App\Entity\Outros;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();


function getRegras($tp_regra, $AGorPROF) : string
{ 
     // Esses ids de regra estão na base de dados na tabela regras, definidas em 2025.
    // Caso crie outras regras que substituam estas, atualizar aqui e manter os que estão no banco para histórico.
   $tpu = $AGorPROF[0];

   $sql = 'select id
           from regras 
           where 
             tp_regra = "relatórios"
             and detalhe = "'.$tp_regra.'"
             and  tp_user = "'.$tpu.'"
          ';

    return Outros::q($sql)->id;
}


$t = $_GET['t'];
$id = $_GET['i'];
$tf = $_GET['f'];

if ($t != 2) {
    header('location: index.php?status=error');
    exit;
}



$obProjeto = Projeto::getProjetoLast($id);

$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = Professor::getProfessor($obProjeto->id_prof);

if ($obProjeto->id_prof != $user['id']) {
    header('location: ../index.php?status=errorOwner');
    exit;
}


$cursosetor = '';
if ($obProjeto->para_avaliar == -1) {
    $cursosetor = ''.$user['ca_nome'];
} else {
    $cursosetor = ''.  $user['tipo'] == 'prof' ?
    Colegiado::getRegistro($obProjeto->para_avaliar)->nome :
    Campi::getRegistro($obProjeto->para_avaliar)->nome;
}

$relatorio = new RelFinal();


$regra = getRegras($tf, $user['tipo']) ;



// VALIDAÇÃO DO POST
if (isset($_POST['valida'])) {
    $relatorio->idproj = $obProjeto->id;
    $relatorio->tipo = $tf;


    $relatorio->regra = $regra ;

    if ($tf == 're') {
        $relatorio->periodo_renov_ini = $_POST['periodo_renov_ini'];
        $relatorio->periodo_renov_fim = $_POST['periodo_renov_fim'];
    }

    if ($tf == 'pr') {
        $relatorio->periodo_prorroga_fim = $_POST['periodo_prorroga_fim'];
        $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    }

    $relatorio->ch_semanal = $_POST['ch_semanal'];
    $relatorio->dim_mem_com_ex = $_POST['dim_mem_com_ex'];
    $relatorio->dim_disc = $_POST['dim_disc'];
    $relatorio->dim_doce = $_POST['dim_doce'];
    $relatorio->dim_agent_estag = $_POST['dim_agent_estag'];
    $relatorio->atividades = $_POST['atividades'];

    $relatorio->rel_tec_cien_executado = $_POST['rel_tec_cien_executado'];
    $relatorio->divulgacao = $_POST['divulgacao'];
    $relatorio->tramitar = $_POST['tramitar'];
    $relatorio->visita_tec_qtd = $_POST['visita_tec_qtd'];

    $idprjP = $relatorio->cadastrar();

    $anexosJS = json_decode($_POST['anexosJS']);

    foreach ($anexosJS as &$anx) {
        $dados = Arquivo::getArquivo($anx);
        $dados->tabela = 'relatorios';
        $dados->id_tab = $idprjP;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }

    header('location: index.php?id='.$obProjeto->id);
    exit;
}
$anex = '';
$editar = '';
$msgSolicitacoAlteracao = '';
// $relatorio
$relatorio->visita_tec_qtd = 0;
$relatorio->ch_semanal = 0;
$relatorio->dim_mem_com_ex = 0;
$relatorio->dim_disc = 0;
$relatorio->dim_doce = 0;
$relatorio->dim_agent_estag = 0;

include '../includes/header.php';


$reg = getRegras($tf, $user['tipo']) ;
 


$sql = '
select 
	r.id ,  r.nome, rd.sequencia etapas, r.obs,  r.tp_regra, r.aprov_auto ,
	rd.nome, rd.form, 
 	case rd.tp_avaliador 
        when "ca" then "Chefe de Divisão"
        when "ce" then "Diretor(ª) de Centro de Área"
        when "co" then "Coordenador(ª) de colegiado"
        when "dc" then "Diretor(ª) de campus"
    end as avaliador
from 
  	regras r
  	inner join regras_defin rd on rd.id_reg  = r.id 
where 
  	r.tp_regra = "relatorios" and
    r.id = "'. $reg .'"
order by
  	r.aprov_auto, r.nome,  rd.sequencia ;
';

$modalRelatorio = Outros::qry($sql);

// echo '<pre>';
// print_r($modalRelatorio);
// echo '</pre>';

$resultModal = '';

foreach ($modalRelatorio as $modalRel) {
    $resultModal .=
       '<tr>
        <td>'.$modalRel->etapas.'</td>
        <td>'.$modalRel->avaliador.' </td>
      </tr>
  ';
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
      <th>Etapa</th>
      <th>Quem avalia</th>
    </tr>
  </thead>
  <tbody>'
    .$resultModal.
  '</tbody>
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

include __DIR__.'/includes/formFinal.php';

include '../includes/footer.php';
