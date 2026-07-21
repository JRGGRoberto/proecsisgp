// Para usar é necessário inserir <div id="mensagens"></div> no HTML
// e chamar onde quer passar a mensagem

function exibirAlertaBootstrap(mensagem, tipo) {

    const container = document.getElementById('mensagens');

    container.innerHTML = '';

    container.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${mensagem}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}