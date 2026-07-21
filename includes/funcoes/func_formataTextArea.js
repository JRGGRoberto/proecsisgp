//js pra pegar todo o textarea na hora de fazer um cntrl p
window.addEventListener('beforeprint', function () {
    document.querySelectorAll('textarea').forEach(function (textarea) {
        textarea.dataset.originalHeight = textarea.style.height;

        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
        textarea.style.overflow = 'hidden';
    });
});

window.addEventListener('afterprint', function () {
    document.querySelectorAll('textarea').forEach(function (textarea) {
        textarea.style.height = textarea.dataset.originalHeight;
        textarea.style.overflow = '';
    });
});