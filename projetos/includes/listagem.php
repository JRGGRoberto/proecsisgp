<?php

require '../vendor/autoload.php';
use App\Entity\Avaliacoes;
use App\Entity\Colegiado;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();

require '../includes/msgAlert.php';


class Blocos
{
  public $pos;
  public $cor;

  public function __construct($pos, $cor)
  {
      $this->pos = $pos;
      $this->cor = $cor;
  }
}

$qnt1 = 0;
$col = '';
$LastV = '';
// echo '<pre>';
// print_r($user);
// echo '</pre>';

include './includes/funcoes.php';

$resultados =
'<div id="accordion">';

function createBT($tipo, $id, $ver, $form = null, $tipo_exten = null, $titulo = null): string
{
    switch ($tipo) {
        case 'submeter':
            return '<button id="sub'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter</button>';
        case 'submeterNovamente':
            return '<button id="Alt'.$id.'v'.$ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter novamente</button>';
        case 'editar':
            return '<a href="editar.php?id='.$id.'&v='.$ver.'"><button class="btn btn-success btn-sm mb-2">📄 Editar</button></a>';
        case 'excluir':
            return '<button id="del'.$id.'v'.$ver.'" class="btn btn-danger  btn-sm mb-2" onclick="writeNumber(this)">🗑 Excluir</button>';
        case 'visualizar':
            return '<a href="visualizar.php?id='.$id.'&v='.$ver.'&w=1" target="_blank"><button class="btn btn-success btn-sm mb-2"> 📄 Projeto</button></a>';
            // <a href="cancelar.php?id='.$id.'&v='.$ver.'&w=1" target="_blank"></a>
       case 'cancelar':
            return '
              <button class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalCancel'.$id.'">
                  Cancelar
              </button>
              
              <div class="modal fade" id="modalCancel'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel'.$id.'" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel'.$id.'">Confirmar Cancelamento</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Tem certeza que deseja cancelar o projeto "<strong>'.$titulo.'</strong>"?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                      <a href="cancelar.php?id='.$id.'&v='.$ver.'">
                        <button class="btn btn-danger btn-sm">Confirmar Cancelamento</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            ';
        case 'adequacoes':
            return '<a href="../forms/'.$form.'/vista.php?p='.$id.'&v='.($ver - 1).'"><button class="btn btn-danger btn-sm mb-2" >📑 Informações de adequações</button></a>';
        case 'relatorioParcial':
            if ($tipo_exten != 2) { 
              return  '
                <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório Parcial</button></a> &nbsp; 
              ';
            } else { 
              return '
                <a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2" data-toggle="tooltip" data-placement="bottom" title="Não é possível criar relatório parcial para Eventos." disabled>📊 Relatório Parcial</button></a> &nbsp; 
              ';
            }
        case 'relatorioFinal':
            return  '<a href="../relatorio/index.php?id='.$id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório Final</button></a> &nbsp; ';
        default:
            return '';
    }
}

function naoSubmetido($p): string
{
    $i = $p->id;
    $v = $p->ver;
    return 
      createBT('submeter', $i, $v).'  	&nbsp; '.
      createBT('editar', $i, $v).'  	&nbsp; '.
      createBT('visualizar', $i, $v).' &nbsp; '.
      createBT('excluir', $i, $v)
    ;

}

function emAvaliacao($p): string
{
  $i = $p->id;
  $v = $p->ver;
  $t = $p->titulo;
  if ($p->resultado == 'r') {
    return 
        createBT(  'visualizar', $i, $v).'  	&nbsp; '.
        createBT('editar', $i, $v).'  	&nbsp; '.
        createBT('adequacoes', $i, $v, $p->form).'  	&nbsp; '.
        createBT('cancelar', $i, $v, null, null, $t);
  } elseif ($p->resultado == 'n') {
      if ($p->edt == 0) {
        return 
          createBT('visualizar', $i, $v). 
          createBT('cancelar', $i, $v).'  	&nbsp; ';
      } else {
        return 
          createBT('visualizar', $i, $v).'  	&nbsp; '.
          createBT('editar', $i, $v).'  	&nbsp; '.
          createBT('adequacoes', $i, $v, $p->form).'  	&nbsp; '.
          createBT('submeterNovamente', $i, $v).'  	&nbsp; '.
          createBT('cancelar', $i, $v);
      }
  } else {
        return '';
  }
}

