document.addEventListener("DOMContentLoaded", () => {
  const lista   = document.getElementById("listaRanc");
  const listaI  = document.getElementById("listaInscricoes");
  const form    = document.getElementById("formSalvaDados");
  const alt     = document.getElementById("altDados");
  const btnSave = document.getElementById("btnSalvar");
  const obsEl   = document.getElementById("obs");
  const btnConf = document.getElementById("btnConfirmar");

  // Normaliza cancelado para número
  dados.forEach(d => d.cancelado = Number(d.cancelado || 0));

  const state = {
    ranked: [],
    pool:   [],
    modal:  { type: null, index: null },
    obs:    ''
  };

  // Particiona
  dados.forEach(d => {
    if (d.cancelado === 1 || d.classif == null) state.pool.push(d);
    else state.ranked.push(d);
  });

  // Util
  function mostrarBtnSalvar() {
    console.log("Mostrar botão de salvar");
    btnSave.classList.remove("d-none");
  }

  // --- RENDERIZAÇÃO DAS LISTAS ---
  function render() {
    lista.innerHTML = "";
    listaI.innerHTML = "";

    // ranked
    state.ranked.forEach((item, index) => {
      item.classif = index + 1;

      const div = document.createElement("div");
      div.className = "alert mb-2 d-flex justify-content-between align-items-center " + 
                      (index === 0 ? "alert-success" : "alert-primary");

      const row = document.createElement("div");
      row.className = "row w-100";
      row.style.textAlign = "left";

      const c1 = document.createElement("div");
      c1.className = "col-7";
      c1.innerHTML = `<span class="badge badge-primary">#${item.classif}</span> <strong></strong>`;
      c1.querySelector("strong").textContent = item.nome;

      const c2 = document.createElement("div");
      c2.className = "col";
      c2.innerHTML = `<span class="badge badge-light"></span>`;
      c2.querySelector(".badge").textContent = `${item.curso} ${item.cidade}/${item.uf}`;

      const c3 = document.createElement("div");
      c3.className = "col";
      c3.innerHTML = `
        <span class="badge badge-light">
          ✉️ <a></a> | ☎️ <a></a>
        </span>`;
      const [mail, tel] = c3.querySelectorAll("a");
      mail.href = `mailto:${item.email}`;
      mail.textContent = item.email;
      tel.href = `tel:${item.tel1}`;
      tel.textContent = item.tel1;

      row.append(c1, c2, c3);

      const btns = document.createElement("div");
      btns.className = "btn-container";

      const bDel = document.createElement("button");
      bDel.className = "btn btn-sm btn-outline-light mr-2";
      bDel.textContent = "❌";
      bDel.addEventListener("click", () => openModal('d', index));
      btns.appendChild(bDel);

      if (index < state.ranked.length - 1) {
        const bDown = document.createElement("button");
        bDown.className = "btn btn-sm btn-outline-light";
        bDown.textContent = "⬇️";
        bDown.addEventListener("click", () => mover(index, index + 1));
        btns.appendChild(bDown);
      }
      if (index > 0) {
        const bUp = document.createElement("button");
        bUp.className = "btn btn-sm btn-outline-light mr-1";
        bUp.textContent = "⬆️";
        bUp.addEventListener("click", () => mover(index, index - 1));
        btns.appendChild(bUp);
      }

      //Se passar da data de seleção, não deixa selecionar mais, não mostar botões
      if(item.sel_cand == 1) {
        div.append(row, btns);
      } else {
        div.append(row);
      }
      
      lista.appendChild(div);

      // animação de entrada
      div.classList.add("fade-in");
      requestAnimationFrame(() => {
        div.classList.add("show");
        div.addEventListener("transitionend", () => {
          div.classList.remove("fade-in", "show");
        }, { once: true });
      });
    });

    // pool
    state.pool.forEach((item, index) => {
      const div = document.createElement("div");
      const cancelado = item.cancelado === 1;
      const cor  = cancelado ? "dark" : "secondary";
      const icon = cancelado ? "⛔" : "⏳";

      div.className = `alert alert-${cor} mb-2 d-flex justify-content-between align-items-center`;

      const row = document.createElement("div");
      row.className = "row w-100";
      row.style.textAlign = "left";

      const c1 = document.createElement("div");
      c1.className = "col-7";
      c1.innerHTML = `${icon} <strong></strong>`;
      c1.querySelector("strong").textContent = item.nome;

      const c2 = document.createElement("div");
      c2.className = "col";
      c2.innerHTML = `<span class="badge badge-light"></span>`;
      c2.querySelector(".badge").textContent = `${item.curso} ${item.cidade}/${item.uf}`;

      const c3 = document.createElement("div");
      c3.className = "col";
      c3.innerHTML = `
        <span class="badge badge-light">
          ✉️ <a></a> | ☎️ <a></a>
        </span>`;
      const [mail, tel] = c3.querySelectorAll("a");
      mail.href = `mailto:${item.email}`;
      mail.textContent = item.email;
      tel.href = `tel:${item.tel1}`;
      tel.textContent = item.tel1;

      if (cancelado && item.obs) {
        const msg = document.createElement("div");
        msg.className = "mt-2";
        msg.innerHTML = `<button type="button" class="btn btn-outline-light text-left text-dark w-100 disabled"><strong>[${item.dtava}] </strong></button>`;
        msg.querySelector("strong").append(document.createTextNode(" " + item.obs));
        c3.appendChild(msg);
      }

      row.append(c1, c2, c3);

      const btns = document.createElement("div");
      btns.className = "btn-container";

      if (!cancelado) {
        const bDesc = document.createElement("button");
        bDesc.className = "btn btn-sm btn-outline-light mr-1";
        bDesc.textContent = "⛔";
        bDesc.addEventListener("click", () => openModal('f', index));
        btns.appendChild(bDesc);
      }

      const bToRank = document.createElement("button");
      bToRank.className = "btn btn-sm btn-outline-light mr-2";
      bToRank.textContent = "🆗";
      bToRank.addEventListener("click", () => toRank(index));
      btns.appendChild(bToRank);


      //Se passar da data de seleção, não deixa selecionar mais, não mostar botões
      if(item.sel_cand == 1) {
        div.append(row, btns);
      } else {
        div.append(row);
      }

      listaI.appendChild(div);

      // animação de entrada
      div.classList.add("fade-in");
      requestAnimationFrame(() => {
        div.classList.add("show");
        div.addEventListener("transitionend", () => {
          div.classList.remove("fade-in", "show");
        }, { once: true });
      }); 
    });
  }

  // --- ANIMAÇÕES ---
  function mover(orig, dest) {
    const els = lista.children;
    const origEl = els[orig];
    const destEl = els[dest];

    const origTop = origEl.offsetTop;
    const destTop = destEl.offsetTop;

    [state.ranked[orig], state.ranked[dest]] = [state.ranked[dest], state.ranked[orig]];
    render();

    const newOrigEl = lista.children[dest];
    const newDestEl = lista.children[orig];

    const diffOrig = origTop - newOrigEl.offsetTop;
    const diffDest = destTop - newDestEl.offsetTop;

    newOrigEl.style.transition = "none";
    newOrigEl.style.transform = `translateY(${diffOrig}px)`;
    newDestEl.style.transition = "none";
    newDestEl.style.transform = `translateY(${diffDest}px)`;

    newOrigEl.offsetHeight; // força repaint

    newOrigEl.style.transition = "transform 0.5s ease";
    newOrigEl.style.transform = "";
    newDestEl.style.transition = "transform 0.5s ease";
    newDestEl.style.transform = "";

    mostrarBtnSalvar();
  }

  function toRank(index) {
    const el = listaI.children[index];
    el.style.transition = "transform 0.5s ease, opacity 0.5s ease";
    el.style.transform = "translateX(100%)";
    el.style.opacity = "0";

    el.addEventListener("transitionend", () => {
      const item = state.pool[index];
      item.cancelado = 0;
      state.ranked.push(item);
      state.pool.splice(index, 1);
      mostrarBtnSalvar();
      render();
    }, { once: true });
  }

  function desclassificar(index) {
    const el = lista.children[index];
    el.style.transition = "transform 0.5s ease, opacity 0.5s ease";
    el.style.transform = "translateX(-100%)";
    el.style.opacity = "0";

    el.addEventListener("transitionend", () => {
      const item = state.ranked[index];
      item.cancelado = 1;
      item.obs = state.obs;
      state.pool.push(item);
      state.ranked.splice(index, 1);
      mostrarBtnSalvar();
      render();
    }, { once: true });
  }

  function faltou(index) {
    const el = listaI.children[index];
    el.style.transition = "transform 0.5s ease, opacity 0.5s ease";
    el.style.transform = "translateX(-100%)";
    el.style.opacity = "0";

    el.addEventListener("transitionend", () => {
      const item = state.pool[index];
      item.cancelado = 1;
      item.obs = state.obs;
      mostrarBtnSalvar();
      render();
    }, { once: true });
  }

  // --- Modal ---
  function openModal(type, index) {
    state.modal.type = type;
    state.modal.index = index;
    obsEl.value = "";
    btnConf.disabled = true;
    $('#modalConfirmDesc').modal({backdrop:'static', keyboard:false}).modal('show');
  }

  obsEl.addEventListener('input', () => {
    btnConf.disabled = obsEl.value.trim().length < 5;
  });

  btnConf.addEventListener('click', () => {
    state.obs = obsEl.value.trim();
    if (state.modal.type === 'd') desclassificar(state.modal.index);
    if (state.modal.type === 'f') faltou(state.modal.index);
    $('#modalConfirmDesc').modal('hide');
  });

  // salvar
  window.salvaInfos = function() {
    alt.value = JSON.stringify(dados);
    form.submit();
  };

  render();
});
