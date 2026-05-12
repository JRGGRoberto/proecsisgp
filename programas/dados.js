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

  dataInscri.forEach(inscricao => {
    if (!inscricao.em ) {
      //verifica se está no periodo de inscrições pela flag 'aberto'
      if(inscricao.aberto == 1) {
        const option = document.createElement("option");
        option.value = inscricao.id;
        option.text = `${inscricao.prog} - ${inscricao.prof} [ ${inscricao.campus} ] ${inscricao.colegiado} - ${inscricao.aberto}`;
        elementoSelect.appendChild(option);
      }
    } else {
      const div = document.createElement("div");
      div.className = "alert alert-secondary alert-dismissible fade show";
      div.id = inscricao.id;

      let contHTML = `<strong>${inscricao.prog}</strong> ${inscricao.prof} <span class="badge badge-secondary">${inscricao.campus}</span> ${inscricao.colegiado}. <span class="badge badge-secondary">${inscricao.em}</span>`;
      if (inscricao.aberto == 1) {
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
    mensagem = mensagem.substring(0, mensagem.length - 2); // Remove the last two characters (inscricao.g., " X")

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
