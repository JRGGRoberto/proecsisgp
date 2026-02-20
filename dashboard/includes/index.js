

//variáveis para os gráficos
let graficoTipos;
let graficoProjetos;
let graficoRelatorios;
let graficoEncerrados;

const labelsTipos = [         // tipo_ext
    'Curso',                   //    1 
    'Evento',                  //    2 
    'Prestação de Serviço',    //    3
    'Programa',                //    4
    'Projeto'                  //    5
];

const labelsCampus = [
    'Apucarana',
    'Campo Mourão',
    'Curitiba I (EMBAP)',
    'Curitiba III (FAP)',
    'Loanda',
    'Paranaguá',
    'Paranavaí',
    'União da Vitória'
]

const labelsRelatorios = [
  'Relatórios Parciais',
  'Relatórios Finais'
];



function carregarDashboard(ano = '') {
    const urlProj = ano
        ? `../api/dashboard_proj.php?ano=${ano}`
        : `../api/dashboard_proj.php`;
        
    const urlRel = ano
        ? `../api/dashboard_rel.php?ano=${ano}`
        : `../api/dashboard_rel.php`;
        
    fetch(urlProj)
        .then(res => res.json())
        .then(data => {
            document.getElementById('qtdProjetos').innerText = data.qtdProjetos;
            document.getElementById('qtdEncerrados').innerText = data.qtdEncerrados;

            const titulo = ano ? `- ${ano}` : ' ';
            document.getElementById('graficoTitulo').innerHTML = titulo

            // contabiliza quantos projetos de cada tipo possui 
            const contagem = {};

            data.dadosProjetos.forEach(p => {
                contagem[p.tipo_exten] = (contagem[p.tipo_exten] || 0) + 1;
            });

            //percorre o array para saber se existe algum campus com o nome dos labels do gráfico pela api
            const campusTotal = labelsCampus.map(nomeCampus => {
                const encontrado = data.qtdPorCampus.find(c => c.campus === nomeCampus)
                return encontrado ? encontrado.total : 0
            })

            // console.log(campusTotal);
            // console.log(data.qtdPorCampus);

            const encerradosCampus = labelsCampus.map(nomeCampus => {
                const encontrado = data.qtdPorCampus.find(
                    c => c.campus === nomeCampus
                );
                return encontrado ? encontrado.encerrados : 0;
            });

            const dadosTipos = labelsTipos.map(
                tipo => contagem[tipo] || 0
            );
            console.log(encerradosCampus);  

            atualizarGraficoProjetos(campusTotal);
            atualizarGraficoEncerrados(encerradosCampus);
            atualizarGraficoTipos(dadosTipos);

            // console.log(dadosTipos)
            // console.log(contagem)
            // console.log(qtdPorCampus)
        });

    fetch(urlRel)
        .then(res => res.json())
        .then(data => {
            document.getElementById('qtdRelatorio').innerText = data.relatoriosQtdTotal;

            const relParcialQtd = data.relatoriosParciaisQtd;
            const relFinalQtd   = data.relatoriosFinaisQtd;

            const dadosRelatorios = [
                relParcialQtd,
                relFinalQtd
            ];

            atualizarGraficoRelatorios(dadosRelatorios);
        });
}

//Atualizando gráficos
function atualizarGraficoTipos(dados) {
    graficoTipos.data.datasets[0].data = dados;
    graficoTipos.update();
}

function atualizarGraficoProjetos(dados) {
    graficoProjetos.data.datasets[0].data = dados;
    graficoProjetos.update();
}

function atualizarGraficoRelatorios(dados){
    graficoRelatorios.data.datasets[0].data = dados;
    graficoRelatorios.update();
}

function atualizarGraficoEncerrados(dados) {
    graficoEncerrados.data.datasets[0].data = dados;
    graficoEncerrados.update();
}


const graficoProj = document.getElementById('graficoProjetos');
const graficoTp = document.getElementById('graficoTipos');
const graficoEnc = document.getElementById('graficoEncerrados');
const graficoRel = document.getElementById('graficoRelatorios');

const graficoAval = document.getElementById('graficoAvaliacoesProjetoUser');

