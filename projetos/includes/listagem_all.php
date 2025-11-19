<?php

require '../includes/msgAlert.php';
include './includes/funcoes.php';

use App\Entity\Avaliacoes;
use App\Entity\Outros;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();
$userConfig = $user['config'];
$userTipo = $user['tipo'];

$osCabeca = [1, 2, 3, 4]; // só a elite

// if (in_array($userConfig, $osCabeca)) {
//   print_r($osCabeca);
// }

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

$currentUrl = $_SERVER['REQUEST_URI'];
// echo '<pre>';
// print_r($user);
// echo '</pre>';

$qnt1 = 0;

// function resumirTexto(string $texto, int $limite = 256): string
// {
//     $textoLimpo = trim(strip_tags($texto));
//     if (mb_strlen($textoLimpo) <= $limite) {
//         return $textoLimpo;
//     }

//     return substr($textoLimpo, 0, $limite).' <span class="badge badge-pill badge-success">(continua...)</span>';
// }

$resultados = '<div id="accordion">';
foreach ($projetos as $proj) {
    switch ($proj->estado) {
        case 1:
            $proj->estado = 'Em avaliação';
            break;
        case 2:
            $proj->estado = 'Não iniciado';
            break;
        case 3:
            $proj->estado = 'Em execução';
            break;
        case 4:
            $proj->estado = 'Finalizado';
            break;
    }

    switch ($proj->tipo_exten) {
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
    }
    ++$qnt1;

    is_null($proj->submetido_para) ? $col = 'A definir' : $col = $proj->submetido_para;

    $dataFim = '';
    if (strlen($proj->vigen_fim) > 8) {
        $dataFim = substr($proj->vigen_fim, 8, 2).'/'.
                  substr($proj->vigen_fim, 5, 2).'/'.
                  substr($proj->vigen_fim, 0, 4);
    }

    $dataInicio = '';
    if (strlen($proj->vigen_ini) > 8) {
        $dataInicio = substr($proj->vigen_ini, 8, 2).'/'.
                  substr($proj->vigen_ini, 5, 2).'/'.
                  substr($proj->vigen_ini, 0, 4);
    }

    $query = "select * from relatorios r where r.publicado = 1 and r.idproj = '".$proj->id."'";
    $relatorios = Outros::qry($query);

    // 2023-03-09 00:00:00
    $resultados .= '
  <div class="card mt-3">
    <div class="card-header">

      <div class="row mb-1">
        <div class="col">
          📃 <strong>Título:</strong>
          <a class="collapsed card-link" data-toggle="collapse" href="#p'.$proj->id.'">
            <strong>'.$proj->titulo.'</strong>
          </a>
        </div>
      </div>

      <div class="row mb-1">
        <div class="col-md-4"><strong>Coordenador:</strong> '.$proj->coord.'</div>
        <div class="col-md-4"><strong>Colegiado:</strong> '.$col.'</div>
        <div class="col-md-4"><strong>Campus:</strong> '.$proj->campus.'</div>
      </div>

      <div class="row mb-1">
        <div class="col-md-4"><strong>Situação:</strong> '.$proj->estado.'</div>
        <div class="col-md-4"><strong>Início:</strong> '.$dataInicio.'</div>
        <div class="col-md-4"><strong>Fim:</strong> '.$dataFim.'</div>
      </div>

      <div class="row">
        <div class="col"><strong>Tipo de Proposta:</strong> '.$proj->tipo_exten.'</div>
      </div>

    </div>

    <div id="p'.$proj->id.'" class="collapse" data-parent="#accordion">
      <div class="card-body">

        <div class="row">
          <div class="col-12"><p><strong>Resumo:</strong> '.resumirTexto($proj->resumo).'</p></div>
        </div>
    ';

    // print_r($proj->estado);
    if ($proj->estado == 'Em avaliação' && in_array($userConfig, $osCabeca) || $user['id'] == $proj->id_prof) {
        $resultados .= '
      <div class="d-flex">
        <a href="visualizar.php?id='.$proj->id.'&v='.$proj->ver.'&w=1" target="_blank">
          <button class="btn btn-success btn-sm mb-2">Projeto 📃</button>
        </a>
      </div>
    
    ';
    } elseif (in_array($proj->estado, ['Finalizado', 'Em execução', 'Não iniciado'])) {
        $resultados .= '
        <div class="d-flex">
          <a href="visualizar.php?id='.$proj->id.'&v='.$proj->ver.'&w=1" target="_blank">
            <button class="btn btn-success btn-sm mb-2">Projeto 📃</button>
          </a> &nbsp;
          ';
        if (($proj->estado == 'Em execução' || $proj->estado == 'Finalizado' || $proj->estado == 'Não iniciado')
            && in_array($userConfig, $osCabeca)
        ) {
            $resultados .= '
              <a href="../prnRelatorios/index.php?id='.$proj->id.'" target="_blank" 
                class="btn btn-primary btn-sm mb-2" data-toggle="tooltip" data-placement="bottom" title="Visualizar todas as avaliações realizadas.">
                🖨️ Avaliações
              </a>
            ';
        }
        $resultados .= '</div>';
    }

    // Avaliacoes
    $where = 'id_proj = "'.$proj->id.'"';
    $order = 'ver desc, fase_seq desc';

    $avaliacoesAnteriores = Avaliacoes::getRegistros($where, $order, null);
    $qntAvaliacoes = count($avaliacoesAnteriores);

    $progresso = '';
    $btnAvaliacoes = '';

    $LastV = '';
    if ($proj->estado == 'Em avaliação' && in_array($userConfig, $osCabeca)) {
        $resultados .= !empty($avaliacoesAnteriores)
        ? '<hr><span><strong> Avaliações 📊</strong></span>'
        : '';

        if ($qntAvaliacoes > 0) {
            $retorno = montarTblEProgress($avaliacoesAnteriores, $proj->id, $progresso);
            $LastV = $retorno[1];
            // print_r($retorno[2]);
            $btnAvaliacoes = $retorno[2] ?? '';
        }

        $resultados .= '
        <div class="row mt-2">
          <div class="col-12">
            '.$LastV.'
          </div>
        </div>

        <div> 
          ';
        $resultados .= $btnAvaliacoes;
        $resultados .= '        
        </div>
      ';
    }

    $resultados .= !empty($relatorios)
    ? '<hr><span><strong> Relatórios 📊</strong></span>'
    : '<br><p class="badge badge-secondary p-2"> Nenhum relatório publicado.</p>';

    foreach ($relatorios as $rel) {
        $resultados .= '
        <div class="d-flex flex-row">
          <div class="">
            <a href="../relatorio/editar'.$rel->tipo[0].'.php?id='.$rel->id.'">
              <button class="btn-success border border-0 my-2 rounded btn-sm">';
        $resultados .=
        $rel->tipo == 'fi' ? 'FINAL - '.$rel->created_at : 'PARCIAL - '.$rel->created_at;
        $resultados .= '
              </button>
            </a>
          </div>
        </div>
      ';
    }

    $resultados .= '
          </div> 
        </div>  
      </div>    
    ';
}

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

