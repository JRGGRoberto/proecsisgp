<?php

require '../vendor/autoload.php';

use App\Session\Login;

$obUsuario = Login::getUsuarioLogado();

use App\Entity\CompararAlunos;
use App\Entity\MicroCred_avaliadores;
// use App\Entity\Pibis_pibex_avaliadores;
use App\Entity\Outros;

$idPermitido = CompararAlunos::getIdPermitidos();

$clock = [
    '🕛', '🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚',
];

$horas = date('H');
$horas >= 12 ? (int) ($horas -= 12) : (int) ($horas -= 0);

$all = '';
$autorizados = [
    '91ad9f28-8819-42c9-b6a9-18f284ee7453', // [MARILDA DE LARA SANTOS] Agente Sol Ângela Deeke Curitiba I 11/06/2025
    '3d1be647-d7e3-4d00-a642-75ea14059b5b', // [IRENE OLIVEIRA        ] Agente Sol Ângela Deeke Curitiba I 11/07/2025
    'c492dd7e-ac95-4d9f-b1c0-c7fc63340dd6', // [PAULO SERGIO SANTOS] Estágiário - Sérgio Dantas 21/07/2025
    'a68f28dd-2b1b-49ec-8ef8-b6ed28ab3376', //  [SUWELLY GONÇALVES SUASSUI PICH] Solicitação  Daniela Machado 31/07/2025
];

/*
$menuPibis = '';
$idUser = $obUsuario['id'];
// Verifica se o usuário é um avaliador do PIBIS
$obAvaliador = Pibis_pibex_avaliadores::getQntd('id = "'.$idUser.'" and ativo = 1');
if ($obAvaliador > 0) {
    $menuPibis = '
    <div class="btn-group btn-group-sm">
       <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">PIBIS/PIBEX</button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../pibisbex">Avaliar</a>';
    $obAvaliador = Pibis_pibex_avaliadores::get($idUser, 'adm = 1');
    if ($obAvaliador instanceof Pibis_pibex_avaliadores) {
        $menuPibis .= "<a class='dropdown-item btn-sm' href='../pibisbexConf'>Acompanhamento</a>";
    }

    $menuPibis .= '</div>
      </div>
    </div>

    ';
} else {
    $menuPibis = '';
}
*/

$menuAcompa = '';
$qry123 = 'select distinct  prof_id from progradisp   where prof_id = "'.$obUsuario['id'].'"';
$acompanha = Outros::qry($qry123);
if (count($acompanha) > 0) {
    $menuAcompa = '
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Acompanhamento</button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../candidatos">Acompanhar</a>
        </div>
    </div>

    ';
} else {
    $menuAcompa = '';
}
// $menuPibis = '';

$menuMicro = '';
$idUser = $obUsuario['id'];
// Verifica se o usuário é um avaliador do PIBIS
$obAvaliador = MicroCred_avaliadores::getQntd('id = "'.$idUser.'" and ativo = 1');
if ($obAvaliador > 0) {
    $menuMicro = '
    <div class="btn-group btn-group-sm">
       <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Microcredenciais</button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../microcredenciais">Avaliar</a>';
    $obAvaliador = MicroCred_avaliadores::get($idUser, 'adm = 1');
    if ($obAvaliador instanceof MicroCred_avaliadores) {
        $menuMicro .= "<a class='dropdown-item btn-sm' href='../microConf'>Acompanhamento</a>";
    }

    $menuMicro .= '</div>
      </div>
    </div>

    ';
} else {
    $menuMicro = '';
}

if ($obUsuario['config'] > 0 or in_array($obUsuario['id'], $autorizados)) {
    $all = "<div class='dropdown-divider'></div>
          <a class='dropdown-item btn-sm' href='../projetos/indexAll.php'>Todos os Projetos</a>";
}

$adminOpts = '';
if ($obUsuario['adm'] == 1) {
    $adminOpts =
      "<div class='btn-group btn-group-sm'>
        <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
        🔧 Administração
        </button>
        <div class='dropdown-menu'>
          <a class='dropdown-item btn-sm' href='../professor'>Listar Professores/Agentes</a>
          <a class='dropdown-item btn-sm' href='../professor/cadastrar.php'>Cadastrar Professor</a>
          <a class='dropdown-item btn-sm' href='../agente/cadastrar.php'>Cadastrar Agente</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item btn-sm' href='../hierarquia/index.php?hi=cnf'>Configurar hierarquia</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item btn-sm' href='../projetos/indexAll.php'>Todos os Projetos</a>

                        
          <button class='btn btn-light dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                Propostas ADM
          </button>
         
          <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuButton'>
                <a class='dropdown-item btn-sm' href='../projetos/cadastrarADM.php?t=4'>Novo Programa ADM</a>
                <a class='dropdown-item btn-sm' href='../projetos/cadastrarADM.php?t=5'>Novo Projeto ADM</a>
                <a class='dropdown-item btn-sm' href='../projetos/cadastrarADM.php?t=3'>Nova Prestação de Serviço ADM</a>
                <div class='dropdown-divider'></div>
                <a class='dropdown-item btn-sm' href='../projetos/cadastrarADM.php?t=1'>Novo Curso ADM</a>
                <a class='dropdown-item btn-sm' href='../projetos/cadastrarADM.php?t=2'>Novo Evento ADM</a>
          </div>
        </div>
      </div>";
}

