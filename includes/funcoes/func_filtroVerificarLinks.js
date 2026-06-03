function validaLinkLattes(link) {
    link = link.trim();
    const regex = /^http:\/\/lattes\.cnpq\.br\/\d{16}$/;
    return regex.test(link);
}

function validaLinkPortaria(link) {
    link = link.trim().toLowerCase();
    const campus = [
        '',
        'uniaodavitoria.',
        'paranavai.',
        'paranagua.',
        'fap.curitiba2.',
        'embap.curitiba1.',
        'campomourao.',
        'apucarana.'
    ];
    return campus.some(c =>
        link.startsWith(`https://${c}unespar.edu.br/`)
    );
}

function aplicarValidacaoLink(idFormulario, idCampoLink) {
    
    const formulario = document.getElementById(idFormulario);
    
    if (!formulario) {
        console.log('Formulário não encontrado');
        return;
    }

    formulario.addEventListener('submit', function(e) {

        const link = document.getElementById(idCampoLink).value;
        if (!link){
            return;
        }

        if (idCampoLink == 'lattes') {
            if (!validaLinkLattes(link)) {
                e.preventDefault();
                alert('Lattes inválido. Inserir o link completo');
            }
        }

        if (idCampoLink == 'portaria') {
            if (!validaLinkPortaria(link)) {
                e.preventDefault();
                alert('Portaria inválida. Inserir o link completo');
            }
        }

    });
}