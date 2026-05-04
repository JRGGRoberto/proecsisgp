<?php
// Valida se o usuário que está tentando acessar a página realmente pode acessar a página
if ($user['config'] != 3){
  echo "<script>location.replace('../home');</script>";
  exit;
}
?>

<main class="container mt-4">
  <h2 class="mb-4">Solicitações de alteração de propostas</h2>

  <!-- Filtro -->
  <?= filtro() ?>

  <?php if (!empty($_SESSION['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['msg'] ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php unset($_SESSION['msg']); ?>
  <?php endif; ?>

  <div id="accordion">

    <?php if (empty($dados)): ?>

      <div class="alert alert-info text-center">
        Não há projetos para avaliação
      </div>

    <?php else: ?>
    <?php foreach ($dados as $index => $item): ?>

      <div class="card mb-0 shadow-sm">

        <div class="card-header bg-light">
          <div class="d-flex align-items-center justify-content-between flex-wrap">

            <!-- Título -->
            <h4 class="mb-0 text-primary font-weight"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1 1 200px; max-width: 300px;">
              <?= $item->titulo ?>
            </h4>

            <div class="d-flex align-items-center flex-shrink-0 mr-5" style="min-width: 420px;">
              <!-- Solicitante -->
              <div class="d-flex align-items-center mr-4" style="font-size: 0.9rem; white-space: nowrap; min-width: 180px;">
                <strong class="text-secondary mr-2" style="min-width: 80px;">
                  Solicitante:
                </strong>
                <span class="text-truncate" style="max-width: 100%;">
                  <?= $item->solicitante_nome ?>
                </span>
              </div>
              <!-- Data -->
              <div class="d-flex align-items-center" style="font-size: 0.9rem; white-space: nowrap; min-width: 180px;">
                <strong class="text-secondary mr-2" style="min-width: 130px;">
                  Data de solicitação:
                </strong>
                <span>
                  <?= $item->data_solicitacao ?>
                </span>
              </div>
            </div>
            <!-- Botão Exibir solicitação -->
            <a class="btn btn-info btn-sm py-0 px-3 flex-shrink-0"
              data-toggle="collapse"
              href="#collapse<?= $index ?>">
              Exibir solicitação
            </a>

          </div>
        </div>

        <div id="collapse<?= $index ?>" class="collapse" data-parent="#accordion">
          <div class="card-body">
            <!-- Parte 1 -->
            <div class="row mb-3">
              <div class="col-md-4">
                <strong>Campo para alteração:</strong><br>
                <?= $item->campoAlterado ?>
              </div>
              <div class="col-md-4">
                <strong>Valor original:</strong><br>
                <?= $item->dado_orig ?>
              </div>
              <div class="col-md-4">
                <strong>Novo valor:</strong><br>
                <?= $item->dado_novo ?>
              </div>
            </div>
            <!-- Mensagem -->
            <div class="mb-3">
              <strong>Mensagem do solicitante:</strong><br>
              <?= $item->mensagem_solicitante ?>
            </div>

            <!-- Formulário de validação -->
            <!-- Mensagem do validador -->
            <form action="../api/realizaAlteracao.php?idAdendos=<?= $item->id?>&campo=<?=$item->id_alteracao?>" method="post">
              <div class="form-group">
                <textarea 
                class="form-control" 
                name="mensagem" 
                rows="3"
                placeholder="Informe um parecer..."
                required
                maxlength="250"></textarea>
              </div>

              <div class="text-right">
                <a class="btn btn-info btn-sm"
                  href="../propostas/visualizar.php?id=<?= $item->idproj ?>&v=<?= $item->verProj ?>"
                  target="_blank">
                  Visualizar proposta
                </a>

                <!-- Envio -->
                <button type="submit" name="resultado" value="a" class="btn btn-success btn-sm">Aprovar</button>
                <button type="submit" name="resultado" value="r" class="btn btn-danger btn-sm">Reprovar</button>
              </div>
            </form>

          </div>
        </div>

      </div>

    <?php 
      endforeach;
      endif; 
    
      // Paginação
      pagina($adendosPagination);
    ?>

  </div>
</main>