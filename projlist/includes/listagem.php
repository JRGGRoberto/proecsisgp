<?php

require '../includes/msgAlert.php';
// include './includes/funcoes.php';

use App\Session\Login;

// Obriga o usuário a estar logado
Login::requireLogin();
$user = Login::getUsuarioLogado();
$userConfig = $user['config'];
$userTipo = $user['tipo'];
$userId = $user['id'];

$osCabeca = [1,2,3,4]; //só a elite


// if (in_array($userConfig, $osCabeca)) {
//   print_r($osCabeca);
// } 




$currentUrl = $_SERVER['REQUEST_URI'];
// echo '<pre>';
// print_r($user);
// echo '</pre>';



$qnt1 = 0;




$resultados = '
<table class="table table-sm table-striped table-bordered" id="tab" 
  style="
    border-left: 1px solid black;     
    border-right: 1px solid black; 
  ">
  <thead class="thead-dark sticky-top">
    <tr>
      <th>Título</th>
      <th>Coordenador</th>
      <th>Campus</th>
      <th>Tipo</th>
      <th>Protocolo</th>
      <th>Início</th>
      <th>Fim</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
';

foreach ($projetos as $proj) {
  $resultados .= '
    <tr class="">
      <td>'.$proj->titulo.'</td>
      <td>'.$proj->coord.'</td>
      <td>'.$proj->campus.'</td>
      <td>'.$proj->tipo_exten.'</td>
      <td>'.$proj->protocolo.'</td>
      <td>'.$proj->vigen_ini.'</td>
      <td>'.$proj->vigen_fim.'</td>
      <td class="text-nowrap ">'.$proj->estado.'</td>
    </tr>
  ';

  $qnt1 ++;
}

$resultados .= '
  </tbody>
</table>
';



$qnt1 > 0 ? $resultados : $resultados = 'Nenhum registro encontrado.';


// include '../includes/paginacao.php';
?>

<main>
  <h2 class="mt-0">Projetos para exportar</h2>
  
  <?php echo $msgAlert; ?> 
  <section>

