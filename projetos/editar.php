<?php

require '../vendor/autoload.php';
use App\Session\Login;

Login::requireLogin();

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

use App\Entity\Arquivo;
use App\Entity\Diversos;
use App\Entity\Equipe;
use App\Entity\Palavras;
use App\Entity\Projeto;

$user = Login::getUsuarioLogado();

$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
            break;
    }
}

// VALIDAÇÃO DO ID
if (!isset($_GET['id'], $_GET['v'])) {
    header('location: index.php?status=error');
    exit;
}
$id = $_GET['id'];
$ver = $_GET['v'];

// CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto = Projeto::getProjeto($id, $ver);

$palavras = Palavras::getPalavrasByProj($obProjeto->id);

$palav1 = $palavras[0]->palavra ?? null;
$palav2 = $palavras[1]->palavra ?? null;
$palav3 = $palavras[2]->palavra ?? null;

// VALIDAÇÃO DA TIPO
if (!$obProjeto instanceof Projeto) {
    header('location: ../index.php?status=error');
    exit;
}

use App\Entity\Area_Extensao;

$area_ext = Area_Extensao::getRegistros($obProjeto->id);
$area_ext_Opt = '';
foreach ($area_ext as $aext) {
    $area_ext_Opt .= '<option value="'.$aext->id.'" '.$aext->sel.'>'.$aext->nome.'</option>';
}

use App\Entity\Area_temat;

$area_tem1 = Area_temat::getRegistros();
$areaOptions = '';
foreach ($area_tem1 as $area) {
    $areaOptions .= '<option value="'.$area->id.'" '.$area->sel.'>'.$area->nome.'</option>';
}

$telefone = '';
$email = '';

use App\Entity\Agente;
use App\Entity\Professor;

if (($user['tipo'] == 'professor') || $user['tipo'] == 'prof') {
    $dadosProf = Professor::getDadosProf($obProjeto->id_prof);
    $telefone = $dadosProf->telefone;
    $email = $dadosProf->email;
} elseif ($user['tipo'] == 'agente') {
    $dadosAgentes = Agente::get($obProjeto->id_prof);
    $telefone = $dadosAgentes->telefone;
    $email = $dadosAgentes->email;
}

$anexados = Arquivo::getAnexados('projetos', $obProjeto->id);
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

$t = $obProjeto->tipo_exten;
$anexoIII = [1, 2];
$anexoII = [3, 4, 5];

