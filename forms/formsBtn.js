document.getElementById("dateAssing").valueAsDate = new Date();

function submitJSON() {
    // Equipe
    /*
    document.getElementById('equipeJS').value = '';
    var JsonEquipe = JSON.stringify(equipe);
    document.getElementById('equipeJS').value = JsonEquipe;
    */
  
    //Anexos
    document.getElementById('anexosJS').value = '';
    let anx =[];
    for (var i = 0; i < anexos.childElementCount; i++) {
     anx.push(anexos.childNodes[i].lang);
    }
    anx = JSON.stringify(anx);
    document.getElementById('anexosJS').value = anx;
  }  
  

function submitSolicAlterac() {
  const name = document.getElementById('resultado');
  name.value = 'r';
  submitJSON();
  document.myform.submit();
}

function submitSave() {
  const name = document.getElementById('resultado');
  name.value = 'e';
  submitJSON();
  document.myform.submit();
}

function submitAprova() {

  if(esseFormSelecProf){
    const selecao = document.getElementById('id_parecerista');
    if(selecao.value == -1){
      alert('Selecione um professor');
      return;
    }
  }
  const name = document.getElementById('resultado');
  name.value = 'a';
  submitJSON();
  document.myform.submit();
}