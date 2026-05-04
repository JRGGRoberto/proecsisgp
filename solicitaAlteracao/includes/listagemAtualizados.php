<?php
// Valida se o usuário que está tentando acessar a página realmente pode acessar a página
if ($user['config'] != 3){
  echo "<script>location.replace('../home');</script>";
  exit;
}

?>

<main class="container mt-4">
    <h2 class="mb-4">Histórico de alteração de propostas</h2>
    
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

        <?php 
            else: 
            foreach ($dados as $index => $item): 
        ?>

        <div class="card mb-0 shadow-sm">

            <div class="card-header bg-light">
                <div class="d-flex align-items-center justify-content-between flex-wrap">

                    <!-- Título -->
                    <h4 class="mb-0 text-primary font-weight mr-2"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1 1 200px; max-width: 300px;">
                        <?= $item->titulo ?>
                    </h4>

                    <div class="d-flex ml-3 mr-0" >
                        <!-- Solicitante -->
                        <div class="d-flex mb-0 mr-3" style="font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1 1 100px; max-width: 200px;">
                            <strong class="text-secondary" style="min-width: 80px;">
                                Solicitante:
                            </strong>
                            <span class="text-truncate" style="max-width: 100%; ">
                                <?= $item->solicitante_nome ?>
                            </span>
                        </div>
                        <!-- Data -->
                        <div class="d-flex  mr-3" style="font-size: 0.9rem; white-space: nowrap;">
                            <strong class="text-secondary mr-1" style="min-width: 130px;">
                                Data de solicitação:
                            </strong>
                            <span>
                                <?= $item->data_solicitacao ?>
                            </span>
                        </div>
                        <!-- Resultado -->
                        <div class="d-flex  mr-3" style="font-size: 0.9rem; min-width: 100px; white-space: nowrap;">
                            <span class="mb-0">
                                <strong class="text-secondary mr-1" style="min-width: 130px;">
                                    Resultado:
                                </strong>
                                <?php 
                                    if($item->resultado === 'a'){
                                        echo '✅';
                                    }
                                    elseif($item->resultado === 'r'){
                                        echo '❌';
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                    <!-- Botão Exibir solicitação -->
                    <a class="btn btn-info btn-sm py-0 px-3 "
                        data-toggle="collapse"
                        href="#collapse<?= $index ?>">
                        Exibir avaliação
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
                <!-- Mensagem do solicitante-->
                <div class="mb-3">
                <strong>Mensagem do solicitante:</strong><br>
                <?= $item->mensagem_solicitante ?>
                </div>

                <!-- Parte 2 -->
                <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nome do validador:</strong><br>
                    <?= $item->validador_nome ?>
                </div>
                <div class="col-md-4">
                    <strong>Data da avaliação:</strong><br>
                    <?php
                        $dataFormatada = (new DateTime($item->data_resultado))->format('d/m/Y');
                        echo $dataFormatada;
                    ?>
                </div>
                <div class="col-md-4">
                    <strong>Resultado:</strong><br>
                    <?php 
                        if ($item->resultado === 'a'){
                            echo 'Aprovado';
                        } elseif ($item->resultado === 'r'){
                            echo 'Reprovado';
                        }
                    ?>
                </div>
                </div>
                <!-- Mensagem do validador-->
                <div class="mb-3">
                <strong>Mensagem do validador:</strong><br>
                <?= $item->mensagem_validador ?>
                </div>

                <div class="text-right">
                    <a class="btn btn-info btn-sm"
                        href="../propostas/visualizar.php?id=<?= $item->idproj ?>&v=<?= $item->verProj ?>"
                        target="_blank">
                        Visualizar proposta
                    </a>   
                </div>

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