function naoIniciado($p): string
{
    $i = $p->id;
    $v = $p->ver;
    $t = $p->titulo;

    return 
      createBT('visualizar', $i, $v).' &nbsp; '. 
      createBT('cancelar', $i, $v, null, null, $t);
}

function emExecucao($p): string
{
    $i = $p->id;
    $v = $p->ver;
    $tipo = $p->tipo_exten;


    return (
      createBT('visualizar', $i, $v) . ' &nbsp;'. 
      createBT('relatorioParcial', $i, $v, null, $tipo)   
      // createBT('cancelar', $i, $v).' &nbsp; '
        );
    // if ($tipo != 2)
    //     return (
    //       createBT('cancelar', $i, $v).' &nbsp; '.
    //       createBT('visualizar', $i, $v) . ' &nbsp;'. 
    //       createBT('relatorioParcial', $i, $v)
    //     );
    // else { 
    //   return (
    //       createBT('cancelar', $i, $v).' &nbsp; '.
    //       createBT('visualizar', $i, $v)
    //   );
    // }
}

function finalizado($p): string
{
    $i = $p->id;
    $v = $p->ver;
    return 
      createBT('visualizar', $i, $v).' &nbsp; '.
      createBT('relatorioFinal', $i, $v);
          
}

function cancelado($p): string
{
    $i = $p->id;
    $v = $p->ver;
    return createBT('visualizar', $i, $v);
}

foreach ($projetos as $proj) {
    ++$qnt1;
    // $showRelatorios = false;
    // $submetido = false;
    $progresso = '';
    $showRelatorios = false;
    // echo ($proj->estado);

    switch ($proj->estado) {
      case 0:  // Não iniciado
          $progresso = '<span class="badge badge-info">Não submetido</span>';
          $btn = naoSubmetido($proj);
          break;
      case 1: // Em avaliação
          $progresso = '<span class="badge badge-warning ">Em avaliação</span> ';
          $btn = emAvaliacao($proj);
          break;
      case 2: // Não iniciado
          $progresso = '<span class="badge badge-secondary ">Não iniciado</span> ';
          $btn = naoIniciado($proj);
          break;
      case 3: // Em execução   -- ou seja, já aprovado.
          $btn = emExecucao($proj);
          $progresso = '<span class="badge badge-primary ">Em execução</span> ';
          break;
      case 4: // Finalizado
          $progresso = '<span class="badge badge-success ">Finalizado</span> ';
          $btn = finalizado($proj);
          break;
      case 9: // Cancelado
          $progresso = '<span class="badge badge-danger ">Cancelado</span> ';
          $btn = cancelado($proj);
          break;
      default:
          $progresso = '<span class="badge badge-danger">Erro estado</span>';
          break;
    }

    // is_null($proj->colegiado) ? $col = 'A definir' : $col = $proj->colegiado;

    $where = 'id_proj = "'.$proj->id.'"';
    $order = 'ver desc, fase_seq desc';
    $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);

    $qntAvaliacoes = count($ListaVerAnts);
    $btnAvaliacoes = '';
    $LastV = '';
    
    if ($qntAvaliacoes > 0) {
        $retorno = montarTblEProgress($ListaVerAnts, $proj->id, $progresso);

        $LastV          = $retorno[1];
        $btnAvaliacoes  = $retorno[2] ?? '';
    } else if ($proj->aprov_auto == 1){
        // $progresso = $msg1;
        $LastV = '<span class="badge badge-info mb-2">Projeto aprovado via e-Protocolo.</span>';
    } else { 
        $LastV = '<span class="badge badge-info mb-2">Não possui avaliações.</span>';
    }
   
    $resultados .= '
      <div class="card mt-2">
        <div class="card-header">
            <div class="row">
              <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$proj->id.'">📃 '.$proj->titulo.'</a></div>';
              switch ($proj->tipo_exten){
                case 1: 
                  $proj->tipo_exten = 'Curso';
                  break;
                case 2:
                  $proj->tipo_exten = 'Evento';
                  break;
                case 3: 
                  $proj->tipo_exten = 'Prestação de Serviço';
                  break;
                case 4: 
                  $proj->tipo_exten = 'Programa';
                  break;
                case 5: 
                  $proj->tipo_exten = 'Projeto';
                  break;
                default:
                  $proj->tipo_exten = 'Sem tipo definido.';
                  break;
              }
              $resultados .= '<div class="col-sm-4">'.$proj->tipo_exten.'</div>
              <div class="col-sm-1">'
              .$progresso.'
              </div>
              <div class="col-sm-1"></div>
            </div>
            <div class="row">
              <div class="col-sm"><strong>Submetido para:</strong> '.$proj->submetido_para.'</div> 
            </div>
        </div>

        <div id="p'.$proj->id.'" class="collapse" data-parent="#accordion">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <p><strong>Resumo:</strong> '.resumirTexto($proj->resumo).'</p>
            
              </div>
              <div class="row mt-2">
                <div class="col-12  mx-3">
                  '.$LastV.'
                </div>
              </div>
            </div>
            
            <div class=""> 
            ';
              $resultados .= $btn . ' ' . $btnAvaliacoes;
              $resultados .= '        
            </div>
          </div>
        </div> 
      </div>
  ';
}
$resultados .=
'</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';
  // echo '<pre>';
  // print_r($projetos);
  // echo '</pre>';


