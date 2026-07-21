// // JS para verificar a duplicidade de dados e retornar ao front
async function verificarDuplicidade(e, idFormulario, idCampo) {

    const formulario = document.getElementById(idFormulario);
    const campo = document.getElementById(idCampo);

    if (!formulario || !campo) return;

    const resp = await fetch(
        `../api/verificarExistenciaPessoas.php?tipoDados=${idCampo}&valorDados=${encodeURIComponent(campo.value)}`
    );
    const resultado = await resp.json();

    let valor = '';
    if (idCampo == 'cpf') {
        valor = 'CPF';
    }
    if (idCampo == 'email') {
        valor = 'E-mail';
    }

    let ok = '';
    if (resultado == false) {
        exibirAlertaBootstrap(
            `Já existe um cadastro com o ${valor} informado, entre em contato com o suporte para mais informações`,
            'danger'
        );
        campo.focus();
        return;
    } else {
        ok = 'ok';
        return ok;
    }

}


