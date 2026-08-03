document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('telefone').addEventListener('input', function (e) {

        var value = e.target.value.replace(/\D/g, '').slice(0, 11);

        value = value.replace(/^(\d{2})(\d)/g, '($1)$2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');

        e.target.value = value;

    });

});