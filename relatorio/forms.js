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

$('#sumnot_atvd_per').summernote({
  placeholder: 'Indicar e detalhar quais atividades foram realizadas até o momento, de acordo com o cronograma apresentado.',
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

$('#sumnot_alteracoes').summernote({
  placeholder: 'Em caso de alteração na proposta, apresentar os pontos alterados e a justificativa',
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

$('#sumnot_atvd_prox_per').summernote({
  placeholder: 'Indicar quais atividades serão realizadas para o período restante da proposta.',
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

  var atvd_per = document.getElementById("atvd_per");
  if(atvd_per){
    atvd_per.value = $('#sumnot_atvd_per').summernote('code');
  }

  var alteracoes = document.getElementById("alteracoes");
  if(alteracoes){
    alteracoes.value = $('#sumnot_alteracoes').summernote('code');
  } 

  var atvd_prox_per = document.getElementById("atvd_prox_per");
  if(atvd_prox_per){
    atvd_prox_per.value = $('#sumnot_atvd_prox_per').summernote('code');
  } 

  document.formAnexo.submit();
}
