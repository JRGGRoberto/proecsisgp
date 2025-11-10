<?php

require '../vendor/autoload.php';
use App\Entity\Avaliacoes;
use App\Entity\Colegiado;

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

include './includes/funcoes.php';

$resultados =
'<div id="accordion">';

foreach ($projetos as $proj) {
    ++$qnt1;
    $apvov = false;
    $showRelatorios = false;
    $submetido = false;

    $msg1 = '';
    // regras == 'e341e624-0715-11ef-b2c8-0266ad9885af' 2024Exec - importado, já aprovado anteriormente

    if (($proj->regras == 'e341e624-0715-11ef-b2c8-0266ad9885af')
        or ($proj->aprov == 1)
        or ($proj->etapas = $proj->fase_seq and $proj->last_result = 'a')
    ) {
        $submetido = true;
        $showRelatorios = true;
        switch ($proj->estado) {
            case 'nini':  // Não iniciado
                $msg1 = 'Não iniciado';
                break;
            case 'exec': // Em execução
                $msg1 = 'Em execução';
                break;
            case 'fina': // Finalizado
                $msg1 = 'Finalizado';
                break;
            default:
                $msg1 = '<span class="badge badge-danger">Erro</span>';
                break;
        }
    } elseif ($proj->aprov == 0) {
        if ($proj->para_avaliar == -1) {
            $msg1 = '<span class="badge badge-warning">Não submetido</span>';
            $submetido = false;
        }
    } else { // Erro
        $msg1 = '<span class="badge badge-info">Não definido</span>';
    }

    is_null($proj->colegiado) ? $col = 'A definir' : $col = $proj->colegiado;

    $where = 'id_proj = "'.$proj->id.'"';
    $order = 'ver desc, fase_seq desc';
    $ListaVerAnts = Avaliacoes::getRegistros($where, $order, null);

    $qntAvaliacoes = count($ListaVerAnts);

    $LastV = '';
    $progresso = '';
    if ($qntAvaliacoes > 0) {
        $retorno = montarTblEProgress($ListaVerAnts, $proj->id, $msg1); // return [$progresso, $LastV];
        $progresso = $retorno[0];
        $LastV = $retorno[1];
    } else {
        $progresso = $msg1;
        $LastV = '<span class="badge badge-light">Nenhuma avaliação</span>';
    }

    $resultados .= '
  <div class="card mt-2">
    <div class="card-header">
        <div class="row">
          <div class="col-sm-6"><a class="collapsed card-link" data-toggle="collapse" href="#p'.$proj->id.'">📃 '.$proj->titulo.'</a></div>
          <div class="col-sm-4">'.$proj->tipo_exten.'</div>
          <div class="col-sm-1"><span class="badge badge-light ">'.$progresso.'</span> </div>
          <div class="col-sm-1"></div>
        </div>
        <div class="row">
          <div class="col-sm"><strong>Submetido para:</strong> '.$col.'</div> 
        </div>
    </div>

    <div id="p'.$proj->id.'" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <p><strong>Resumo:</strong> '.resumirTexto($proj->resumo).'</p>
            <p><strong>Objetivos:</strong> '.resumirTexto($proj->objetivos).'</p>
          </div>
          <div class="col-4">'.$LastV.'</div>
        </div>
        
        <div class="d-flex justify-content-end"> 
           <hr>
        ';
    // / btns Inicio

    $verAnt = $proj->ver - 1;
    if (!$submetido) {
        $btnSub =
        '
       &nbsp;  <button id="sub'.$proj->id.'v'.$proj->ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter</button> &nbsp; 
       &nbsp; <button id="del'.$proj->id.'v'.$proj->ver.'" class="btn btn-danger  btn-sm mb-2" onclick="writeNumber(this)">🗑 Excluir</button> &nbsp; ';
    } else {
        if ($proj->last_result == 'r') {
            $btnSub = ' &nbsp; <a href="../forms/'.$proj->form.'/vista.php?p='.$proj->id.'&v='.$verAnt.'"><button class="btn btn-danger btn-sm mb-2" >📑 Informações de adequações</button></a> &nbsp; ';
        } else {
            $btnSub = ' &nbsp; <button id="Alt'.$proj->id.'v'.$proj->ver.'" class="btn btn-primary btn-sm mb-2" onclick="writeNumber(this)">📤 Submeter novamente</button> &nbsp; ';
        }
    }

    if ($proj->edt == 1) {
        $resultados .=

        $btnSub.
        ' &nbsp; <a href="editar.php?id='.$proj->id.'&v='.$proj->ver.'"><button class="btn btn-success btn-sm mb-2">📄 Editar</button></a> &nbsp;';
    } else {
        $nomecol = Colegiado::getRegistro($proj->para_avaliar);

        $reltorios = '';
        if ($showRelatorios) {
            $reltorios .=
            ' &nbsp; <a href="../relatorio/index.php?id='.$proj->id.'"><button class="btn btn-success btn-sm mb-2">📊 Relatório(s) Parcial/Final</button></a> &nbsp; ';
        }

        $resultados .=
          '
            <a href="visualizar.php?id='.$proj->id.'&v='.$proj->ver.'&w=1" target="_blank"><button class="btn btn-success btn-sm mb-2">Visualizar</button></a>
            &nbsp;'.$reltorios.' &nbsp;';
    }

    // / btns Fim

    $resultados .= '        </div>
      </div>
    </div> 
  </div>
    ';
}
$resultados .=
'</div>';

$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';

include '../includes/paginacao.php';

?>


<main>
  <h2 class="mt-0">Meus projetos</h2>
  
  <?php echo $msgAlert; ?> 
  <section>

    <form method="get">

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

  const btnOpen = document.getElementById("excluir1");
  const modal = document.querySelector("dialog");
  

  btnOpen.onclick = function(){
    modal.showModa();
  }


</script>
