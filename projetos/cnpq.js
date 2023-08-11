var ga = document.querySelector("#cnpq_garea");
var ar = document.querySelector("#cnpq_area");
var sa = document.querySelector("#cnpq_sarea");

const pegarGA = async() => {
    const data = await fetch(`../api/cnpqGA.php`)
      .then(resp => resp.json()).catch(error => false)
  
    if(!data) return;
  
    ar.innerHTML = ``;
  
    inserirGA(data);
  }
  
  const inserirGA = (data) => {
  
    ga.innerHTML = `<option value="">Selecione</option>`;
    data.forEach(e => {
     ga.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
    });
  
    ga.addEventListener("change", e => {
      ar.innerHTML = '';
      pegarAr(ga.value)
    });
    
  }
  
  const pegarAr = async (id) => {
  
    const data = await fetch(`../api/cnpqA.php?ga=${id}`)
       .then(resp => resp.json()).catch(error => false)
  
     if(!data) return;
  
     inserirAr(data);
  
  }
  
  
  const inserirAr = (data) => {
  
    ar.innerHTML = `<option value="">Selecione</option>`;
    data.forEach(e => {
     ar.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
    });
    ar.addEventListener("change", e => pegarSA(ar.value))
  }
  
  const pegarSA = async (id) => {
  
    const data = await fetch(`../api/cnpqSA.php?ar=${id}`)
       .then(resp => resp.json()).catch(error => false)
  
     if(!data) return;
  
     inserirSA(data);
  
  }
  
  
  const inserirSA = (data) => {
  
    ar.innerHTML = `<option value="">Selecione</option>`;
    data.forEach(e => {
     ar.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
    });
  }
  
  