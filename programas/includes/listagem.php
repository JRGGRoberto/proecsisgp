<?php
use App\Session\LoginCandidato;

$user = LoginCandidato::getUsuarioLogado();
// echo '<pre>';
// print_r($user);
// echo '</pre>';
?>

<div class="container mt-4">

    <h2 class="mb-4">Programas de Bolsas - PROEC</h2>

    <div class="row">

        <!-- PIBIS -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">PIBIS</h2>
                </div>

                <div class="card-body">

                    <h5 class="font-weight-bold">O que é o PIBIS?</h5>

                    <p style="text-align: justify;">
                        Segundo a Fundação Araucária, o PIBIS é um programa destinado à concessão
                        de bolsas a alunos regularmente matriculados em cursos de graduação da
                        Unespar, que atendam ao critério do Programa de Cotas da Universidade,
                        para desenvolvimento de atividades vinculadas à extensão universitária,
                        contribuindo para a política de inclusão social, produção e difusão do
                        conhecimento e permanência de estudantes oriundos de escolas públicas.
                    </p>

                    <p style="text-align: justify;">
                        O objetivo do PIBIS é incentivar a participação de alunos de graduação
                        no desenvolvimento de atividades de extensão direcionadas a temas de
                        interesse social.
                    </p>

                    <h5 class="mt-4">Editais 2026/2027</h5>

                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Edital</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>071/2026</td>
                                <td>
                                    <a href="https://proec.unespar.edu.br/menu-extensao/pibis/2026/edital-071-2026-pibis.pdf" target="_blank">
                                        Edital PIBIS
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mt-4">Formulários - 2026/2027</h5>

                    <ul>
                        <li>
                            <a href="./anexos/anexo-1-pibis-apresentacao-da-proposta.docx" download>
                                Anexo 1 - Apresentação de proposta
                            </a>
                        </li>
                        <li>
                            <a href="./anexos/anexo-2-tabela-de-pontuacao.xlsx" download>
                                Anexo 2 - Tabela de pontuação do Lattes
                            </a>
                        </li>
                    </ul>

                    <h5 class="mt-4">Formulários - 2025/2026</h5>

                    <ul>
                        <li>
                            <a href="./anexos/formulario-substituicao-pibis.doc" download>
                                Formulário de substituição
                            </a>
                        </li>
                        <li>
                            <a href="./anexos/pibis-2025-2026-relatorio.docx" download>
                                Formulário de relatório
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- PIBEX -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">PIBEX</h2>
                </div>

                <div class="card-body">

                    <h5 class="font-weight-bold">O que é o PIBEX?</h5>

                    <p style="text-align: justify;">
                        Segundo a Fundação Araucária, o PIBEX é um programa destinado à concessão
                        de bolsas a alunos regularmente matriculados em cursos de graduação das
                        instituições de ensino superior do Paraná para desenvolvimento de atividades
                        vinculadas à extensão universitária.
                    </p>

                    <p style="text-align: justify;">
                        O objetivo do PIBEX é viabilizar e estimular a interação de estudantes
                        da universidade com outros setores da sociedade, por meio de atividades
                        que contribuam para sua formação acadêmica, profissional e para o exercício
                        da cidadania.
                    </p>

                    <h5 class="mt-4">Editais 2026/2027</h5>

                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Edital</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>070/2026</td>
                                <td>
                                    <a href="https://proec.unespar.edu.br/menu-extensao/pibex/2026/edital-070-2026.pdf" target="_blank">
                                        Edital PIBEX
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mt-4">Formulários - 2026/2027</h5>

                    <ul>
                        <li>
                            <a href="./anexos/anexo-1-pibex-apresentacao-da-proposta.docx" download>
                                Anexo 1 - Apresentação de proposta
                            </a>
                        </li>
                        <li>
                            <a href="./anexos/anexo-2-tabela-de-pontuacao.xlsx" download>
                                Anexo 2 - Tabela de pontuação do Lattes
                            </a>
                        </li>
                    </ul>

                    <h5 class="mt-4">Formulários - 2025/2026</h5>

                    <ul>
                        <li>
                            <a href="./anexos/formulario-substituicao-pibex.doc" download>
                                Formulário de substituição
                            </a>
                        </li>
                        <li>
                            <a href="./anexos/pibex-2024-2025-relatorio.docx" download>
                                Relatório final
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>

</div>