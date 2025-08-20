let itens = [];
let itensI = [];

var obsmsg = ''

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
              <div style="text-align: left;"class="row w-100">
                <div class="col-7">
                    <span class="badge badge-primary">#${item.classif}</span>
                    <strong>${item.nome}</strong>
                </div>
                <div class="col">
                    <span class="badge badge-light">${item.curso} <wbr> ${item.cidade}/${item.uf}</span>
                </div>
                <div class="col">
                  <span class="badge badge-light">
                     ✉️ <a href="mailto:${item.email}">${item.email}</a> |
                     ☎️ <a href="tel:${item.tel1}">${item.tel1}</a>
                  </span>
                </div>
              </div>
            `;

          const btns = document.createElement("div");
          btns.className = "btn-container";

          const btnDel = document.createElement("button");
          btnDel.className = "btn btn-sm btn-outline-light mr-2";
          btnDel.textContent = "❌";
          btnDel.onclick = () => cnfDesc(index, 'd');
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
        let msgCancelado = '';
        if(item.cancelado == 1){
          cor = 'dark';
          icon = '⛔'
          msgCancelado = item.obs ? `<hr><button type="button" class="btn btn-outline-light text-left text-dark w-100 disabled"><strong>[${item.dtava}] ${item.obs}</strong></button>` : '';
        } else {
          cor = 'secondary';
          icon = '⏳'
        }

        div.className = `alert alert-${cor} mb-2 d-flex justify-content-between align-items-center`;
        div.textContent = item.texto;
        div.dataset.index = index;
        div.innerHTML = `
            <div style="text-align: left;" class="row w-100">
              <div class="col-7">
                 ${icon} <strong>${item.nome}</strong>
              </div>
              <div class="col">
                <span class="badge badge-light">${item.curso} <wbr> ${item.cidade}/${item.uf}</span>
              </div>
              <div class="col">
                <span class="badge badge-light">
                    ✉️ <a href="mailto:${item.email}">${item.email}</a> |
                    ☎️ <a href="tel:${item.tel1}">${item.tel1}</a>
                </span>${msgCancelado}
              </div>
            </div>
          `;

        const btns = document.createElement("div");
        btns.className = "btn-container";

        if(cor  == 'secondary'){
          const btnDescl = document.createElement("button");
          btnDescl.className = "btn btn-sm btn-outline-light mr-1";
          btnDescl.textContent = "⛔";
          btnDescl.onclick = () => cnfDesc(index, 'f');
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

      mostarBtnSalvar();

      // Após animação, troca no array e re-renderiza
      setTimeout(() => {
          [itens[origIndex], itens[destIndex]] = [itens[destIndex], itens[origIndex]];
          renderLista();
      }, 500);
  }


  function toRank(index) {
    const elementos = [...listaI.children];
    const elem = elementos[index];

    newItem = itensI[index];
    newItem.cancelado = 0;
    itens.push(newItem);
    
    // Animação de saída
    elem.classList.add("fade-out");

    mostarBtnSalvar();

    setTimeout(() => {
        itensI.splice(index, 1);
        renderLista();
    }, 400);
  }

  function cnfDesc(index, tp){
    $('#modalConfirmDesc').modal('show');
    document.getElementById('obs').value = '';
    document.getElementById('tp').innerHTML = tp;
    document.getElementById('idx').innerHTML = index; 
    document.getElementById('btnConfirmar').setAttribute('disabled', true);  
  }

  function faltou(index) {
    const elementos = [...listaI.children];
    itensI[index].cancelado = 1;
    itensI[index].obs = obsmsg;
    mostarBtnSalvar();
    setTimeout(() => {
        renderLista();
    }, 400);
  }

  function desclassifcar(index) {
    const elementos = [...lista.children];
    const elem = elementos[index];
    newItem = itens[index]; 
    newItem.cancelado = 1;
    newItem.obs = obsmsg;
    itensI.push(newItem);
    
    // Animação de saída
    elem.classList.add("fade-out");
    mostarBtnSalvar();

    setTimeout(() => {
        itens.splice(index, 1);
        renderLista();
    }, 400);
  }

  function mostarBtnSalvar() {
    btnSalvar.hidden = false; // torna visível no fluxo
    requestAnimationFrame(() => { // força repaint antes da transição
        btnSalvar.classList.add("show");
    });
  }


  document.getElementById('obs').addEventListener('input', function() {
    const btnConfirmar = document.getElementById('btnConfirmar');
    if (this.value.trim().length >= 5) {
      btnConfirmar.removeAttribute('disabled');
    } else {
      btnConfirmar.setAttribute('disabled', true);
    }
  });

  // Retornar valor de cada botão
  document.getElementById('btnConfirmar').addEventListener('click', function() {
    obsmsg  = document.getElementById('obs').value.trim();
    const tp = document.getElementById('tp').innerHTML;
    const idx = document.getElementById('idx').innerHTML;
    console.log('Tipo de ação:', tp, 'Mensagem:', obsmsg);
    if (tp == 'd') {
        desclassifcar(idx);
        console.table(itens[idx]);
    } else if (tp == 'f') {
        faltou(idx);
        console.table(itensI[idx]);
    }


    $('#modalConfirmDesc').modal('hide');

  });

  document.getElementById('btnCancelar').addEventListener('click', function() {
    return false;
  });

  renderLista();
});


