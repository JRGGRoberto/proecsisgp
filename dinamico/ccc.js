
const ca = document.querySelector("#ca");
const ce = document.querySelector("#ce");
const co = document.querySelector("#co");

const pegarCA = async() => {
  const data = await fetch(`https://${location.host}/sis/api/ca.php`)
    .then(resp => resp.json()).catch(error => false)

  if(!data) return;

  inserirCA(data);
}

const inserirCA = (data) => {

  ca.innerHTML = `<option values="">Selecione</option>`;
  data.forEach(e => {
   ca.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });
  
  ca.addEventListener("change", e => pegarCE(ca.value));
  co.innerHTML = ``;
}

const pegarCE = async (id) => {

  const data = await fetch(`https://${location.host}/sis/api/ce.php?ca=${id}`)
     .then(resp => resp.json()).catch(error => false)

   if(!data) return;

   inserirCE(data);

}


const inserirCE = (data) => {

  ce.innerHTML = `<option values="">Selecione</option>`;
  data.forEach(e => {
   ce.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });
  ce.addEventListener("change", e => pegarCO(ce.value))
}

const pegarCO = async (id) => {

  const data = await fetch(`https://${location.host}/sis/api/co.php?ce=${id}`)
     .then(resp => resp.json()).catch(error => false)

   if(!data) return;

   inserirCO(data);

}


const inserirCO = (data) => {

  co.innerHTML = `<option values="">Selecione</option>`;
  data.forEach(e => {
   co.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
  });
}


pegarCA();
// pegarCE();
// pegarCO();