$listar = $_GET['listar-projetos'] ?? 'meus-projetos';

if ($listar === 'todos-projetos') {
    // busca todos os projetos
} else {
    // busca apenas os do usuário
}

$page = basename($_SERVER['PHP_SELF']);
$todosProjetos = ($page === 'projetos_all.php');

include '../includes/paginacao.php';
?>

<main>
  <h2 class="mt-0">Projetos</h2>
  
  <?php echo $msgAlert; ?> 
  <section>

    <form method="get">
      <div class="row-my-2">
          <div class="">
            <label for="listar-projetos">Listar:</label>
            <select id="listar-projetos"
                    class="custom-select custom-select-sm w-auto"
                    onchange="trocarPagina(this)">
              <option value="meus-projetos" <?php echo $todosProjetos ? '' : 'selected'; ?>>
                Meus projetos
              </option>

              <option value="todos-projetos" <?php echo $todosProjetos ? 'selected' : ''; ?>>
                Todos os projetos
              </option>
            </select>
          </div>
        </div>

        <div class="row my-2">

          <div class="col-4">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control form-control-sm"
                  value="<?php echo $titulo; ?>" id="titulo" onchange="showLimpar();">
          </div>

          <div class="col-4">
            <label>Coordenador</label>
            <input type="text" name="nome_prof" class="form-control form-control-sm"
                  value="<?php echo $nome_prof; ?>" id="nome_prof" onchange="showLimpar();">
          </div>

          <div class="col-4">
            <label>Campus</label>
            <input type="text" name="campus" class="form-control form-control-sm"
                  value="<?php echo $campus; ?>" id="campus" onchange="showLimpar();">
          </div>

          <div class="col-3">
            <label>Palavra-chave</label>
            <input type="text" name="palavra" class="form-control form-control-sm"
                  value="<?php echo $palavra; ?>" id="palavra" onchange="showLimpar();">
          </div>

          <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" onchange="showLimpar();"
                    name="emAvaliacao" id="emAvaliacao" value="7"
                    <?php echo isset($_GET['emAvaliacao']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="emAvaliacao">
                Em avaliação
              </label>
            </div>
          </div>

          <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" onchange="if(this.checked) showLimpar();"
                    name="execucao" id="execucao" value="7"
                    <?php echo isset($_GET['execucao']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="execucao">
                Em execução
              </label>
            </div>
          </div>

          <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" onchange="if(this.checked) showLimpar();"
                    name="finalizados" id="finalizados" value="30"
                    <?php echo isset($_GET['finalizados']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="finalizados">
                Finalizados
              </label>
            </div>
          </div>

          <div class="col-2 d-flex justify-content-center align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" onchange="if(this.checked) showLimpar();"
                    name="naoIniciados" id="naoIniciados" value="30"
                    <?php echo isset($_GET['naoIniciados']) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="naoIniciados">
                Não iniciados
              </label>
            </div>
          </div>

          <div class="col-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-sm mr-2">Filtrar</button>
            <a href="<?php echo $currentUrl; ?>" id="limpar">
              <span class="badge badge-primary">X</span>
            </a>
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
      location.href = "./";
    } else {
      location.href = "./projetos_all.php";
    }
  }
  
  function showLimpar(){
    var titulo    = document.getElementById('titulo').value;
    var prof = document.getElementById('prof').value;
    var palavra   = document.getElementById('palavra').value;
    var campus = document.getElementById('campus').value;

    var emAvaliacao = document.getElementById('emAvaliacao').checked;
    var execucao    = document.getElementById('execucao').checked;
    var finalizados = document.getElementById('finalizados').checked;
    var naoIniciados = document.getElementById('naoIniciados').checked;

    if (
      titulo.length > 0 ||
      campus.length > 0 ||
      palavra.length > 0 ||
      nome_prof.length > 0 ||
      emAvaliacao ||
      execucao ||
      finalizados ||
      naoIniciados
    ) {
      btnLimpar.hidden = false;
    } else {
      btnLimpar.hidden = true;
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
    modalTitle.innerText = 'Reenvio do projeto à PROEC';
    modalBody.innerHTML = `
          <div class="modal-body" id="modalBody">
            <h4>${data.titulo}</h4>
            <p>Ao confirmar que realizou as solicitações de alterações, clique para submeter a nova versão.</p>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="para_avaliar">Colegiado de </label>
                    <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                      <option value="${data.para_avaliar}" selected>${data.colegiado}</option>
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
                    <label for="para_avaliar">Enviar para o colegiado de </label>
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

  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  

  btnOpen.onclick = function(){
    modal.showModa();
  }


</script>
