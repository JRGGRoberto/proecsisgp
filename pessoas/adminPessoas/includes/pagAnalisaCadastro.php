<?php 

$alert ='';
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    $alert = '
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Ação realizada!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
}
elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 'false') {
    $alert = '
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Erro ao realizar ação!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
}

?>


<main class="container mt-4">

    <!-- Cabeçalho -->
    <div class="row align-items-center mb-4 position-relative">
        <div class="col text-center">
            <h1 class="mb-0"><strong>Solicitações</strong></h1>
        </div>

        <div class="position-absolute mt-5" style="right:15px;">
            <button
                type="button"
                class="btn btn-sm btn-primary"
                onclick="history.back()">
                Voltar
            </button>
        </div>
    </div>


    <!-- Mensagem de Sucesso -->
    <div>
        <?php echo $alert ?>
    </div>
    <?php if (isset($_GET['sucesso'])): ?>
        <script>
            const url = new URL(window.location);
            url.search = url.search.replace('sucesso=1', 'sucesso');
            url.search = url.search.replace('sucesso=false', 'sucesso');

            url.search = url.search.replace('salvo=true', '');
            window.history.replaceState({}, document.title, url);
        </script>
    <?php endif; ?>

    
    <div class="row">

        <!-- Coluna esquerda -->
        <div class="col-md-3">

            <h4>Agente</h4>

            <a class="btn btn-primary w-100 mb-1"
                href="index.php?tipo=cadastro&cargo=ag&valida=true&sucesso">
                Cadastrar
            </a>

            <a class="btn btn-primary w-100 mb-1"
                href="index.php?tipo=desativacao&cargo=ag&valida=true&sucesso">
                Desativar
            </a>

            <a class="btn btn-primary w-100 mb-3"
                href="index.php?tipo=reativacao&cargo=ag&valida=true&sucesso">
                Ativar
            </a>

            <h4>Professor</h4>

            <a class="btn btn-info w-100 mb-1"
                href="index.php?tipo=cadastro&cargo=pf&valida=true&sucesso">
                Cadastrar
            </a>

            <a class="btn btn-info w-100 mb-1"
                href="index.php?tipo=desativacao&cargo=pf&valida=true&sucesso">
                Desativar
            </a>

            <a class="btn btn-info w-100 mb-3"
                href="index.php?tipo=reativacao&cargo=pf&valida=true&sucesso">
                Ativar
            </a>

            <h4>Solicitações</h4>
            <?php if($_GET['tipo'] == 'avalia'): ?>
                <a class="btn btn-dark w-100 mb-1"
                    href="index.php?tipo=historico&valida&sucesso">
                        Histórico de avaliações
                </a>
            <?php elseif($_GET['tipo'] == 'historico'): ?>

                <a class="btn btn-dark w-100 mb-1"
                    href="index.php?tipo=avalia&valida&sucesso">
                        Avaliar solicitações
                </a>
                
            <?php endif; ?>
            <!-- Espaço no final para não ficar feio -->
            <br><br> 
            
        </div>

        <!-- Coluna direita -->
        <div class="col-md-9 mt-2">

            <div class="border rounded p-3 h-100">

                <?php if($_GET['tipo'] == 'avalia'): ?>
                    <?php include 'formAvalia.php'; ?>
                <?php elseif($_GET['tipo'] == 'historico'): ?>
                    <?php include 'formHistorico.php'; ?>
                <?php endif; ?>
                
            </div>

        </div>

    </div>

</main>