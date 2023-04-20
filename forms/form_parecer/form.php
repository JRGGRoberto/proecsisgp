
<div class="container mt-4">
   <h3>PARECER</h3>
   <h4>Divisão de Extensão e Cultura dos Campi</h4>
      
  <form name="myform" id="myform" method="post" enctype="multipart/form-data">
       <ol>
        <li class="mb-4">
          <h5>Tipo de Proposta</h5>

            <div class="form-group">
                <input type="text" class="form-control" name="tp_proposta"  value="<?=$prj->tipo_exten?>" readonly>
            </div>
            
        </li>

        <li class="mb-4">
          <h5>Identificação da Proposta</h5>
            
            <div class="form-group">
              <label>Título</label>
              <input type="text" class="form-control" name="titulo" value="<?=$prj->titulo?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Proponente</label>
              <input type="text" class="form-control" name="coordNome" value="<?=$prj->nome_prof?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Colegiado de Curso</label>
              <input type="text" class="form-control" name="colegiado" value="<?=$prj->colegiado?>" readonly>
            </div>
            
            <div class="row">
            
              <div class="col">
                <div class="form-group">
                  <label for="area_extensao">Área de extensão</label>
                  <input type="text" class="form-control"  name="area_exten" value="<?=$prj->area_extensao?>" readonly>
                </div>
              </div>
            
              <div class="col">
                <div class="form-group">
                  <label for="linh_ext">Linha de  extensão</label>
                  <input type="text" class="form-control"  value="<?=$prj->linh_ext?>" readonly>
                </div>
              </div>

            </div>
        </li>

        <li class="mb-4">
          <h5>Parecer</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="parecer" rows="10" 
                placeholder="(Informar o parecer do projeto) 10 linhas máximo"><?=$form->parecer?></textarea>
                (O prazo para devolução da proposta com adequações segue o previsto no Regulamento de Extensão – Resolução 042/2022 – CEPE/UNESPAR)
              </div>
            </div>
          </div>
        </li>
    </ol>

    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="cidade"  value="<?=$user['campus']?>"></div>
        <div class="col-2"> <input type="date" class="form-control" name="dateAssing" id="dateAssing" readonly> </div>
      </div>
    </div>
    
    <div class="form-group">
      <input type="text" class="form-control" name="whosigns"  value="<?=$user['nome']?> - <?=$user['nivel']?>" readonly>
    </div>
      <p> </p><hr><p> </p>
    <div class="form-group form-group d-flex justify-content-around">
      <a href="javascript: submitSolicAlterac()" class="btn btn-warning" >Solicitar alterações ↩️</a>
      <a href="javascript: submitSave()" class="btn btn-secondary" >Avaliar mais tarde ⌛</a>
      <a href="javascript: submitAprova()" class="btn btn-success" >✔️ Enviar para próxima instância</a>
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
    <input type="hidden" name="a" value="<?=$user['id']?>">
    <input type="hidden" name="u" value="<?=$user['id']?>">
    <input id="anexosJS" name="anexosJS" type="text" hidden>
  </form>

</div>

<script src="formsBtn.js"></script>

