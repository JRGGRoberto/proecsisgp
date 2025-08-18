let dataInscri = [];
let alertSelecionado = null;
let permitirFechar = false;
let modalInstance = null;

function deleteListarInscricoes(){
  const elementoPai = document.getElementById("listaInscricoes");
  if (elementoPai) elementoPai.innerHTML = "";
}

function listarInscricoes() {
  const elementoPaiDiv = document.getElementById("listaInscricoes");
  const elementoSelect = document.getElementById("inscricao");
  deleteListarInscricoes();

  dataInscri.forEach(e => {
    if (!e.em ) {
      //inscricao
      if(e.aberto == 1) {
        const option = document.createElement("option");
        option.value = e.id;
        option.text = `${e.prog} - ${e.prof} [ ${e.campus} ] ${e.colegiado} - ${e.aberto}`;
        elementoSelect.appendChild(option);
      }
    } else {
      const div = document.createElement("div");
      div.className = "alert alert-secondary alert-dismissible fade show";
      div.id = e.id;

      let contHTML = `<strong>${e.prog}</strong> ${e.prof} <span class="badge badge-secondary">${e.campus}</span> ${e.colegiado}. <span class="badge badge-secondary">${e.em}</span>`;
      if (e.aberto == 1) {
        contHTML = contHTML + 
              `<button type="button" class="fechar close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>`
              ;
      } else {
        contHTML = contHTML + ` <span class="badge badge-pill badge-dark w-100">Prazo encerrado para alterações</span>`;
      }
        
      div.innerHTML = contHTML;
      elementoPaiDiv.appendChild(div);
    }
  });
}

async function getDataInscri() {
  dataInscri = await fetch(`../api/incricCand.php?ca=${cand_id}`) 
    .then(resp => resp.json())
    .catch(error => []);
  listarInscricoes();

}

document.addEventListener('click', function(event) {
  const btn = event.target.closest('.alert .fechar ');
  if (btn) {
    event.preventDefault();

    const alertDiv = btn.closest('.alert');
    alertSelecionado = alertDiv;

    let mensagem = alertDiv.textContent.trim();
    mensagem = mensagem.substring(0, mensagem.length - 2); // Remove the last two characters (e.g., " X")

    document.getElementById('alertIdLabel').textContent = mensagem;

    document.getElementById('id_cand_del').value = cand_id;
    document.getElementById('id_prog_del').value = alertDiv.id;


    if (!modalInstance) {
      modalInstance = new bootstrap.Modal(document.getElementById('confirmModalOpen'));
    }
    modalInstance.show();
  }
});

function removeInscricao() {
//  let id_cand_del = document.getElementById('id_cand_del').value;
//  let id_prog_del = document.getElementById('id_prog_del').value;
  document.getElementById('frmdelInscr').submit();  
}  

document.getElementById('btnSim').addEventListener('click', function() {
  if (alertSelecionado) {
    alertSelecionado.remove(); 
    alertSelecionado = null;
    modalInstance.hide();
  }
  removeInscricao();

});

document.getElementById('btnNao').addEventListener('click', function() {
  if (alertSelecionado) {
    alertSelecionado = null;
    modalInstance.hide();
  }
});

getDataInscri();
