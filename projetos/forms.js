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

function submitSalvar(){
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