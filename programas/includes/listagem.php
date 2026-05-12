<?php
use App\Session\LoginCandidato;

$user = LoginCandidato::getUsuarioLogado();
?>

<div class="container mt-4">

  <h2 class="mb-4">Programas de Bolsas - PROEC</h2>

  <div class="row">
    <div class="col-md-6">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
          <h2 class="mb-0">PIBIS</h2>
        </div>

        <div class="card-body">
          <h6 class="font-weight-bold">O que é o PIBIS?</h6>
          <p style="text-align: justify;">
            Programa destinado à concessão de bolsas a alunos de graduação da Unespar,
            que atendam ao critério de cotas, para desenvolvimento de atividades de extensão.
          </p>

          <h6 class="mt-3">Editais 2025/2026</h6>
          <table class="table table-sm table-bordered">
            <thead class="thead-light">
              <tr>
                <th>Edital</th>
                <th>Descrição</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>001/2025</td><td>Portaria Comissão</td></tr>
              <tr><td>057/2025</td><td>Edital PIBIS</td></tr>
              <tr><td>064/2025</td><td>Homologação propostas</td></tr>
              <tr><td>071/2025</td><td>Classificação</td></tr>
              <tr><td>073/2025</td><td>Contemplados</td></tr>
              <tr><td>079/2025</td><td>Inscrições</td></tr>
              <tr><td>083/2025</td><td>Classificação candidatos</td></tr>
              <tr><td>088/2025</td><td>Resultado final</td></tr>
            </tbody>
          </table>

          <h6>Formulários</h6>
          <ul>
            <li>Anexo 1 - Proposta</li>
            <li>Anexo 2 - Lattes</li>
            <li>Plano de Trabalho</li>
            <li>Substituição</li>
            <li>Relatório</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
          <h2 class="mb-">PIBEX</h2>
        </div>

        <div class="card-body">
          <h6 class="font-weight-bold">O que é o PIBEX?</h6>
          <p style="text-align: justify;">
            Programa de bolsas para alunos de graduação do Paraná,
            voltado ao desenvolvimento de atividades de extensão universitária.
          </p>

          <h6 class="mt-3">Editais 2025/2026</h6>
          <table class="table table-sm table-bordered">
            <thead class="thead-light">
              <tr>
                <th>Edital</th>
                <th>Descrição</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>001/2025</td><td>Portaria Comissão</td></tr>
              <tr><td>056/2025</td><td>Edital PIBEX</td></tr>
              <tr><td>065/2025</td><td>Homologação propostas</td></tr>
              <tr><td>070/2025</td><td>Classificação</td></tr>
              <tr><td>072/2025</td><td>Contemplados</td></tr>
              <tr><td>078/2025</td><td>Inscrições</td></tr>
              <tr><td>082/2025</td><td>Classificação candidatos</td></tr>
              <tr><td>087/2025</td><td>Resultado final</td></tr>
            </tbody>
          </table>

          <h6>Formulários</h6>
          <ul>
            <li>Anexo 1 - Proposta</li>
            <li>Anexo 2 - Lattes</li>
            <li>Plano de Trabalho</li>
            <li>Substituição</li>
            <li>Relatório</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>