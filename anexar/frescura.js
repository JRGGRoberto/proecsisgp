
//svg de ícones dos arquivos
const icones = {
    pdf: `
        <svg viewBox="0 0 24 24" width="48" height="48">
            <path fill="#dc3545" d="M6 2h9l5 5v15H6z"/>
            <path fill="#fff" d="M15 2v6h6"/>
            <text x="8" y="18" font-size="5" fill="#fff">PDF</text>
        </svg>
    `,

    doc:
        `<svg viewBox="0 0 24 24" width="48" height="48">
            <path fill="#0d6efd" d="M6 2h9l5 5v15H6z"/>
            <path fill="#fff" d="M15 2v6h6"/>
            <text x="8" y="18" font-size="5" fill="#fff">DOC</text>
        </svg>`,

    xls:
        `<svg viewBox="0 0 24 24" width="48" height="48">
            <path fill="#198754" d="M6 2h9l5 5v15H6z"/>
            <path fill="#fff" d="M15 2v6h6"/>
            <text x="8" y="18" font-size="5" fill="#fff">XLS</text>
        </svg>`
};

//após enviar o arquivo
document.getElementById('arquivo').addEventListener('change', function () {

    const arquivo = this.files[0];
    const area = document.getElementById('arquivoSelecionado');
    const nome = document.getElementById('nomeArquivo');
    const tamanho = document.getElementById('tamanhoArquivo');
    const icone = document.getElementById('iconeArquivo');

    if (!arquivo) {
        area.classList.add('d-none');
        return;
    }

    nome.textContent = arquivo.name;

    const tamanhoKB = arquivo.size / 1024;

    tamanho.textContent = tamanhoKB < 1024
        ? tamanhoKB.toFixed(1) + ' KB'
        : (tamanhoKB / 1024).toFixed(2) + ' MB';

    const extensao = arquivo.name
        .split('.')
        .pop()
        .toLowerCase();

    //verifica a extensao do anexo e faz um innerHTML de acordo
    if (extensao === 'pdf') {
        icone.innerHTML = icones.pdf;
    } else if (['doc', 'docx'].includes(extensao)) {
        icone.innerHTML = icones.doc;
    } else if (['xls', 'xlsx'].includes(extensao)) {
        icone.innerHTML = icones.xls;
    } else {
        icone.innerHTML = `
            <svg viewBox="0 0 24 24" width="48" height="48">
                <path fill="#6c757d" d="M6 2h9l5 5v15H6z"/>
                <path fill="#fff" d="M15 2v6h6"/>
            </svg>
        `;
    }

    area.classList.remove('d-none');
});

function getIconeArquivo(nomeArquivo) {
    const extensao = nomeArquivo.split('.').pop().toLowerCase();

    const tipo = {
        pdf: 'pdf',
        doc: 'doc',
        docx: 'doc',
        xls: 'xls',
        xlsx: 'xls'
    }[extensao];

    return icones[tipo] || `
        <svg viewBox="0 0 24 24" width="48" height="48">
            <path fill="#6c757d" d="M6 2h9l5 5v15H6z"/>
            <path fill="#fff" d="M15 2v6h6"/>
        </svg>
    `;
}