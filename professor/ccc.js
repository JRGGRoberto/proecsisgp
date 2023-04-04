
/*
var ca = document.querySelector("#ca");
var ce = document.querySelector("#ce");
var co = document.querySelector("#co");
*/


const pegarCA = async() => {
  const data = await fetch(`../api/ca.php`)
    .then(resp => resp.json()).catch(error => false)

  if(!data) return;

  ce.innerHTML = ``;

  inserirCA(data);
}

const inserirCA = (data) => {

  ca.innerHTML = `<option value="">Selecione</option>`;
  data.forEach(e => {
   ca.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });

  ca.addEventListener("change", e => {
    co.innerHTML = '';
    pegarCE(ca.value)
  });
  
}

const pegarCE = async (id) => {

  const data = await fetch(`../api/ce.php?ca=${id}`)
     .then(resp => resp.json()).catch(error => false)

   if(!data) return;

   inserirCE(data);

}


const inserirCE = (data) => {

  ce.innerHTML = `<option value="">Selecione</option>`;
  data.forEach(e => {
   ce.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });
  ce.addEventListener("change", e => pegarCO(ce.value))
}

const pegarCO = async (id) => {

  const data = await fetch(`../api/co.php?ce=${id}`)
     .then(resp => resp.json()).catch(error => false)

   if(!data) return;

   inserirCO(data);

}


const inserirCO = (data) => {

  co.innerHTML = `<option value="">Selecione</option>`;
  data.forEach(e => {
   co.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });
}



function selectOpt (pos, id) {
  var el = document.getElementById(pos).value = id;
}

function desativar(pos) {
  document.getElementById(pos).disabled = true;
}


//pegarCA();

// pegarCE();
// pegarCO();





