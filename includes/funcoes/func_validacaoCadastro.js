// a variável usar verificação é para definir se quer ver se é um usuário duplicado ou não precisa
function aplicarValidacaoCadastroPessoa(idFormulario, usarVerificacao = 'n') {

    const formulario = document.getElementById(idFormulario);
    if (!formulario) return;

    const cpf = document.getElementById('cpf');
    arrumarCPF(cpf);
    const email = document.getElementById('email');
    

    formulario.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validaCPF(cpf.value)) { 
            exibirAlertaBootstrap(
                'CPF inválido. Verifique o número digitado.', 
                'danger'
            );
            cpf.focus();
            return;
        }

        if (!validaEmail(email.value)) {
            exibirAlertaBootstrap(
                'E-mail inválido. Utilize o email institucional', 
                'danger'
            );
            email.focus();
            return;
        }

        const cpfOk = await verificarDuplicidade(e, 'cadastro', 'cpf');
        const emailOk = await verificarDuplicidade(e, 'cadastro', 'email');

        if (cpfOk === 'ok' && emailOk === 'ok') {
            formulario.submit();
        }
    }); 
}