$page = basename($_SERVER['PHP_SELF']);
$todosProjetos = ($page === 'projetos_all.php');

include '../includes/paginacao.php';
?>

<main>
  <h2 class="mt-0">Meus projetos</h2>
  
  <?php echo $msgAlert; ?> 
  <section>
      
    <form method="get">
      <label for="listar-projetos">Listar:</label>
      <select id="listar-projetos"
              class="custom-select custom-select-sm w-auto"
              onchange="trocarPagina(this)"> 
          <option value="meus-projetos" <?= $todosProjetos ? '' : 'selected' ?>>
              Meus projetos
          </option>

          <option value="todos-projetos" <?= $todosProjetos ? 'selected' : '' ?>>
              Todos os projetos
          </option>

      </select>
          
      <div class="row my-2">
        
        <div class="col-5">
          <label>Titulo</label> 
          <input type="text" name="titulo" class="form-control form-control-sm" value="<?php echo $titulo; ?>"  id="titulo"   onchange="showLimpar();">
        </div>

        <div class="col-2">
          <label>Protocolo</label> 
          <input type="text" name="protocolo" class="form-control form-control-sm" value="<?php echo $protocolo; ?>"  id="protocolo"   onchange="showLimpar();">
        </div>
        
        <div class="col">
          <label>Palavra chave</label> 
          <input type="text" name="palavra" class="form-control form-control-sm" value="<?php echo $palavra; ?>"  id="palavra"   onchange="showLimpar();">
        </div>

        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
          <a href="./" id="limpar"><span class="badge badge-primary">x</span></a>
        </div>

      </div>

    </form>


    
  </section>

  <section>
    <?php echo $resultados; ?>
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col">
         <?php echo $paginacao; ?>
      </div>
      <div class="col" >
        <!-- <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a> -->
        <div class="dropup">
          <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
            Novo
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=4">Novo Programa</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=5">Novo Projeto</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=3">Nova Prestação de Serviço</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=1">Novo Curso</a>
            <a class="dropdown-item btn-sm" href="../projetos/cadastrar.php?t=2">Novo Evento</a>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>






<!-- The Modal -->
  <div class="modal fade" id="modalSub">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Título</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="modalBody">
          

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer" id="modalFooter">
          
        </div>
        
      </div>
    </div>
  </div>
  <!-- The Modal -->

  <?php
   echo '<script>';
echo 'const optspara = `';
echo $coolSelectSend;
echo '`;';
echo '</script>';

?>



