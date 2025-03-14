<?php

  require('../includes/msgAlert.php');

  $resultados = '';
  if ($relQnt == 0){
    $resultados = 'Não há relatórios de execução realizados.';
  } else {
    foreach($relatorios as $rel){
      $resultados .= '<div class="card">';
      $resultados .= '<div class="card-body">';
      $resultados .= '<h5 class="card-title">'.$rel->periodo_ini.' à '.$rel->periodo_fim.'</h5>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades realizadas</h6>';
      $resultados .= '<p class="card-text">'.$rel->atvd_per.'</p>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Alterações</h6>';
      $resultados .= '<p class="card-text">'.$rel->alteracoes.'</p>';
      $resultados .= '<h6 class="card-subtitle mb-2 text-muted">Atividades para o próximo período</h6>';
      $resultados .= '<p class="card-text">'.$rel->atvd_prox_per.'</p>';
      $resultados .= '<p class="card-text"><small class="text-muted">Cadastrado em '.formatData($rel->created_at).'</small></p>';
      $resultados .= '<a href="editar.php?id='.$rel->id.'&v='.$rel->created_at.'" class="card-link">Editar</a>';
      $resultados .= '<a href="excluir.php?id='.$rel->id.'&v='.$rel->created_at.'" class="card-link">Excluir</a>';
      $resultados .= '</div>';
      $resultados .= '</div>';
    }

    $relatorios = 'as';

  }

?>


<main>
  <h2 class="mt-0">Relatórios</h2>
  <hr>

  
  <div class="form-group">
    <div>
      <h5>Título da proposta</h5>
      <input type="text" class="form-control" value="<?=$obProjeto->titulo; ?>" readonly><br>
    </div>
    <div class="row">

          <div class="col-3">
            <div class="form-group">
              <label>Modalidade</label>
              <input type="text" class="form-control" value="<?=$tipo; ?>" readonly>
              
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
              <label>Início vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_ini, 0, 10); ?>" readonly>
            </div>
          </div>
          
          <div class="col-2">
            <div class="form-group">
              <label>Fim vigência</label>
              <input type="date" class="form-control" value="<?=substr($obProjeto->vigen_fim, 0, 10); ?>" readonly>
            </div>
          </div>

          <div class="col-2">
            <div class="form-group">
               <label>Projeto</label><br>
                <a href="../projetos/visualizar.php?id=<?=$obProjeto->id; ?>&amp;v=<?=$obProjeto->ver; ?>&amp;w=1" target="_blank">
                  <button class="btn btn-success btn-sm mb-2">Visualizar</button>
                </a>
            </div>
          </div>

         </div>
         <hr>
         
  </div>
  
  <?=$msgAlert?> 

  <section>
    
    <?=$resultados?>
    
  </section>

  <section>
    <div class="row mt-2 align-bottom">
      <div class="col" >
        <!-- <a href="cadastrar.php"><button class="btn btn-success float-right btn-sm">Novo</button></a> -->
        <div class="dropup">
          <button type="button" class="btn btn-success dropdown-toggle btn-sm float-right" data-toggle="dropdown" >
            Novo
          </button>
          <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item btn-sm" href="./cadastrar.php?t=1&i=<?=$obProjeto->id; ?>">Relatório parcial</a>
              <a class="dropdown-item btn-sm" href="./cadastrar.php?t=2&i=<?=$obProjeto->id; ?>">Relatório final</a>

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
   echo 'const optspara = `' ;
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
    if(!data.colegiado){

    }
    modalTitle.innerText = 'Reenvio do projeto à PROEC';
    modalBody.innerHTML = `
          <div class="modal-body" id="modalBody">
            <h4>${data.titulo}</h4>
            <p>Ao confirmar que realizou as solicitações de alterações, clique para submeter a nova versão.</p>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="para_avaliar">Enviar para </label>
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
