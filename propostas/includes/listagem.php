<?php

require '../vendor/autoload.php';
use App\Entity\Avaliacoes;
use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();
$userId = $user['id'];

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

foreach ($projetos as $proj) {
    ++$qnt1;
    // $showRelatorios = false;
    // $submetido = false;
    $progresso = '';
    $showRelatorios = false;

    // echo '<pre>';
    //   print_r($proj);
    // echo '</pre>';
    // break;

    // echo ($proj->estado);

    switch ($proj->estado) {
        case 0:  // Não iniciado
            $progresso = '<span class="badge badge-info">Não submetido</span>';
            $btn = naoSubmetido($proj, $user);
            break;
        case 1: // Em avaliação
            $progresso = '<span class="badge badge-warning ">Em avaliação</span> ';
            $btn = emAvaliacao($proj, $user);
            break;
        case 2: // Não iniciado
            $progresso = '<span class="badge badge-secondary ">Não iniciado</span> ';
            $btn = naoIniciado($proj, $userId);
            break;
        case 3: // Em execução   -- ou seja, já aprovado.
            $progresso = '<span class="badge badge-primary ">Em execução</span> ';
            $btn = emExecucao($proj, $userId);
            break;
        case 4: // Finalizada a vigência
            $progresso = '<span class="badge badge-success ">Aguarde Relatório Final</span> ';
            $nomeEstado = 'Aguarde Relatório Final';
            $btn = aguardandoRelatorio($proj, $userId);
            break;
        case 5: // Finalizado e entregue o relatório final/renovação
            $progresso = '<span class="badge badge-success ">Finalizado</span> ';
            $nomeEstado = 'Finalizado';
            $btn = finalizado($proj, $user);
            break;
        case 6:
            $progresso = '<span class="badge badge-danger ">Necessário adequações</span> ';
            $nomeEstado = 'Adequacoes';
            $btn = adequacoes($proj, $user);
            break;
        case 7:
            $progresso = '<span class="badge badge-info ">Necessário ressubmeter</span> ';
            $nomeEstado = 'Necessário Ressubmeter';
            $btn = ressubmit($proj, $user);
            break;
        case 51: // Finalizado e entregue o relatório final/renovação
            $proj->estado = '<span class="badge badge-success ">Finalizado</span> ';
            $nomeEstado = 'Finalizado';
            $btn = finalizado($proj, $user);
            break;
            // case 9: // Cancelado
            //     $progresso = '<span class="badge badge-danger ">Cancelado</span> ';
            //     $btn = cancelado($proj);
            //     break;
        default:
            $progresso = '<span class="badge badge-danger">Erro estado</span>';
            break;
    }

    // is_null($proj->colegiado) ? $col = 'A definir' : $col = $proj->colegiado;

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

    $where = 'id_proj = "'.$proj->id.'"';
    $order = 'ver desc, fase_seq desc';
    $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);

    $qntAvaliacoes = count($ListaVerAnts);
    $btnAvaliacoes = '';
    $LastV = '';

    if ($qntAvaliacoes > 0) {
        $retorno = montarTblEProgress($ListaVerAnts, $proj->id, $progresso);

        $LastV = $retorno[1];
        $btnAvaliacoes = $retorno[2] ?? '';
    } elseif ($proj->aprov_auto == 1) {
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
              <div class="col-sm"><strong>Protocolo:</strong> '.$proj->protocolo.'</div> 
              <div class="col-sm"><strong>Vigência:</strong> '.$dataInicio.' - '.$dataFim.'</div> 
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
    $resultados .= $btn.' '.$btnAvaliacoes;
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
              role="button"
              onchange="trocarPagina(this)"> 
          <option value="meus-projetos" <?php echo $todosProjetos ? '' : 'selected'; ?>>
              Meus projetos
          </option>

          <option value="todos-projetos" <?php echo $todosProjetos ? 'selected' : ''; ?>>
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
            <a class="dropdown-item btn-sm" href="../propostas/cadastrar.php?t=4">Novo Programa</a>
            <a class="dropdown-item btn-sm" href="../propostas/cadastrar.php?t=5">Novo Projeto</a>
            <a class="dropdown-item btn-sm" href="../propostas/cadastrar.php?t=3">Nova Prestação de Serviço</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item btn-sm" href="../propostas/cadastrar.php?t=1">Novo Curso</a>
            <a class="dropdown-item btn-sm" href="../propostas/cadastrar.php?t=2">Novo Evento</a>
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

<!-- Modal para solicitação para DEC -->
<form id="formDEC">
  <div class="modal fade" id="DEC">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" style="max-width: 600px;">
      <div class="modal-content">
        
        <div class="modal-header">
          <h4 class="modal-title">Solicitar alteração</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">

              <div class="col-12">
                <div id="msgObservacao" class="alert alert-info py-2">
                  A alterações selecionadas serão enviadas para a DEC para aprovação.<br> 
                  A aprovação será efetuada de acordo com o regulamento XPTO.<br> 
                  Selecione uma opção abaixo:
                </div>

                <select id="selecDEC" class="form-control form-control-sm"></select>
              </div>

              <div class="col-12">
                <div class="form-group" id="conteudoDEC"></div>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer" id="footerDEC" style="display: none;">
          <div class="d-flex rounded bg-warning text-black">
            <span class="mr-2 ml-2" id="mensagemFooter"></span>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">
            Enviar alterações
          </button>
        </div>

      </div>
    </div>
  </div>
</form>
<!-- Modal para solicitação para DEC -->

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
    // console.table(data);
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
    // idp = id.substr(4,36);

    const data = await fetch(`../api/proj.php?prj=${id}`)
      .then(resp => resp.json()).catch(error => false);
  
    if(!data) return;
  
    if(oper == 'del'){
      printDel(data);
    } else if(oper == 'sub'){
      printSub(data);
    } else if(oper == 'Alt'){
      printSubAlt(data);
    } else if(oper == 'DEC'){
      printSubDEC(data);
    } else {
      return;
    }
  }

  // ---------------------------------------------
  // COISAS NOVAS FEITAS NO SISTEMA
  // ---------------------------------------------

  // GERAR CAMPO DINÂMICO
  function gerarCampo(tipo) {
    let inputHTML = '';
    let labelNovo = tipo === 'data' ? 'Nova data' : 'Novo valor';
    let labelAtual = tipo === 'data' ? 'Data atual' : 'Valor atual';
    let labelSolicitacao = 'Mensagem de solicitação';

    switch (tipo) {
      case 'texto':
        inputHTML = `
          <textarea 
            name="CampoDEC" 
            class="form-control form-control-sm auto-resize" 
            rows="1"
            style="resize: none; overflow: hidden;" 
            required
          ></textarea>`;
        break;

      case 'data':
        inputHTML = `<input type="date" name="CampoDEC" class="form-control form-control-sm" required>`;
        break;

      case 'selectYN':
        inputHTML = `
          <select name="CampoDEC" class="form-control form-control-sm" required>
            <option value="">Selecione...</option>
            <option value="S">Sim</option>
            <option value="N">Não</option>
          </select>`;
        break;
    }

    return `
      <div class="row mt-3 align-items-stretch">

        <!-- ESQUERDA -->
        <div class="col-md-6 d-flex">
          <div class="form-group p-3 border rounded bg-light w-100 h-100 d-flex flex-column justify-content-center">

            <!-- NOVO CAMPO DE SOLICITAÇÃO -->
            <label class="font-weight-bold mb-2">${labelSolicitacao}</label>
            <textarea 
              name="mensagemSolicitacao"
              class="form-control form-control-sm"
              maxlength="250"
              rows="3"
              placeholder="Digite sua solicitação (máx. 250 caracteres)"
              required
            ></textarea>
            
            <label class="font-weight-bold mt-3 mb-2">${labelNovo}</label>
            ${inputHTML}

            <label class="font-weight-bold mt-4 mb-2">${labelAtual}</label>
            <div class="valor-original"></div>

          </div>
        </div>

        <!-- DIREITA -->
        <div class="col-md-6 d-flex">
          <div class="w-100 h-100 d-flex flex-column p-3 rounded bg-danger text-white">
            
          <div class="text-center flex-grow-1 d-flex flex-column align-items-center justify-content-center">
            <label class="font-weight-bold">
              Atenção!
            </label>
            <div class="mensagem"></div>
          </div>

          </div>
        </div>

      </div>
    `;
  }

  // FORMATAR VALORES
  function formatarValor(campo, valor) {
    if (!valor) return '';
      
    if (campo === 'tide') {
      return valor === 'S' ? 'Sim' : valor === 'N' ? 'Não' : valor;
    }

    if ((campo === 'vigen_ini' || campo === 'vigen_fim') && valor) {
      const data = valor.split(' ')[0];
      const [ano, mes, dia] = data.split('-') || [];

      if (ano && mes && dia) {
        return `${dia}/${mes}/${ano}`;
      }
    }

    return valor;
  }

  // AUTO RESIZE
  function ativarAutoResize() {
    document.querySelectorAll('.auto-resize').forEach(textarea => {
      const resize = () => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
      };

      textarea.addEventListener('input', resize);
      resize();
    });
  }

  // VALIDAÇÃO PARA EXIBIR O BOTÃO DE ENVIAR
  function validarAlteracao() {
    const campo = document.querySelector('[name="CampoDEC"]');
    const footer = document.getElementById('footerDEC');
    const mensagemBox = document.getElementById('mensagemFooter');
    const botao = footer.querySelector('button');

    if (!campo) return;

    let valorNovo = campo.value?.trim();
    let valorAtual = document.querySelector('.valor-original').textContent.trim();

    // Não mostra nada
    if (!valorNovo) {
      footer.style.display = 'none';
      mensagemBox.textContent = '';
      return;
    }

    const campoSelec = campo.dataset.campo;
    valorNovo = formatarValor(campoSelec, valorNovo)?.trim();
    valorAtual = valorAtual?.trim();

    footer.style.display = 'flex';

    // Mostra mensagem e esconde botão
    if (valorNovo === valorAtual) {
      mensagemBox.textContent = 'Este valor é igual ao anterior!';
      botao.style.display = 'none';
    } 
    // Mostra botão e limpa mensagem
    else {
      mensagemBox.textContent = '';
      botao.style.display = 'inline-block';
    }
  }


  // EVENTO DO SELECT
  document.getElementById('selecDEC').addEventListener("change", function () {

    const campoContainer = document.getElementById('conteudoDEC');
    const msgObs = document.getElementById('msgObservacao');

    if (!this.value) {
      msgObs.style.display = 'block';
      campoContainer.innerHTML = '';
      return;
    }

    msgObs.style.display = 'none';

    const selected = this.options[this.selectedIndex];
    const valorBruto = selected.getAttribute('data-valor') || '';
    const mensagem = selected.getAttribute('mensagem') || '';

    let campoSelec = selected.value;

    const valorFormatado = formatarValor(this.value, valorBruto);

    let tipo = '';

    if (this.value === 'titulo') tipo = 'texto';
    else if (this.value === 'tide') tipo = 'selectYN';
    else if (['vigen_ini', 'vigen_fim'].includes(this.value)) tipo = 'data';

    if (!tipo) {
      campoContainer.innerHTML = '';
      return;
    }

    campoContainer.innerHTML = gerarCampo(tipo);

    const footer = document.getElementById('footerDEC');
    const mensagemBox = document.getElementById('mensagemFooter');
    const botao = footer.querySelector('button');

    footer.style.display = 'none';
    mensagemBox.textContent = '';
    botao.style.display = 'inline-block';

    const campo = campoContainer.querySelector('[name="CampoDEC"]');

    if (campo) {
      campo.dataset.campo = campoSelec;

      if (campo.tagName === 'SELECT' || campo.type === 'date') {
        campo.addEventListener('change', validarAlteracao);
      } else {
        campo.addEventListener('input', validarAlteracao);
      }
    }

    campoContainer.querySelector('.valor-original').textContent = valorFormatado;
    campoContainer.querySelector('.mensagem').textContent = mensagem;

    if (tipo === 'texto') ativarAutoResize();

  });

  // PREENCHER SELECT
  function preencheOptionSol(data) {
    const select = document.getElementById('selecDEC');

    select.innerHTML = '';

    const optionDefault = new Option("Selecione...", "", true, true);
    optionDefault.disabled = true;
    select.appendChild(optionDefault);

    data.forEach(item => {
      const option = new Option(item.nomeExibicao, item.campoAlterado);
      option.setAttribute('data-valor', item.valor_campo);
      option.setAttribute('mensagem', item.mensagemAltera);
      select.appendChild(option);
    });

    document.getElementById('conteudoDEC').innerHTML = '';
  }

  // ABRIR MODAL + FETCH 
  idProjeto = null;
  async function printSubDEC(id) {
    idProjeto = id.id;
    const idp = id.id;
    const resp = await fetch(`../api/solicitaAlteracao.php?idproj=${idp}`);   
    const data = await resp.json();

    console.table(data);

    document.getElementById('msgObservacao').style.display = 'block';
    preencheOptionSol(data);

    document.getElementById('footerDEC').style.display = 'none';

    $('#DEC').modal('show');
  }

  // PEGAR OS VALORES DO FORMULÁRIO
  document.getElementById('formDEC').addEventListener('submit', function (e) {
    e.preventDefault();

    const campo = document.querySelector('[name="CampoDEC"]');
    const mensagemSolicita = document.querySelector('[name="mensagemSolicitacao"]').value;

    if (!campo) {
      alert('Nenhum campo foi gerado.');
      return;
    }

    const valor = campo.value;
    const tipoCampo = document.getElementById('selecDEC').value;
    const valorOriginal = document.querySelector('.valor-original').textContent;

    // console.log('valor: '+valor);
    // console.log('tipoCampo: '+tipoCampo);
    // console.log('valorOriginal: '+valorOriginal);
    // console.log('idProjeto: '+idProjeto);
    // console.log('mensagemSolicita: '+mensagemSolicita);

    fetch(`../api/enviaAlteracao.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        campo: tipoCampo,
        valorNovo: valor,
        valorAtual: valorOriginal,
        idProj: idProjeto,
        msgSolicita: mensagemSolicita,
      })
    })
    .then(res => res.json())
    .then(data => {
      // console.log('Resposta:', data);
      if (data.status === 'ok') {
        $('#DEC').modal('hide');
        console.log("Solicitação de alteração enviada com sucesso")
      } else {
        console.log("Erro ao solicitar alteração, tente novamente")
      }
    })
    .catch(() => {
      console.log('Erro na comunicação com o servidor.');
    });

  });

  // --------------------------------------------- 
  // FINAL DAS COISAS NOVAS
  // ---------------------------------------------

  function writeNumber(elementId) {
    var outputValueTo =   elementId.id;
    console.log('WriteNumber: ' . outputValueTo);
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
