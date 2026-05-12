

  const pegarGA = async() => {
    const data = await fetch(`../api/cnpqGA.php`)
      .then(resp => resp.json()).catch(error => false)
  
    if(!data) return;
  
//    ar.innerHTML = '';
  
    inserirGA(data);
  }
  
  const inserirGA = (data) => {
  
    ga.innerHTML = `<option value="">Selecione</option>`;
    data.forEach(e => {
     ga.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
    });
  
    ga.addEventListener("change", e => {
      sa.innerHTML = '';
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
  
    sa.innerHTML = `<option value="">Selecione</option>`;
    data.forEach(e => {
     sa.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
    });
  }
  

  function selectOpt (pos, id) {
    var el = document.getElementById(pos).value = id;
  }
  

  // ga.addEventListener("change",pegarGA());

