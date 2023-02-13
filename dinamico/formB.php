<div class="container mt-4">

<h3>ANEXO B - FORMULÁRIO PARA AVALIAÇÃO DE AÇÃO EXTENSIONISTA</h3>
    <h5>(Parecer) Colegiado de Curso</h5>

    
<form action="">
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
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há coerência entre a justificativa e os objetivos propostos?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há coerência entre os objetivos e a metodologia proposta?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta apresenta exequibilidade?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta é relevante para a área de conhecimento?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta articula-se com o PPC do curso?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Há correspondência entre os objetivos propostos, a metodologia e os resultados esperados?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">A proposta apresenta relevância social, com possibilidade de ampliação de acesso e de inserção da Universidade junto à Comunidade?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6">Os resultados esperados favorecem a reflexão sobre a formação do estudante?</div>
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1"> Sim
                  </label>
              </div>
                            
              <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Não
                  </label>
              </div>
            </div>

          </div>
        </li>
   
       
        <li class="mb-4"><h5>Parecer (Com base nos aspectos avaliados no item 3, redija o Parecer justificando a recomendação ou a declinação da proposta)</h5>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" name="contrap_nofinac" rows="10" 
                placeholder="(Descrever as ações não financeiras que serão suportadas no projeto pela Instituição Proponente) 10 linhas máximo"></textarea>
              </div>
            </div>
          </div>
        </li>
    </ol>


    <div class="form-group">
      <div class="row">
        <div class="col-3"><input type="text" class="form-control" name="tp_proposta"  value="Cidade"></div>
        <div class="col-2"> <input type="date" class="form-control" name="" id="dateAssingB" readonly> </div>
      </div>

      
    </div>

    <div class="form-group">
      <input type="text" class="form-control" name="parecerista_nome"  value="<?=$parecerista_nome?>" readonly>
      Parecerista
    </div>
    

    <div class="form-group">
      <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
    </div>
    

</form>

</div>
<script>
  document.getElementById("dateAssingB").valueAsDate = new Date();
</script>
