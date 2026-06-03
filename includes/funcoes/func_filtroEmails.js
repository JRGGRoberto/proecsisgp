function validaEmail(email) {
    email = email.trim().toLowerCase();

    const regex = /^[a-zA-Z0-9._%+-]+@(unespar\.edu\.br|estudante\.unespar\.edu\.br|ies\.unespar\.edu\.br)$/;

    return regex.test(email);
}

function aplicarValidacaoEmail(idFormulario, idCampoEmail = 'email') {
    const formulario = document.getElementById(idFormulario);

    if (!formulario) return;

    formulario.addEventListener('submit', function(e) {
        const email = document.getElementById(idCampoEmail).value;

        if (!validaEmail(email)) {
            e.preventDefault();
            alert('E-mail inválido. Utilize o email institucional');
            document.getElementById(idCampoEmail).focus();
        }
    });
}