$nome = explode(' ', trim($obUsuario['nome']));
$nome = $nome[0]; // will print Test

?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <!-- <link rel="stylesheet" href="../includes/bootstrap-4.6.2-dist/css/bootstrap.min.css">
  <script src="../includes/jquery.min.js"></script>
  <script src="../includes/popper.min.js"></script>
  <script src="../includes/bootstrap-4.6.2-dist/js/bootstrap.bundle.min.js"></script>
-->

  <link href="../includes/summernote-bs4.min.css" rel="stylesheet">
  <script src="../includes/summernote-bs4.min.js"></script>
  <!-- para a inserção de leitor de xlsx -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://sistemaproec.unespar.edu.br/sistema/includes/summernote-bs4.min.css" rel="stylesheet">
  <script src="https://sistemaproec.unespar.edu.br/sistema/includes/summernote-bs4.min.js"></script>

  
    <!--multiselect CSS-->
    <link rel="stylesheet" type="text/css" href="../includes/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="../includes/multi-select.css" /> 
    <link rel="stylesheet" type="text/css" href="../includes/selectize.default.css" />
    <script type="text/javascript">

$(function($) {
    // Quando enviado o formulário
    $("#upload").submit(function() {
        // Passando por cada anexo
        $("#anexos").find("li").each(function() {
            // Recuperando nome do arquivo
            var arquivo = $(this).attr('lang');
            // Criando campo oculto com o nome do arquivo
            $("#upload").prepend('<input type="hidden" name="anexos[]" value="' + arquivo + '" \/>');
        }); 
    });
});
    
// Função para remover um anexo
function removeAnexo(obj) 
{
    // Recuperando nome do arquivo
    var arquivo = $(obj).parent('li').attr('lang');
    // Removendo arquivo do servidor
    $.post("index.php" | "cadastrar.php", {acao: 'removeAnexo', arquivo: arquivo}, function() {
        // Removendo elemento da página
        $(obj).parent('li').remove();
    });
}
    </script>
<style type="text/css">

iframe {
    border: 0;
    overflow: hidden;
    margin: 0;
    height: 60px;
    width: 450px;
}

#anexos {
    list-style-image: url(../imgs/file.png);
}

#anexos_edt {
    list-style-image: url(../imgs/file.png);
}

img.remover {
    cursor: pointer;
    vertical-align: bottom;
}
</style>

<title>SisGP PROEC</title>
  </head>
  <body class="bg-light text-dark">

