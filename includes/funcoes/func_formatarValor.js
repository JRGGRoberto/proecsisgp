// FORMATAR VALORES PARA PADRÃO
function formatarValor(campo, valor) {
    if (!valor) return '';

    // Sim e Não
    if (campo === 'tide') {
        return valor === 'S' ? 'Sim' : valor === 'N' ? 'Não' : valor;
    }

    // Data DD/MM/AAAA
    if ((campo === 'vigen_ini' || campo === 'vigen_fim') && valor) {
        const data = valor.split(' ')[0];
        const [ano, mes, dia] = data.split('-') || [];

        if (ano && mes && dia) {
            return `${dia}/${mes}/${ano}`;
        }   
    }

    return valor;
}

// FORMATAR VALORES PARA FORMATAÇÕES ESPECÍFICAS

// DATA ISO 8601 (AAAA-MM-DD)
function formatData(vlr) {
    if (!vlr) return null;
    
    if (vlr.includes('-')) {
        return vlr.split(' ')[0];
    }
    
    if (vlr.includes('/')) {
        const [dia, mes, ano] = vlr.split('/');
        return `${ano}-${mes}-${dia}`;
    }
    return vlr;
}