switch ($t) {
    case 1:
        define('TITLE', 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE CURSO');
        break;
    case 2:
        define('TITLE', 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTA DE EVENTO');
        break;
    case 3:
        define('TITLE', 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PRESTAÇÃO DE SERVIÇO');
        break;
    case 4:
        define('TITLE', 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROGRAMA');
        break;
    case 5:
        define('TITLE', 'FORMULÁRIO PARA ELABORAÇÃO DE PROPOSTAS DE PROJETO');
        break;
    default:
        header('location: index.php?status=error');
        exit;
}

$equipe = Equipe::getMembProj($obProjeto->id);

$scriptVars =
'<script>
    let equipe = '.json_encode($equipe, JSON_NUMERIC_CHECK).'
</script>';

// VALIDAÇÃO DO POST
if (isset($_POST['titulo'])) {
    $obProjeto->tipo_exten = $t;
    $obProjeto->titulo = $_POST['titulo'];
    $obProjeto->tide = $_POST['tide'];
    $obProjeto->vigen_ini = $_POST['vigen_ini'];
    $obProjeto->vigen_fim = $_POST['vigen_fim'];
    $obProjeto->resumo = $_POST['resumo'];
    $obProjeto->objetivos = $_POST['objetivos'];
    $obProjeto->public_alvo = $_POST['public_alvo'];
    $obProjeto->metodologia = $_POST['metodologia'];
    $obProjeto->municipios_abr = $_POST['municipios_abr'];
    $obProjeto->data = $_POST['data'];
    $obProjeto->acec = $_POST['acec'];
    $obProjeto->vinculo = $_POST['vinculo'];
    $obProjeto->justificativa = $_POST['justificativa'];
    $obProjeto->cronograma = $_POST['cronograma'];
    // $obProjeto->parceria        =  $_POST['parceria'];
    $obProjeto->updated_at = date('Y-m-d H:i:s');
    $obProjeto->user = $user['id'];
    $obProjeto->last_result = 'n';
    $obProjeto->contribuicao = $_POST['contribuicao'];

    $obProjeto->obs = $_POST['obs'];

    if (($user['tipo'] == 'professor') || $user['tipo'] == 'prof') {
        $regra = '6204ba97-7f1a-499e-a17d-118d305bf7e4';
    } elseif ($user['tipo'] == 'agente') {
        $regra = 'a45daba2-12ec-11ef-b2c8-0266ad9885af';
    }
    $obProjeto->regras = $regra;

    if (in_array($t, $anexoII)) {
        $obProjeto->ch_semanal = $_POST['ch_semanal'];

        $obProjeto->referencia = $_POST['referencia'];

        $cnpq_garea = 0;
        try {
            $cnpq_garea = intval($_POST['cnpq_garea']);
        } catch (Exception $e) {
            $cnpq_garea = 0;
        }
        $obProjeto->cnpq_garea = $cnpq_garea;

        $obProjeto->cnpq_sarea = $_POST['cnpq_sarea'];
        $obProjeto->area_extensao = $_POST['area_extensao'];
        $obProjeto->linh_ext = $_POST['linh_ext'];
        $obProjeto->referencia = $_POST['referencia'];
    }

    if (in_array($t, $anexoIII)) {
        $obProjeto->ch_total = $_POST['ch_total'];
    }

    /* não aceito no anexo III

    $obProjeto->descricao    =  $_POST['descricao'];
    $obProjeto->prodserv_espe   =  $_POST['prodserv_espe'];
    $obProjeto->n_cert_prev     =  $_POST['n_cert_prev'];
    */

    if ($obProjeto->vinculo == 'S') {
        $obProjeto->tituloprogvinc = $_POST['tituloprogvinc'];
    } else {
        $obProjeto->tituloprogvinc = null;
    }

    $obProjeto->finac = $_POST['finac'];
    if ($obProjeto->finac == 'S') {
        $obProjeto->finacorgao = $_POST['finacorgao'];
        $obProjeto->finacval = $_POST['finacval'];
    } else {
        $obProjeto->finacorgao = null;
        $obProjeto->finacval = null;
    }ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if ($obProjeto->parceria == 'S') {
        $obProjeto->parcaatribuic = $_POST['parcaatribuic'];
        $obProjeto->parcanomes = $_POST['parcanomes'];
    } else {
        $obProjeto->parcaatribuic = null;
        $obProjeto->parcanomes = null;
    }

    $obProjeto->atualizar();

    $palav1 = $_POST['palav1'];
    $palav2 = $_POST['palav2'];
    $palav3 = $_POST['palav3'];

    Palavras::excluir($obProjeto->id);
    if (strlen($palav1) > 0) {
        $ObjPalav1 = new Palavras();
        $ObjPalav1->incluir($obProjeto->id, $palav1);
    }
    if (strlen($palav2) > 0) {
        $ObjPalav2 = new Palavras();
        $ObjPalav2->incluir($obProjeto->id, $palav2);
    }
    if (strlen($palav3) > 0) {
        $ObjPalav3 = new Palavras();
        $ObjPalav3->incluir($obProjeto->id, $palav3);
    }

    Equipe::excluir($obProjeto->id);
    $equipeJS = $_POST['equipeJS'];
    $arrEq = json_decode($equipeJS, true);
    $index = 1;
    foreach ($arrEq as $key => $memb) {
        $objMembro = new Equipe();
        $objMembro->incluir(
            $index,
            $obProjeto->id,
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
        $dados->id_tab = $obProjeto->id;
        $dados->user = $obProjeto->user;
        $dados->atualizar();
    }
    header('location: ./index.php?status=success');
    exit;
}
/**
 * Chama as partes e realiza alguns testes de valiação.
 */

include '../includes/header.php';

// verifica se o usuário é dono do projeto
if ($user['id'] == $obProjeto->id_prof) {
    if ($obProjeto->edt == 0) {
        echo '<div class="container">
    <hr>
    <div class="container p-3 my-3 bg-danger text-white rounded p-5">
        <h1><span class="badge badge-light"> 🚧 </span> Atenção! </h1>
  
        
        <hr>
        <p><span class="badge badge-light"> 🚨 </span> Edição não permitida.</p>

      </div>
    </div>';
    } else {
        if (in_array($t, $anexoII)) {
            $qryAEO = '';
            $scriptS = '';
            $qryAEO =
                    'SELECT cnpq_garea, cnpq_area, cnpq_sarea  
                FROM projetos
                WHERE  
                   id  = "'.$obProjeto->id.'" 
                   and ver = (select max(ver) from projetos where  id  = "'.$obProjeto->id.'" )';

            $Caeo = Diversos::q($qryAEO);

            $scriptS .= '
            pegarGA().then( 
                (onResolved) => {
                    selectOpt("cnpq_garea","'.$Caeo->cnpq_garea.'")
                }, (onRejected) => { }
            ).then(
              (onResolved) => {
                    pegarAr("'.$Caeo->cnpq_garea.'").then(
                      (onResolved) => {
                        selectOpt("cnpq_area","'.$Caeo->cnpq_area.'")
                      }, (onRejected) => { }
                    )
                }, (onRejected) => { }
            ).then(
              (onResolved) => {
                    pegarSA("'.$Caeo->cnpq_area.'").then(
                      (onResolved) => {
                        selectOpt("cnpq_sarea","'.$Caeo->cnpq_sarea.'")
                      }, (onRejected) => { }
                    )
                }, (onRejected) => { }
            )
            ';

            include __DIR__.'/includes/formAnexoII.php';
            echo '<script src="cnpq.js"></script>';

            echo '<script>

      var ga = document.querySelector("#cnpq_garea");
      var ar = document.querySelector("#cnpq_area");
      var sa = document.querySelector("#cnpq_sarea");




      '.
            $scriptS
            .'      
        
      </script>';
        } elseif (in_array($t, $anexoIII)) {
            include __DIR__.'/includes/formAnexoIII.php';
        } else {
            header('location: index.php?status=error');
            exit;
        }
    }
} else {
    echo '<div class="container">
          <hr>
          <div class="container p-3 my-3 bg-danger text-white rounded p-5">
            <h1><span class="badge badge-light"> 🚧 </span> Atenção! </h1>
            <hr>
            <p><span class="badge badge-light"> 🚨 </span> Operação não permitida.</p>
          </div>
        ';

    echo 'Evento log:  <br>';
    echo 'User ID: '.$user['id'].'<br>';
    echo 'URI: '.$_SERVER['REQUEST_URI'].'<br>';
    date_default_timezone_set('America/Sao_Paulo');
    echo 'Data time: '.date('d-m-Y h:i:sa').'<br>';
    echo '</div>';
}

echo "
<script>

let area_extensao   = document.getElementById('area_extensao');
let linh_ext   = document.getElementById('linh_ext');

area_extensao.value = '$obProjeto->area_extensao';
linh_ext.value = '$obProjeto->linh_ext';

</script>
";

include '../includes/footer.php';