<!-- 
-->
  <nav class="navbar navbar-light text-center p-2" style="background-image: linear-gradient(0deg, #002661 6%, #007F3D 7%, #007F3D 9%, #FFFFFF 10%, #FFFFFF 80%, #D8D8D8 98%, #000000 99%); ">
    <div style="width: 100%">

         <div class="container text-center p-3" >
            <div class="row">
              <div>
                <img src="../imgs/logo_unespar.png" width="64" height="68" class="d-inline-block align-top" alt="" loading="lazy">
              </div>
              <div class="col">
                  <div class="text-left">
                    Pró-Reitoria de
                  </div>
                  <div class="text-left">
                      <a  href="../" style="color: #002661;"><strong>Extensão e Cultura - PROEC  </strong></a>
                  </div>
                  <div class="text-left">
                    Universidade Estadual do Paraná
                  </div>
                  
              </div>
            </div>

            <div class="col">
                  
                  <div>
                      <span class="badge badge-success">SisGP <?php echo $clock[$horas]; ?> </span>
                  </div>
                  <div>
                    Sistema para Gerir Projetos
                  </div>
                  <div><sup>ver<strong>1.5b</strong></sup></div>

                  
              </div>
            <div class="btn-group">
            <?php
    if (!is_null($obUsuario['nome'])) {
        ?>
      <div class="btn-group btn-group-sm float-right">   
      <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        Propostas
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=4">Novo Programa</a>
          <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=5">Novo Projeto</a>
          <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=3">Nova Prestação de Serviço</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=1">Novo Curso</a>
          <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=2">Novo Evento</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item btn-sm" href="../projetos">Listar minhas propostas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item btn-sm" href="../projetostb">Listar todos os projetos aprovados</a>

          <?php echo $all; ?>
        </div>
      </div>


      <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        Avaliações
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../avalareal">A realizar</a>
          <a class="dropdown-item btn-sm" href="../avalfeitas">Realizadas [Histórico]</a>
        </div>
      </div>

<?php
/*
$sql = "select
  coalesce(ca.id, co.id) id_link,
  CASE
    WHEN ca.id IS NOT NULL THEN 'ca'
    WHEN co.id IS NOT NULL THEN 'co'
    ELSE null
  END AS id_orig,
  CASE
    WHEN ca.id IS NOT NULL THEN ca.nome
    WHEN co.id IS NOT NULL THEN co.nome
    ELSE null
  END AS n_orig
FROM
  usuarios u
  left join colegiados co on co.coord_id  = u.id
  left join campi ca      on ca.chef_div_id  = u.id and co.id is null
WHERE
  ( co.id IS NOT NULL OR ca.id IS NOT NULL ) and
   u.id = '" . $obUsuario['id'] . "'";
$obQAvalioRel = Outros::qry($sql);
*/

if (in_array($obUsuario['config'], [1, 3])) {
    ?>
      <div class="btn-group btn-group-sm">
    <!--    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Manutenção temporária</button>-->
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        Relatórios
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item btn-sm" href="../relatorio_todo">A realizar</a>
          <a class="dropdown-item btn-sm" href="../relatorio_done">Realizadas [Histórico]</a>
        </div>
      </div>

<?php } ?> 

   
      
<!--      <button type="button" class="btn btn-primary">Projetos</button>
    -->     
      <?php echo $menuAcompa; ?>
      <?php // echo $menuPibis;?>
      <?php echo $menuMicro; ?>
      <?php echo $adminOpts; ?>

      <div clastoasts="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
        👤 <?php echo $nome; ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <?php
                $tipoUser = $obUsuario['tipo'] == 'agente' ? 'agente' : 'professor';
        ?>
          
        
          <a class="dropdown-item btn-sm" href="../<?php echo $tipoUser; ?>/editar.php?id=<?php echo $obUsuario['id']; ?>">Perfil</a>
    <!--      <a class="dropdown-item btn-sm" href="../config/">Configuração</a>  --> 
          <div class="dropdown-divider"></div>
<!-- se a pessoa for permitida, ela entrará aqui para colocar as tabelas e ver se há alunos repetidos em bolsas -->
          <!-- As pessoas permitidas estão em CompararAlunos.php -->
          <?php if (isset($obUsuario['id']) && in_array($obUsuario['id'], $idPermitido, true)) { ?>
            <a class="dropdown-item btn-sm" href="../verificar_bolsistas/index.php">Verificar alunos bolsistas</a>
            <div class="dropdown-divider"></div>
          <?php } ?>

          <a class="dropdown-item btn-sm" href="../login/logout.php">Sair</a>
        </div>
      </div>
    </div>
<?php
    }
?>

            </div>
         </div>
    </div>     
  </nav>

    <div class="container">
<?php

  if (!is_null($obUsuario['nome'])) {
      echo "<a href='../hierarquia/index.php?hi=ca' data-toggle='tooltip' title='Hierarquia do campus' style='text-decoration:none;'>",
      "<span class='badge badge-primary' id='bca'>",
      $obUsuario['ca_nome'], '</span></a>';
      if ($obUsuario['tipo'] != 'agente') {
          echo "<a href='../hierarquia/index.php?hi=ce' data-toggle='tooltip' title='Hierarquia do centro de área' style='text-decoration:none;'>",
          "<span class='badge badge-secondary' id='bce'>", $obUsuario['ce_nome'],
          '</span></a>',
          "<a href='../hierarquia/index.php?hi=co' data-toggle='tooltip' title='Hierarquia do colegiado' style='text-decoration:none;'>",
          "<span class='badge badge-success' id='bco'>",   $obUsuario['co_nome'],
          '</span></a>';
      } else {
          echo "<span class='badge badge-success'>Agente</span>";
      }
      echo "<a href='../", $tipoUser,'/editar.php?id=', $obUsuario['id'],"' data-toggle='tooltip' title='Perfil do usuário' style='text-decoration:none;'><span class='badge badge-info'>",      $obUsuario['nome'],'</span></a>';

      $a = $obUsuario['config'];
      $cargo = ['Prof/AG', 'Coordenador',  'Centro de Área', 'Chefe de Divisão', 'Diretor de Campus'];

      if ($obUsuario['config'] > 0) {
          echo "<span class='badge badge-warning float-right'>", $cargo[$a],'</span>';
      }
      if ($obUsuario['adm'] == 1) {
          echo "<span class='badge badge-danger float-right'>Admin</span>";
      }
  }

?>