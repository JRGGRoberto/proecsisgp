<p class="text-muted mb-4">
    Selecione um usuário para visualizar suas propostas e relatórios pendentes.
</p>

<div class="card mb-3">
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Nome</th>
                        <th>Função</th>
                        <th class="text-center">Propostas</th>
                        <th class="text-center">Relatórios</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuariosPendentes)): ?>
                        <?php foreach ($usuariosPendentes as $usuario): ?>
                            <?php
                                $total = $usuario['projetos'] + $usuario['relatorios'];
                                $idAccordion = 'pendencia_' . md5($usuario['id']);
                            ?>

                            <tr
                                data-toggle="collapse"
                                data-target="#<?= $idAccordion ?>"
                                aria-expanded="false"
                                aria-controls="<?= $idAccordion ?>"
                                style="cursor: pointer;"
                            >
                                <td class="align-middle">
                                    <strong><?= htmlspecialchars($usuario['nome'] ?? '') ?></strong>
                                    <small class="d-block text-muted">
                                        <?= htmlspecialchars($usuario['email'] ?? '') ?>
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <?= htmlspecialchars($usuario['funcao'] ?? '') ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?= $usuario['projetos'] ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?= $usuario['relatorios'] ?>
                                </td>
                                <td class="text-center align-middle ">
                                    <strong><?= $total ?></strong>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5" class="p-0 border-0">
                                    <div id="<?= $idAccordion ?>" class="collapse">
                                        <div class="bg-light p-3 border-top">
                                            <!-- PROPOSTAS -->
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between align-items-center bg-dark text-white px-3 py-2 rounded-top">
                                                    <strong>📃 Propostas pendentes - Tramitação</strong>
                                                    <span class="badge badge-light">
                                                        <?= count($usuario['lista_propostas'] ?? []) ?>
                                                    </span>
                                                </div>

                                                <?php if (!empty($usuario['lista_propostas'])): ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-hover table-bordered bg-white mb-0">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Protocolo</th>
                                                                    <th>Título da proposta</th>
                                                                    <th>Fase</th>
                                                                    <th class="text-center" style="width: 15%;">Dias parados</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($usuario['lista_propostas'] as $proposta): ?>
                                                                    <tr>
                                                                        <td class="align-middle">
                                                                            <?= htmlspecialchars($proposta->protocolo ?? '') ?>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <?= htmlspecialchars($proposta->titulo ?? '') ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= htmlspecialchars($proposta->fase_avaliacao ?? '') ?>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <span class="badge badge-warning px-2 py-1">
                                                                                <?= (int) $proposta->dias_permanencia ?> dias
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="bg-white border border-top-0 p-3 text-muted small">
                                                        Nenhuma proposta pendente.
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <!-- RELATÓRIOS -->
                                            <div>

                                                <div class="d-flex justify-content-between align-items-center bg-dark text-white px-3 py-2 rounded-top">
                                                    <strong>📋 Relatórios pendentes - Tramitação</strong>
                                                    <span class="badge badge-light">
                                                        <?= count($usuario['lista_relatorios'] ?? []) ?>
                                                    </span>
                                                </div>

                                                <?php if (!empty($usuario['lista_relatorios'])): ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-hover table-bordered bg-white mb-0">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Protocolo</th>
                                                                    <th>Título do relatório</th>
                                                                    <th class="text-center">Fase</th>
                                                                    <th class="text-center" style="width: 15%;">Dias parados</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($usuario['lista_relatorios'] as $relatorio): ?>
                                                                    <tr>
                                                                        <td class="align-middle">
                                                                            <?= htmlspecialchars($relatorio->protocolo ?? '') ?>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <?= htmlspecialchars($relatorio->titulo ?? '') ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= htmlspecialchars($relatorio->fase_seq ?? '') ?>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <span class="badge badge-warning px-2 py-1">
                                                                                <?= (int) $relatorio->dias_permanencia ?> dias
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="bg-white border border-top-0 p-3 text-muted small">
                                                        Nenhum relatório pendente.
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Nenhum usuário com pendências encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>