$('#sumnot_resumo').summernote({
  placeholder: 'Descrever o resumo da ação de extensão (no máximo 250 palavras), destacando sua relevância na perspectiva acadêmica e social, o público a que se destina e o resultado esperado. Este texto poderá ser publicado na homepage da PROEC, portanto, recomenda-se revisá-lo corretamente.',
  height: 250,
  tabsize: 2,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});

$('#sumnot_justificativa').summernote({
  placeholder: '(Identificar o problema e justificaro projeto). 20 linhas máximo',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});

$('#sumnot_objetivos').summernote({
  placeholder: '(O Objetivo Geral é a ação macro que se quer alcançar. E os Objetivos Específicos são as ações fracionadas, para se alcançar o Objetivo Geral). 10 linhas máximo.',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});

$('#sumnot_metodologia').summernote({
  placeholder: '(Explicar os procedimentos necessários para a execução do projeto destacando o método, ou seja, a explicação do delineamento do estudo, amostra, procedimentos para a coleta de dados, bem como, o plano para a análise de dados). 20 linhas máximo.',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});


$('#sumnot_contribuicao').summernote({
  placeholder: '(Identificar de que forma os resultados esperados do projeto contribuirão no cenário científico, tecnológicoe cultural  ). 10 linhas máximo',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});

$('#sumnot_cronograma').summernote({
  placeholder: '(considerar o período de vigência do projeto)',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link']]
  ]
});

$('#sumnot_referencia').summernote({
  placeholder: 'Referências',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});



$('#sumnot_obs').summernote({
  placeholder: 'Observações',
  tabsize: 2,
  height: 250,
  toolbar: [
    // [groupName, [list of button]]
    
    ['style', ['bold', 'italic', 'underline', 'hr', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture']]
  ]
});



function submitJSON() {
  // Equipe
  document.getElementById('equipeJS').value = '';
  var JsonEquipe = JSON.stringify(equipe);
  document.getElementById('equipeJS').value = JsonEquipe;

  //Anexos
  document.getElementById('anexosJS').value = '';
  let anx =[];
  for (var i = 0; i < anexos.childElementCount; i++) {
   anx.push(anexos.childNodes[i].lang);
  }
  anx = JSON.stringify(anx);
  document.getElementById('anexosJS').value = anx;
}  


function submitSumbeter(){
  $('#modalSub').modal('show');
  modalTitle.innerText = 'Submissão de projeto';
  modalBody.innerHTML = `
        <div class="modal-body" id="modalBody">
          <h4>Titulo</h4>
          <p>Ao submeter o projeto à PROEC, estás a aceitar que este será avaliado pelas instâncias competentes.</p>
          <p>Não será mais possível editá-lo a não ser que haja uma solicitação para isso.</p>
          <p>Concordando com o informado, selecione o colegiado o qual julga ser relacionado a ele e clique em Submeter.</p>
          
           <div class="row">
             <div class="col-12">
               <div class="form-group">
                  <label for="para_avaliar">Enviar para o colegiado de </label>
                  <select name="para_avaliar" id="selPara" class="form-control" onchange="ativaBTN();">
                    <option value="-1">Selecione</option>
                   //{optspara}
                  </select>
               </div>
             </div>
           </div>
        </div>
        `;
        modalFooter.innerHTML = data.innerHTML = `
                <form method="post" action="submeter.php?">
                    <input type="hidden" name="selecOpt"   value="" id="selecOpt">
                    <button type="submit" class="btn btn-primary btn-sm mb-2" id="btnSubmitN">📤 Submeter nova versão</button>
                </form>                    
                <button type="button" class="btn btn-secondary btn-sm mb-2" data-dismiss="modal">Fechar</button>
        `;
}

function submitSalvar(){

 /* 
 if( formulario == 2 ){
    var cnpq = document.getElementById("cnpq_garea").value;
    var cnpq_area = document.getElementById("cnpq_area").value;
    var cnpq_sarea = document.getElementById("cnpq_sarea").value;
    if((cnpq ==="") ||(cnpq_area ==="") ||(cnpq_sarea ==="")  ){
      alert('Preencha os itens de [Classificação do Projeto ou Programa] Item 7');
      window.location.href = "#cnpq_garea";
      return;
    }
  }
    */
  

  var resumo = document.getElementById("resumo");
  if(resumo){
    resumo.value = $('#sumnot_resumo').summernote('code');
  }
  

  var justificativa = document.getElementById("justificativa");
  if(justificativa){
    justificativa.value = $('#sumnot_justificativa').summernote('code');
  }
  
  
  var objetivos = document.getElementById("objetivos");
  if(objetivos){
    objetivos.value = $('#sumnot_objetivos').summernote('code');
  }

  var metodologia = document.getElementById("metodologia");
  if(metodologia){
    metodologia.value = $('#sumnot_metodologia').summernote('code');
  }

  var contribuicao = document.getElementById("contribuicao");
  if(contribuicao){
    contribuicao.value = $('#sumnot_contribuicao').summernote('code');
  }

  var cronograma = document.getElementById("cronograma");
  if(cronograma){
    cronograma.value = $('#sumnot_cronograma').summernote('code');
  }


  var obs = document.getElementById("obs");
  if(obs){
    obs.value = $('#sumnot_obs').summernote('code');
  }

  var referencia = document.getElementById("referencia");
  if(referencia){
    referencia.value = $('#sumnot_referencia').summernote('code');
  } 

  let palav1 = document.getElementById('palav1').value;
  let palav2 = document.getElementById('palav2').value;
  let palav3 = document.getElementById('palav3').value;
  let titulo = document.getElementById('titulo').value;
  const msgA = '⚠️ As palavras chaves não devem ser iguais'
  if((palav1.length > 0) && ((palav1 == palav2) || (palav1 == palav3))){ 
    alert(msgA);
    return;
  }
  if((palav2.length > 0) && ((palav2 == palav1) || (palav2 == palav3))){ 
    alert(msgA);
    return;
  }
  if(titulo.length < 3){ 
    alert('O projeto necessíta ter um título, e este precisa ter 3 caracteres');
    document.getElementById("titulo").focus();
    return;
  }
  submitJSON();

  document.formAnexo.submit();

}

async function keepConnection(){
  let campusUNESPAR = []
  let localHeader = document.getElementsByTagName('h4')[0];
  campusUNESPAR =  data = await fetch(`../api/ca.php`)
    .then(resp => resp.json()).catch(error => false);
    campusUNESPAR.forEach((campo) => {
      if (campo.nome == '<?php echo $user['ca_nome']; ?>') {
        console.log(campo.nome + ' - ' + localHeader.innerText );
    }
  });
}

const myInterval = window.setInterval(function() {
    keepConnection()
}, 120000);