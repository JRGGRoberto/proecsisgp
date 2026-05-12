// Para utilizar essa função é necessário referenciar a função "func_formatarValor.js"
// Essa função está na mesma pasta

// Retornar TRUE ou FALSE se a data estiver na condição certa
function pertenceDataDoisAnos(dataIncial, dataFinal) {
  const [y1, m1, d1] = dataIncial.split('-').map(Number);
  const [y2, m2, d2] = dataFinal.split('-').map(Number);

  // Se dataFinal for antes da dataIncial retorna false
  if (
    y2 < y1 ||
    (y2 === y1 && m2 < m1) ||
    (y2 === y1 && m2 === m1 && d2 < d1)
  ) {
    return false;
  }

  // Se passar +2 anos retorna false
  if (y2 > y1 + 2) return false;
  if (y2 < y1 + 2) return true;

  // Mesmo ano, compara o mês
  if (m2 > m1) return false;
  if (m2 < m1) return true;

  // Mesmo mês, compara o dia
  return d2 <= d1;
}

// Mensagem enviada ao front-end
function msgTotal(dentroDoIntervalo, valorNovo, newDataHoje, newValorAtual){
    let msg;
    if (valorNovo < newDataHoje) {
        msg = "A data informada deve ser igual ou superior à data de hoje!";
        return msg;
    }
    else if (!dentroDoIntervalo) {
        msg = "A data está fora do limite permitido!";
        return msg;
    }
    else if (valorNovo === newValorAtual) {
        msg = "Este valor é igual ao anterior!";
        return msg;
    }
    else {
        msg = "Ok!";
        return msg;
    }
}

// Utilizar essa função para validar se a data está correta
function validarTempoInformado(valorNovo, valorAtual, valorReferencia, campoAlterado){

    // Formatar data aaaa-mm-dd
    const newValorAtual = formatData(valorAtual);
    const newValoresOriginaisSAP = formatData(valorReferencia);

    // Capturar data/hora atual
    const agora = new Date();
    const dataFormatada = agora.toLocaleDateString('pt-BR');
    const newDataHoje = formatData(dataFormatada);

    // Debug: 
    // console.log("Novo valor: "+valorNovo);
    // console.log("Valor Atual: "+newValorAtual);
    // console.log("Valor para comparação: "+newValoresOriginaisSAP);
    // console.log("Campo para edição: "+campoAlterado);
    // console.log("Dia de hoje: "+newDataHoje);

    // Verificar se o vigen_ini é (dois anos) <= valorReferencia (vigen_fim) e diferente do valor anterior
    if (campoAlterado === 'vigen_ini') {
        const dentroDoIntervalo = pertenceDataDoisAnos(valorNovo, newValoresOriginaisSAP);
        return mensagem = msgTotal(dentroDoIntervalo, valorNovo, newDataHoje, newValorAtual);
    }
    // Verificar se o vigen_fim é (dois anos) >= valorReferencia (vigen_ini) e diferente do valor anterior
    else if (campoAlterado == 'vigen_fim') {
        const dentroDoIntervalo = pertenceDataDoisAnos(newValoresOriginaisSAP, valorNovo);
        return mensagem = msgTotal(dentroDoIntervalo, valorNovo, newDataHoje, newValorAtual);
    }

}