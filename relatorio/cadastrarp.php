<?php

require '../vendor/autoload.php';

use App\Entity\Arquivo;
use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Entity\RelParcial;
use App\Session\Login;
use App\Entity\Outros;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();


function getRegras($user) : array
{ 
     // Esses ids de regra estão na base de dados na tabela regras, definidas em 2025.
    // Caso crie outras regras que substituam estas, atualizar aqui e manter os que estão no banco para histórico.
   $tpu = $user['tipo'][0];

   $sql =  'select
              r.id, count(1) etapas
            from 
              regras r
              inner join regras_defin rd on rd.id_reg  = r.id   
            where 
              r.tp_regra = "relatórios"  and 
              r.detalhe = "pa"           and  
              r.tp_user = "'.$tpu.'"
            group by r.id
          ';
    return (array)Outros::q($sql);
}

$t = $_GET['t'];
$id = $_GET['i'];

if ($t != 1) {
    header('location: index.php?status=error');
    exit;
}

$obProjeto = Projeto::getProjetoLast($id);
$obProjeto = Projeto::getProjeto($id, $obProjeto->ver);
$obProfessor = (object) Professor::getProfessor($obProjeto->id_prof);

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

$regras = getRegras($user);


$relatorio = new RelParcial();
// VALIDAÇÃO DO POST
if (isset($_POST['atvd_per'])) {
    $relatorio->idproj = $obProjeto->id;

        $relatorio->regra = $regras['id'];

        $relatorio->caminho = $obProjeto->para_avaliar;

    $relatorio->periodo_ini = $_POST['periodo_ini'];
    $relatorio->periodo_fim = $_POST['periodo_fim'];
    $relatorio->atvd_per = $_POST['atvd_per'];
    $relatorio->alteracoes = $_POST['alteracoes'];
    $relatorio->atvd_prox_per = $_POST['atvd_prox_per'];
    $relatorio->etapas = $regras['etapas'];
    $relatorio->user = $user['id'];
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
$relatorio->visita_tec_qtd = 0;

include '../includes/header.php';


// $reg = getRegras($tf, $user['tipo']) ;
 


$sql = '
select 
	r.id ,  r.nome, rd.sequencia etapas, r.obs,  r.tp_regra, r.aprov_auto ,
	rd.nome, rd.form, 
 	case rd.tp_avaliador 
        when "ca" then "Chefe de Divisão"
    end as avaliador
from 
  	regras r
  	inner join regras_defin rd on rd.id_reg  = r.id 
where 
  	r.tp_regra = "relatorios" and
    r.id = "7692eb56-882e-11f0-b5b5-fed708dafd3c"
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


include __DIR__.'/includes/formParcial.php';

include '../includes/footer.php';