<form method="get">
  <div class="row my-2">
    <div class="col-4">
      <label>Título</label>
      <input type="text" name="titulo" class="form-control form-control-sm"
             value="<?= $titulo ?>" id="titulo" onchange="showLimpar();">
    </div>

    <div class="col-4">
      <label>Coordenador</label>
      <input type="text" name="nome_prof" class="form-control form-control-sm"
             value="<?= $nome_prof ?>" id="nome_prof" onchange="showLimpar();">
    </div>

    <div class="col-4">
        <div class="form-group">
            <label for="tipoProj">Tipo de Projeto</label>
            <select name="tipoProj" id="tipoProj" class="form-control form-control-sm">
                <option value="">Todos</option>

                <?php foreach($tipos as $tp): ?>
                    <?php if($tp->id <= 5): ?>
                      <option value="<?= $tp->id ?>" <?= ($tipoProj == $tp->id ? 'selected' : '') ?>>
                          <?= $tp->nome ?>
                      </option>  
                    <?php endif ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-4">
      <label>Protocolo</label>
      <input type="text" name="protocolo" class="form-control form-control-sm"
             value="<?= $protocolo ?>" id="protocolo" onchange="showLimpar();">
    </div>

    <div class="col-4">
      <label>Campus</label>
      <input type="text" name="campus" class="form-control form-control-sm"
             value="<?= $campus ?>" id="campus" onchange="showLimpar();">
    </div>

    <div class="col-4">
      <label>Palavra-chave</label>
      <input type="text" name="palavra" class="form-control form-control-sm"
             value="<?= $palavra ?>" id="palavra" onchange="showLimpar();">
    </div>


    <div class="col-12 my-2">
      <div class="row">
        <div class="col-3">
          <label>Estado</label>

          <div class="d-flex flex-column flex-wrap gap-3 p-2 form-control form-control-sm"
            style="min-height:<?= in_array($userConfig,$osCabeca) ? '105' : '85' ?>px">

            <div class="form-check">
              <input class="form-check-input" type="checkbox" onchange="showLimpar();"
                name="emAvaliacao" id="emAvaliacao"
                <?= isset($_GET['emAvaliacao']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="emAvaliacao">Em avaliação</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" onchange="showLimpar();"
                name="execucao" id="execucao"
                <?= isset($_GET['execucao']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="execucao">Em execução</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" onchange="showLimpar();"
                name="finalizados" id="finalizados"
                <?= isset($_GET['finalizados']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="finalizados">Finalizados</label>
            </div>

            <?php if (in_array($userConfig, $osCabeca)) : ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" onchange="showLimpar();"
                name="naoIniciados" id="naoIniciados"
                <?= isset($_GET['naoIniciados']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="naoIniciados">Não iniciados</label>
            </div>
            <?php endif; ?>

          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Início vigência</label>
            <input type="date" name="vigen_ini" id="vigen_ini"
              class="form-control form-control-sm" onchange="showLimpar();"
              value="<?= substr($vigenIni,0,10) ?>">
          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Fim vigência</label>
            <input type="date" name="vigen_fim" id="vigen_fim"
              class="form-control form-control-sm"onchange="showLimpar();"
              value="<?= substr($vigenFim,0,10) ?>">
          </div>
        </div>

        <div class="col-4 d-flex align-items-end mt-2">
          <button type="submit" class="btn btn-primary btn-sm" id="filtroBtn">Filtrar</button>
          <a href="<?= $currentUrl ?>" id="limpar">
            <span class="badge badge-primary ml-2">X</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</form>


  </section>

  <section class="">

    <div class="d-flex flex-column justify-content-between " style="
      max-height: 580px;
      border-bottom: 1px solid #dee2e6; 
    ">
      <div class="d-flex justify-content-between">
        <h4>Quantidade de projetos:<span id="qtdProjetos"> <?= $qnt1 ?> </span></h4>
        <button class="btn btn-success mb-2" onclick="exportToExcel('tab')">Exportar 📃</button>
      </div>

      <div class="form-group ">
        <input 
          type="text" 
          class="form-control" 
          id="inputTbl" 
          placeholder="Pesquisa avançada (título, coordenador, campus, etc.)">
      </div>

      <div style="overflow: scroll;">
        <?php echo $resultados; ?>
      </div>
    </div>
    
  </section>

  <section class="mb-5">
    <div class="row mt-2 align-bottom">
      <div class="col">


      </div>
      <div class="col" >
        <!-- <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a> -->

      </div>
    </div>
  </section>
</main>





  <div class="modal fade" id="modalSub">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Título</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body" id="modalBody">
            

        </div>
        
        <div class="modal-footer" id="modalFooter">
          
        </div>
      </div>
    </div>
  </div>
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

  function exportToExcel(tab) {
    var tabela = document.getElementById(tab)
    // Converte a tabela para workbook
    var workbook = XLSX.utils.table_to_book(tabela, { sheet: "export_proec" })
    var planilha = workbook.Sheets["export_proec"]


    planilha["!cols"] = [
      { wch: 80 }, // titulo
      { wch: 40 }, // coordenador
      { wch: 15 }, // campus
      { wch: 15 }, // protocolo
      { wch: 10}, // inicio
      { wch: 10}, // fim
      { wch: 15 }, // estado
    ];
    


    XLSX.writeFile(workbook, "exportacao.xlsx");
  }

  
  function trocarPagina(sel) {
    if (sel.value === 'meus-projetos') {
      location.href = "./";
    } else {
      location.href = "projetos_all.php";
    }
  }
  
  
  function showLimpar(){
    let titulo = document.getElementById('titulo').value;
    let nome_prof = document.getElementById('nome_prof').value;
    let palavra   = document.getElementById('palavra').value;
    let campus = document.getElementById('campus').value;
    let protocolo   = document.getElementById('protocolo').value;
  
    let vigenIni = document.getElementById('vigen_ini').value;
    let vigenFim = document.getElementById('vigen_fim').value;

    let emAvaliacao = document.getElementById('emAvaliacao').checked;
    let execucao    = document.getElementById('execucao').checked;
    let finalizados = document.getElementById('finalizados').checked;
    let naoIniciados = document.getElementById('naoIniciados')?.checked ?? false;
    let filtrarBtn = document.getElementById('filtroBtn');



    if (
      titulo.length > 0 ||
      campus.length > 0 ||
      palavra.length > 0 ||
      nome_prof.length > 0 ||
      protocolo.length > 0 ||
      vigenIni.length > 0 ||
      vigenFim.length > 0 ||
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


  function mostrarQtdProjetos(n){
    qnt = document.getElementById('qtdProjetos');
    qnt.innerHTML = ` ${n}`;
  }

  //filtro da tabela 
  $(document).ready(function(){
    $("#inputTbl").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tab tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });

      let qntVisiveis = $("#tab tbody tr:visible").length;
      // console.log(qntVisiveis);
      mostrarQtdProjetos(qntVisiveis);
    });
  });


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
