<?php

require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Session\Login;
use App\Entity\Projeto;
use App\Entity\Professor;
use App\Entity\Arquivo;
use App\Entity\RelParcial;
use App\Entity\RelFinal;
use App\Entity\Campi;
use App\Entity\Colegiado;
use App\Entity\HistRelatorios;



// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

$id = $_GET['id'];
$tp = $_GET['t'];

// VALIDAÇÃO DO POST
if (isset($_POST['etapa'])) {
    $HistRelatorios = new HistRelatorios();
    $HistRelatorios->id_relatorio = $_POST['id_relatorio'];
    $HistRelatorios->tp_avaliador = $_POST['tp_avaliador'];
    $HistRelatorios->id_instancia = $_POST['id_instancia'];
    $HistRelatorios->etapa = $_POST['etapa'];
    $HistRelatorios->resultado = $_POST['resultado'];
    $HistRelatorios->ava_comentario = $_POST['ava_comentario'];
    $HistRelatorios->tp_relatorio = $_POST['tp_relatorio'];
    $HistRelatorios->user = $user['id'];
    $HistRelatorios->cadastrar();




    if( in_array($_POST['tp_relatorio'], ['fi', 're', 'pr'])){
        $relFIM =  (object)RelFinal::get($_POST['id_relatorio']);
        if($_POST['resultado'] == 'a'){
            if($relFIM->etapa < $relFIM->etapas){
                $relFIM->etapa++;
            } else{
                $relFIM->last_result = 'a';
            }
        } elseif($_POST['resultado'] == 'r'){
            $relFIM->tramitar = 0;
            $relFIM->last_result = 'r';
        }
        $relFIM->atualizar();
    } else { // pa
        $relPARCIAL =  (object)RelParcial::get($_POST['id_relatorio']);
        if($_POST['resultado'] == 'a'){
            if($_POST['etapa'] < $_POST['etapas']){
                $relPARCIAL->etapa++;
            } else{
                $relPARCIAL->last_result ='a';
            }
        } elseif($_POST['resultado'] == 'r'){
            $relPARCIAL->tramitar = 0;
            $relPARCIAL->last_result = 'r';
        }
        $relPARCIAL->atualizar();
    }

    header('location: index.php?id='.$obProjeto->id);
    exit;
}

$cursosetor ='';
$obProfessor = null;
function getLocal($idProjeto, $nomeC){
    $obProjeto = (object)Projeto::getProjetoLast($idProjeto);
    $obProjeto = Projeto::getProjeto($obProjeto->id, $obProjeto->ver);
    $obProfessor = Professor::getProfessor($obProjeto->id_prof);
    if (Colegiado::getRegistro($obProjeto->para_avaliar) instanceof Colegiado) {
        $cursosetor = Colegiado::getRegistro($obProjeto->para_avaliar)->nome;
    } elseif (Campi::getRegistro($obProjeto->para_avaliar) instanceof Campi) {
        $cursosetor = Campi::getRegistro($obProjeto->para_avaliar)->nome;
    } else {
        $cursosetor =  $nomeC;
    }
    return (object)[
        'obProjeto' => $obProjeto,
        'obProfessor' => $obProfessor,
        'cursosetor' => $cursosetor
    ];
}

$anex = '';
function listarAnexos($id){
    $anexados = Arquivo::getAnexados('relatorios', $id);
    $anex = '<ul id="anexos_edt">';
    foreach ($anexados as $att) {
        $anex .=
        '<li>
          <a href="/sistema/upload/uploads/'.$att->nome_rand.'" target="_blank">'.$att->nome_orig.'</a> 
          <a href="../arquiv/index.php?tab='.$att->tabela.'&id='.$att->id_tab.'&arq='.$att->nome_rand.'" >  
            <span class="badge badge-danger">🗑️ Excluir</span>
          </a>
      </li> ';
    }
    $anex .= '</ul>';
}

$scriptDisbleFinal = "<script>
                        $('#sumnot_atividades').summernote('disable');
                        $('#sumnot_atvd_prox_per').summernote('disable');
                        $('#sumnot_rel_tec_cien_executado').summernote('disable');
                        $('#sumnot_divulgacao').summernote('disable');
                       </script>";


$scriptDisbleParcial = "<script>
                    $('#sumnot_atvd_per').summernote('disable');
                    $('#sumnot_alteracoes').summernote('disable');
                    $('#sumnot_atvd_prox_per').summernote('disable');
                    $('#sumnot_atvd_prox_per').summernote('disable');
                </script>";
      

include '../includes/header.php';
$obj = null;
if($tp == 'p'){
    $relatorio = new RelParcial(); 
    $relatorio = (object)RelParcial::get($id);
    $obj = getLocal($relatorio->idproj, $user['ca_nome']);
    $obProjeto = $obj->obProjeto;
    $obProfessor = $obj->obProfessor;
    $cursosetor = $obj->cursosetor;
    listarAnexos($relatorio->id);
    include __DIR__.'/includes/formParcial.php';
    $tipo_rela = 'pa';
    echo $scriptDisbleParcial;
} else {
    $relatorio = new RelFinal(); 
    $relatorio = (object)RelFinal::get($id);
    $obj = getLocal($relatorio->idproj, $user['ca_nome']);
    $obProjeto = $obj->obProjeto;
    $obProfessor = $obj->obProfessor;
    $cursosetor = $obj->cursosetor;
    listarAnexos($relatorio->id);
    include __DIR__.'/includes/formFinal.php';
    $tipo_rela = $relatorio->tipo;
    echo $scriptDisbleFinal;
};

switch ($user['config'] ) {
    case '0':
        $tp_avaliador = 'pr';
        $id_instancia = $user['id'];
        break;
    case '1':
        $tp_avaliador = 'co';
        $id_instancia = $user['co_id'];
        break;
    case '2':
        $tp_avaliador = 'ce';
        $id_instancia = $user['ce_id'];
        break;
    case '3':
        $tp_avaliador = 'ca';
        $id_instancia = $user['ca_id'];
        break;
    case '4':
        $tp_avaliador = 'dc';
        $id_instancia = $user['ca_id'];
        break;
}


include './includes/formAvaliar.php'; 

include '../includes/footer.php'; 