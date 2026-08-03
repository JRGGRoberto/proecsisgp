// Passar o valor do email (ex: ath.grr@unespar.edu.br)
function validaEmail(email) {
    email = email.trim().toLowerCase();

    const regex = /^[a-zA-Z0-9._%+-]+@(unespar\.edu\.br|estudante\.unespar\.edu\.br|ies\.unespar\.edu\.br)$/;

    return regex.test(email);
}