// Gráfico de todas as propostas
graficoProjetos = new Chart(graficoProj, {
    type: 'bar',
    data: {
        labels: labelsCampus,
        datasets: [{
            data:[0, 0, 0, 0, 0, 0, 0, 0],
            backgroundColor: [
                '#1d80eaff',
                '#59a14f',
                '#f28e2b',
                '#fbd446ff',
                '#e15759',
                '#3fc9beff',
                '#571366ff',
                '#6e7070ff'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animations: {
            y: {
                duration: 1200,
                easing: 'easeOutBounce'
            },
            x: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        },

        plugins: {
            legend: false,
            title: {
                display: true,
                text: 'Propostas inseridos por campus'
            },
            tooltip: {
                callbacks: {
                     //colocando valores em %
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const valor = ctx.raw;
                        const perc = ((valor / total) * 100).toFixed(1); // 1 casa decimal

                        return `${ctx.label}: ${valor} propostas (${perc}%)`;
                    }
                }
            }
        }
    }
});

//Gráfico de tipos de propostas
graficoTipos = new Chart(graficoTp, {
    type: 'doughnut',
    data: {
        labels: labelsTipos,
        datasets: [{
            data: [0, 0, 0, 0, 0],
            backgroundColor: [
                '#388E3C',
                '#FFA000',
                '#955b32ff',
                '#D32F2F',
                '#1976D2'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Tipos de Proposta',
            },
            legend: {
                position: 'right',
                labels: {
                    //Função pra deixar os valores do gráfico ao lado da legenda 
                    generateLabels(chart) {
                        const data = chart.data;
                        const dataset = data.datasets[0];

                        return data.labels.map((label, i) => {
                            const value = dataset.data[i];

                            return {
                                text: `${label} — ${value}`,
                                fillStyle: dataset.backgroundColor[i],
                                strokeStyle: dataset.backgroundColor[i],
                                lineWidth: 1,
                                hidden: isNaN(value) || value === 0,
                                index: i
                            };
                        });
                    }

                }
            },
            tooltip: {
                callbacks: {
                    //colocando valores em %
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const valor = ctx.raw;
                        const perc = ((valor / total) * 100).toFixed(1); // 1 casa decimal

                        return `${ctx.label}: ${valor} propostas (${perc}%)`;
                    }
                }
            }
        }
    }
});

graficoEncerrados = new Chart(graficoEnc, {
    type: 'bar',
    data: {
        labels: labelsCampus,
        datasets: [{
            data:[0, 0, 0, 0, 0, 0, 0, 0],
            backgroundColor: [
                '#1d80eaff',
                '#59a14f',
                '#f28e2b',
                '#fbd446ff',
                '#e15759',
                '#3fc9beff',
                '#571366ff',
                '#6e7070ff'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animations: {
            y: {
                duration: 1200,
                easing: 'easeOutBounce'
            },
            x: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        },

        plugins: {
            legend: false,
            title: {
                display: true,
                text: 'Propostas encerradas por Campus'
            },
            tooltip: {
                callbacks: {
                     //colocando valores em %
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const valor = ctx.raw;
                        const perc = ((valor / total) * 100).toFixed(1); // 1 casa decimal

                        return `${ctx.label}: ${valor} propostas (${perc}%)`;
                    }
                }
            }
        }
    }
})

//Gráfico relatórios
graficoRelatorios = new Chart(graficoRel, {
    type: 'doughnut',
    data: {
        labels: labelsRelatorios,
        datasets: [{
            data: [0, 0],
            backgroundColor: [
                '#388E3C',
                '#1976D2'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Relatórios Publicados',
            },
            legend: {
                position: 'right',
                labels: {
                    //Função pra deixar os valores do gráfico ao lado da legenda 
                    generateLabels(chart) {
                        const data = chart.data;
                        const dataset = data.datasets[0];

                        return data.labels.map((label, i) => {
                            const value = dataset.data[i];

                            return {
                                text: `${label} — ${value}`,
                                fillStyle: dataset.backgroundColor[i],
                                strokeStyle: dataset.backgroundColor[i],
                                lineWidth: 1,
                                hidden: isNaN(value) || value === 0,
                                index: i
                            };
                        });
                    }
                }
            },
            tooltip: {
                callbacks: {
                    //colocando valores em %
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const valor = ctx.raw;
                        const perc = ((valor / total) * 100).toFixed(1); // 1 casa decimal

                        return `${ctx.label}: ${valor} propostas (${perc}%)`;
                    }
                }
            }
        }
    }
});

//Filtro de anos
document.querySelectorAll('.filtro-ano').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filtro-ano').forEach(b => b.classList.remove('active'));

        btn.classList.add('active');
        carregarDashboard(btn.dataset.ano);
    }); 
});

carregarDashboard();