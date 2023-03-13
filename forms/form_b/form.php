<div class="container mt-4">

<h3>ANEXO B - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h3>
    <h5>(Parecer) Colegiado de Curso</h5>

    
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
              <input type="text" class="form-control" name="coordNome" value="<?=$prj->titulo?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Proponente</label>
              <input type="text" class="form-control" name="coordNome" value="<?=$prj->nome_prof?>" readonly>
            </div>
            
            <div class="form-group">
              <label>Colegiado de Curso</label>
              <input type="text" class="form-control" name="coordNome" value="<?=$prj->colegiado?>" readonly>
            </div>
            
            <div class="row">
            
              <div class="col">
                <div class="form-group">
                  <label for="area_extensao">Área de extensão</label>
                  <input type="text" class="form-control"  value="<?=$prj->area_extensao?>" readonly>
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
        

        <li class="mb-4"><h5>Aspectos a serem observados na avaliação da proposta</h5>
          <div>
          
            <div class="row mb-3">
              <div class="col-6">O título condiz com a proposta apresentada?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_1" value="1" <?=$form->r3_1 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_1" value="0" <?=$form->r3_1 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há coerência entre a justificativa e os objetivos propostos?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_2" value="1" <?=$form->r3_2 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_2" value="0" <?=$form->r3_2 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há coerência entre os objetivos e a metodologia proposta?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_3" value="1" <?=$form->r3_3 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_3" value="0" <?=$form->r3_3 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta apresenta exequibilidade?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_4" value="1" <?=$form->r3_4 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_4" value="0" <?=$form->r3_4 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta é relevante para a área de conhecimento?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_5" value="1" <?=$form->r3_5 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_5" value="0" <?=$form->r3_5 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta articula-se com o PPC do curso?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_6" value="1" <?=$form->r3_6 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_6" value="0" <?=$form->r3_6 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há correspondência entre os objetivos propostos, a metodologia e os resultados esperados?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_7" value="1" <?=$form->r3_7 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_7" value="0" <?=$form->r3_7 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta apresenta relevância social, com possibilidade de ampliação de acesso e de inserção da Universidade junto à Comunidade?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_8" value="1" <?=$form->r3_8 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_8" value="0" <?=$form->r3_8 == '0'? "checked" : "" ?>> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Os resultados esperados favorecem a reflexão sobre a formação do estudante?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="r3_9" value="1" <?=$form->r3_9 == '1'? "checked" : "" ?>> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="r3_9" value="0" <?=$form->r3_9 == '0'? "checked" : "" ?>> Não
                  </label>
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
                placeholder="(Informar o parecer do projeto) 10 linhas no máximo"><?=$form->parecer?></textarea>
                
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
