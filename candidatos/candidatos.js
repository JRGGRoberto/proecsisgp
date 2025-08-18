let itens = [];
let itensI = [];

dados.forEach((e) => {
  if((e.cancelado == 1) ||(e.classif == null)){
    itensI.push(e);
  } else {
    itens.push(e);
  }
});

function salvaInfos(){
  console.table(dados);
  const altDados = document.getElementById("altDados");
  const formSalvaDados = document.getElementById("formSalvaDados");
  altDados.value = JSON.stringify(dados);
  formSalvaDados.submit();
}

const btnSalvar = document.getElementById("btnSalvar");
const lista = document.getElementById("listaRanc");
const listaI = document.getElementById("listaInscricoes");

document.addEventListener("DOMContentLoaded", () => {

  function renderLista() {
      lista.innerHTML = "";
      listaI.innerHTML = "";

      itens.forEach((item, index) => {
          const div = document.createElement("div");
          div.className = "alert alert-primary mb-2 d-flex justify-content-between align-items-center";
          div.textContent = item.texto;
          div.dataset.index = index;
          item.classif = index + 1;
          div.innerHTML = `
              <div style="text-align: left;">
              <span class="badge badge-primary"">#${item.classif}</span>
                ${item.prog} ${item.nome} ${item.curso}
                ${item.cidade}/${item.uf} ${item.tel1} ${item.email}
              </div>
            `;

          const btns = document.createElement("div");

          const btnDel = document.createElement("button");
          btnDel.className = "btn btn-sm btn-outline-light mr-2";
          btnDel.textContent = "❌";
          btnDel.onclick = () => desclassifcar(index);
          btns.appendChild(btnDel);

          if(index == 0){
            div.classList.remove("alert-primary");
            div.classList.add("alert-success");
          }

          // Botão mover para cima (só mostra se não for o primeiro)
          if (index > 0) {
              const btnUp = document.createElement("button");
              btnUp.className = "btn btn-sm btn-outline-light mr-1";
              btnUp.textContent = "⬆️";
              btnUp.onclick = () => mover(index, index - 1);
              btns.appendChild(btnUp);
          }

          // Botão mover para baixo (só mostra se não for o último)
          if (index < itens.length - 1) {
              const btnDown = document.createElement("button");
              btnDown.className = "btn btn-sm btn-outline-light";
              btnDown.textContent = "⬇️";
              btnDown.onclick = () => mover(index, index + 1);
              btns.appendChild(btnDown);
          }

          div.appendChild(btns);
          lista.appendChild(div);
      });


      itensI.forEach((item, index) => {
        const div = document.createElement("div");
        let cor = '';
        let icon = '';
        if(item.cancelado == 1){
          cor = 'dark';
          icon = '⛔'
        } else {
          cor = 'secondary';
          icon = '⏳'
        }
        div.className = `alert alert-${cor} mb-2 d-flex justify-content-between align-items-center`;
        div.textContent = item.texto;
        div.dataset.index = index;
        div.innerHTML = `
            <div style="text-align: left;">
            <span class="badge badge-light"">${icon}</span>
              ${item.prog} ${item.nome} ${item.curso}
              ${item.cidade}/${item.uf} ${item.tel1} ${item.email}
            </div>
          `;

        const btns = document.createElement("div");

        if(cor  == 'secondary'){
          const btnDescl = document.createElement("button");
          btnDescl.className = "btn btn-sm btn-outline-light mr-1";
          btnDescl.textContent = "⛔";
          btnDescl.onclick = () => faltou(index);
        /*
          btnDel.onclick = () => desclassifcar(index); 
          btnDescl.onclick = () => {
            item.cancelado = 1;
          };*/
          btns.appendChild(btnDescl);
        }

        const btnToRank = document.createElement("button");
        btnToRank.className = "btn btn-sm btn-outline-light mr-2";
        btnToRank.textContent = "🆗";
        btnToRank.onclick = () => toRank(index);
        btns.appendChild(btnToRank);
        div.appendChild(btns);
        listaI.appendChild(div);
    });
  }

  function mover(origIndex, destIndex) {
      const elementos = [...lista.children];
      const elemOrig = elementos[origIndex];
      const elemDest = elementos[destIndex];

      const deslocamentoOrig = elemDest.offsetTop - elemOrig.offsetTop;
      const deslocamentoDest = elemOrig.offsetTop - elemDest.offsetTop;

      // Aplica deslocamento temporário
      elemOrig.style.transform = `translateY(${deslocamentoOrig}px)`;
      elemDest.style.transform = `translateY(${deslocamentoDest}px)`;

      elemOrig.classList.add("moving");
      elemDest.classList.add("moving");

      btnSalvar.hidden = false;

      // Após animação, troca no array e re-renderiza
      setTimeout(() => {
          [itens[origIndex], itens[destIndex]] = [itens[destIndex], itens[origIndex]];
          renderLista();
      }, 500);
  }

  function faltou(index) {
    const elementos = [...listaI.children];
    const elem = elementos[index];
    itensI[index].cancelado = 1;
    // Animação de saída
    //elem.classList.add("blink");
    btnSalvar.hidden = false;

    setTimeout(() => {
        renderLista();
    }, 400);
  }

  function toRank(index) {
    const elementos = [...listaI.children];
    const elem = elementos[index];

    newItem = itensI[index];
    newItem.cancelado = 0;
    itens.push(newItem);
    
    // Animação de saída
    elem.classList.add("fade-out");

    btnSalvar.hidden = false;

    setTimeout(() => {
        itensI.splice(index, 1);
        renderLista();
    }, 400);
}

  function desclassifcar(index) {
    const elementos = [...lista.children];
    const elem = elementos[index];

    newItem = itens[index]; 
    newItem.cancelado = 1;
    itensI.push(newItem);
    
    // Animação de saída
    elem.classList.add("fade-out");
    btnSalvar.hidden = false;

    btnSalvar.hidden = false;

    setTimeout(() => {
        itens.splice(index, 1);
        renderLista();
    }, 400);
}

  renderLista();
});
