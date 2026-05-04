
<div class="container mt-4">
   <h3>Aceite de relatório: SELEÇÃO DE PROFESSOR PARA REALIZAR O PARECER</h3>
   <h4>Divisão de Extensão e Cultura dos Campi</h4>
      
  
            <div class="border border-secondary p-3">
              <hr>
              <h2>Relatório</h2>
              
              <?php

              echo $dataRelatorio;

              ?>
              <hr>
            </div>
        </li>
        <hr>
<form name="myform" id="myform" method="post" enctype="multipart/form-data">
        <li class="mb-4">
          <h5>Selecione um professor para realizar o parecer</h5>
          <select name="id_parecerista" id="id_parecerista" class="form-control" onchange="ativaBTN();">
              <option value="-1" selected="" >Selecione um professor</option>
               <?php echo $opc; ?>
            </select>
        </li>

        <li class="mb-4">
          <h5>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="solicitacoes" rows="10" 
                placeholder="(Descrever quais adequações devem ser realizadas para que o projeto ultrapasse esta etapa) 10 linhas máximo"><?php echo $form->solicitacoes; ?></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>


        <li class="mb-4">
          <h5 id="attc">Anexos</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <ul id="anexos"></ul>
                <iframe src="../upload/upload.php" frameborder="0" scrolling="no"></iframe>
                <?php echo $anex; ?>                
              </div>
            </div>
          </div>
        </li>
        
    </ol>

    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="cidade"  value="<?php echo $user['ca_nome']; ?>"></div>
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly value="<?php echo date('Y-m-d'); ?>"> </div>
      </div>
    </div>
    
    <div class="form-group">
      <?php $cargo = ['Prof/AG', 'Coordenador',  'Centro de Área', 'Chefe de Divisão', 'Diretor de campus']; ?>
      <input type="text" class="form-control" name="whosigns"  value="<?php echo $user['nome']; ?> - <?php echo $cargo[$user['config']]; ?>" readonly>
    </div>
      <p> </p><hr><p> </p>
    <div class="form-group form-group d-flex justify-content-around">
      <a href="javascript: submitSolicAlterac()" class="btn btn-warning" >Solicitar alterações ↩️</a>
      <a href="javascript: submitSave()" class="btn btn-secondary" >Avaliar mais tarde ⌛</a>
      <a href="javascript: submitAprova()" class="btn btn-success" id="btnSubmit">✔️ Enviar para próxima instância</a>
    </div>

    <div class="form-group form-group d-flex justify-content-around">
      <div class="col-4">
        <p><span class="badge badge-warning">↩️</span><small> Ao Solicitar alterações, esta avalização fica anexa a esta versão e uma nova versão do projeto é disponibilizada ao proponente, para que este realiza as alterações necessárias e volte a submeter a uma nova avaliação.</small></p>
      </div>
      <div class="col-4">
        <p><span class="badge badge-secondary">⌛</span><small> Os dados da avalização ficam salvos para outros acesso e alterações até que se chegue há um veredito.</small></p>
      </div>
      <div class="col-4">
        <p><span class="badge badge-success">✔️</span><small> O projeto não necessita de alterações, esta completamente atentendo os requisitos e será avaliado para a próxima instância ou registro/publicação.</small></p>
      </div>
      
    </div>
    <input type="hidden" id="resultado" name="resultado">
    <input id="anexosJS" name="anexosJS" type="text" hidden>
  </form>

</div>

<script>
const esseFormSelecProf = true;

const opt = document.getElementById('id_parecerista');
const btn = document.getElementById('btnSubmit');
           
function ativaBTN() {
        
    if((opt.value != -1 ) ){
      btn.disabled=false;
      
    } else {
      btn.disabled=true;
    }
  }


menuAvaliarVoltar = document.getElementById("menuAvaliarVoltar");
SectionVoltar = document.getElementById("SectionVoltar");
menuAvaliarVoltar.remove();
SectionVoltar.remove();
</script>
<script src="formsBtn.js"></script>