<script>

  const modalTitle  = document.getElementById('modalTitle');
  const modalBody   = document.getElementById('modalBody');
  const modalFooter = document.getElementById('modalFooter');

  const btnLimpar = document.getElementById('limpar');

  btnLimpar.hidden = true;

  function trocarPagina(sel) {
    if (sel.value === 'meus-projetos') {
      location.href = "../proj_master";
    } else {
      location.href = "projetos_all.php";
    }
  }

  function showLimpar(){
    var titulo    = document.getElementById('titulo').value;
    var palavra   = document.getElementById('palavra').value;

    if((titulo.length > 0 ) || (palavra.length > 0 ) ) {
      btnLimpar.hidden = false;
    } 
  }

  showLimpar();
  
  function ativaBTN() {
    var btn = document.getElementById('btnSubmit');
    var opt = document.getElementById('selPara');
    var b = document.getElementById('selecOpt');
    b.value = opt.value;

    if((opt.value != -1 ) ){
      btn.disabled=false;
    } else {
      btn.disabled=true;
  
    }
  }


  function printDel(data){
    modalTitle.innerText = 'Confirmação de exclusão';
    modalBody.innerHTML =  `<h4>Tem certeza que deseja apagar o registro abaixo?</h4><p class="justify-content-center"> ${data.titulo}</p><span class="badge badge-warning float-right" ><span class="badge badge-light">⚠️</span>Atenção! O processo não pode ser revertido</span>`;
    modalFooter.innerHTML = `
            <a href="excluir.php?id=${data.id}&v=${data.created_at}" 
              class="btn btn-danger    btn-sm mb-2">🗑  Excluir</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }



  function printSubAlt(data){
    console.table(data);
    let nomeLocal = '';
    modalTitle.innerText = 'Reenvio do projeto à PROEC';
    if(data.colegiado === null){
      nomeLocal = 'Campus';
    } else {
      nomeLocal = data.colegiado;
    }
    modalBody.innerHTML = `
      <div class="modal-body" id="modalBody">
        <h4>${data.titulo}</h4>
        <p>Ao confirmar que realizou as solicitações de alterações, clique para submeter a nova versão.</p>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="para_avaliar">Enviar para </label>
                <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                  <option value="${data.para_avaliar}" selected>${nomeLocal}</option>
                </select>
              </div>
            </div>
          </div>
      </div>
    `;
    modalFooter.innerHTML = data.innerHTML = `
      <form method="post" action="submeter.php?">
        <input type="hidden" name="modIDprj"   value="${data.id}">
        <input type="hidden" name="selecOpt"   value="${data.para_avaliar}" id="selecOpt">
        <input type="hidden" name="modVerPrj"  value="${data.ver}">
        <input type="hidden" name="modCreated" value="${data.created_at}">
        <button type="submit" class="btn btn-primary btn-sm mb-2" id="btnSubmitN">📤 Submeter nova versão</button>
      </form>                    
      <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }



  function printSub(data){
    modalTitle.innerText = 'Submissão de projeto';
    modalBody.innerHTML = `
      <div class="modal-body" id="modalBody">
        <h4>${data.titulo}</h4>
        <p>Ao submeter o projeto à PROEC, estás a aceitar que este será avaliado pelas instâncias competentes.</p>
        <p>Não será mais possível editá-lo a não ser que haja uma solicitação para isso.</p>
        <p>Concordando com o informado, selecione o colegiado o qual julga ser relacionado a ele e clique em Submeter.</p>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="para_avaliar">Enviar para </label>
                <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                  <option value="-1">Selecione</option>
                  ${optspara}
                </select>
              </div>
            </div>
          </div>
      </div>
    `;
    modalFooter.innerHTML = data.innerHTML = `
            <form method="post" action="submeter.php?">
                <input type="hidden" name="modIDprj"   value="${data.id}">
                <input type="hidden" name="selecOpt"   value="" id="selecOpt">
                <input type="hidden" name="modVerPrj"  value="${data.ver}">
                <input type="hidden" name="modCreated" value="${data.created_at}">
                <button type="submit" class="btn btn-primary btn-sm mb-2" id="btnSubmit" disabled>📤 Submeter</button>
            </form>                    
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
    `;
    $('#modalSub').modal('show');
  }

  const getProjDados = async(id) => {
    const oper = id.substr(0,3);
    const data = await fetch(`../api/proj.php?prj=${id}`)
      .then(resp => resp.json()).catch(error => false);
  
    if(!data) return;
    
    printDel(data);
  
    if(oper == 'del'){
      printDel(data);
    } else if(oper == 'sub'){
      printSub(data);
    } else if(oper == 'Alt'){
      printSubAlt(data);
    } else {
      return;
    }
  }
  
  function writeNumber(elementId) {
    var outputValueTo =   elementId.id;
    getProjDados(outputValueTo);
    

  
  }

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  

  btnOpen.onclick = function(){
    modal.showModa();
  }
</script>
