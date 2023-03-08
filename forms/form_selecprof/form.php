
<div class="container mt-4">
   <h3>ANEXO A - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h3>
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
          <h5>Selecione um professor para realizar o parecer</h5>
          <select name="id_parecerista" id="id_parecerista" class="form-control" onchange="ativaBTN();">
              <option value="" selected="">Selecione um professor</option>
              <option value="3442d0c9-464d-11ed-9793-0266ad9885af">Ana Claudia Freitas Pantoja</option>
              <option value="4ee313a3-464c-11ed-9793-0266ad9885af">Ana Paula F. de Mendonça</option>
              <option value="56e08dde-099c-4d4c-aa2c-0161b2d6ff3f" selected="">Tânia Terezinha Rissa</option>
              <option value="74183e1a-4577-11ed-9793-0266ad9885af">Cleber Broietti</option>
              <option value="83690c70-2689-4e6c-83a3-ca4987ccc4f5">Sérgio Dantas</option>
              <option value="9c72f724-456b-11ed-9793-0266ad9885af">Joelma Castelo Bernardo da Silva</option>
              <option value="b8fa555f-cedb-47cf-91cc-7581736aac88">José Roberto de Góes Gomes</option>
              <option value="c30d4d76-464c-11ed-9793-0266ad9885af">Patrícia Josiane Tavares da Cunha</option>
              <option value="c771f75a-7427-4d7c-8ff1-388e8e59ff9d">Merline Cristina</option>
            </select>
        </li>

        <li class="mb-4">
          <h5>Solicitação de Adequações (Indicar qual item necessita de adequação e justificar)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="solicitacoes" rows="10" 
                placeholder="(Descrever quais adequações devem ser realizadas para que o projeto ultrapasse esta etapa) 10 linhas máximo"><?=$form->solicitacoes?></textarea>
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
  </form>

</div>

<script>

document.getElementById("dateAssing").valueAsDate = new Date();

function submitSolicAlterac()
{
  const name = document.getElementById('resultado');
  name.value = 'r';
  document.myform.submit();
}

function submitSave()
{
  const name = document.getElementById('resultado');
  name.value = 'e';
  document.myform.submit();
}

function submitAprova()
{
  const name = document.getElementById('resultado');
  name.value = 'a';
  document.myform.submit();
}
</script>


