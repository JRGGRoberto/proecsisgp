<?php

use App\Entity\Vinculo;



if ($tipo == 'ag'){
    $nome = 'Agentes';
    $pessoas = $agentes;

    $required = '';
}
elseif ($tipo == 'pf'){
    $nome = 'Professores';
    $pessoas = $professores;

    $required = 'required';
}

$alert ='';
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    $alert = '
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Solicitação realizada com sucesso!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
}
elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 2) {
    $alert = '
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Ação realizada com sucesso!
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

$adm='';
if ($_GET['valida'] == 'true' && $validade == 1){
    if($func == 'reativa'){
        $btnEnviar = 'Reativar';
    }elseif($func == 'desativa'){
        $btnEnviar = 'Desativar';
    }
    $adm = '[Administrador]';
}
else {
    if($func == 'reativa'){
        $btnEnviar = 'Solicitar reativação';
    }elseif($func == 'desativa'){
        $btnEnviar = 'Solicitar desativação';
    }
}


$htmlCatFunc = '
    <div class="form-group col-md-5">
        <label for="categoria">
            <strong class="text-primary">Categoria funcional:</strong>
        </label>

        <select id="categoria" name="categoria" class="form-control" required>
            <option value="" selected disabled> Selecione... </option>
            <option value="e" >Efetivo</option>
            <option value="c" >Temporário</option>
        </select>
    </div>
';

$htmlRT = '
    <div class="form-group col-md-5">
        <label for="regime">
            <strong class="text-primary">Regime de trabalho:</strong>
        </label>

        <select id="regime" name="regime" class="form-control" '.$required.'>
            <option value="" selected disabled> Selecione... </option>
            <option value="TIDE" >TIDE</option>
            <option value="40" >40</option>
            <option value="34" >34</option>
            <option value="28" >28</option>
            <option value="24" >24</option>
            <option value="20" >20</option>
            <option value="12" >12</option>
            <option value="10" >10</option>
            <option value="9" >9</option>
            <option value="8" >8</option>
        </select>
    </div>
';
?>

<main class="mt-4">

    <div class="form-row d-flex align-items-center mb-3">
        <h1 class="mb-0"><?=$btnEnviar.' '.$nome.' '.$adm?></h1>
        <button
            type="button"
            class="btn btn-primary btn-sm ml-auto"
            onclick="history.back()"
        >
            Voltar
        </button>
    </div>
    
    <?php if($validade != 1): ?>
    <p class="mb-4">
        <strong>As solicitações serão encaminhadas aos responsáveis para avaliação.</strong>
    </p>
    <?php endif; ?>

    <!-- Mensagem de Sucesso -->
    <div>
        <?php echo $alert ?>
    </div>
    <?php if (isset($_GET['sucesso'])): ?>
        <script>
            const url = new URL(window.location);
            url.search = url.search.replace('sucesso=1', 'sucesso');
            url.search = url.search.replace('sucesso=2', 'sucesso');
            url.search = url.search.replace('sucesso=false', 'sucesso');

            url.search = url.search.replace('salvo=true', '');
            window.history.replaceState({}, document.title, url);
        </script>
    <?php endif; ?>

    <!-- ////////////////////////////// COLOCAR AQUI O FILTRO ////////////////////////////////////// -->
     
    <?php 
        if ($validade == 1){
            require_once './filtro.php';
            $exibirFiltro = exibirFiltro($_GET['cargo']);
            echo $exibirFiltro;
        }
    ?>

    <?php if(!$pessoas): ?>
        <div class="alert alert-info text-center">
            Não há pessoas aqui!
        </div>
    <?php endif; ?>

    <?php foreach ($pessoas as $pessoa): ?>
    <!-- Card Solicitação -->
    <div class="card shadow mb-2 border-2">
        <div class="card-body">
                
            <form class="row mb-1" method="POST">

                <!-- Lado esquerdo -->
                <div class="col-md-9">

                    <!-- Primeira linha -->
                    <div class="form-row mb-3">
                        <div class="col-md-4">
                            <strong class="text-primary">Nome:</strong>
                            <?= $pessoa->nome ?>
                        </div>

                        <div class="col-md-5">
                            <strong class="text-primary">E-mail:</strong>
                            <?= $pessoa->email ?>
                        </div>

                        <div class="col-md-3">
                            <strong class="text-primary">Tipo de cargo:</strong>
                            <?php 
                                require_once '../includes/funcoes/func_mudaAbreviacao.php';
                                echo mudaAbreviacaoCatFunc($pessoa->cat_func);
                            ?>
                        </div>
                    </div>
    
                    <!-- Segunda linha para reativação -->
                    <?php if($_GET['tipo'] == 'reativacao' && !in_array($pessoa->id, $listPessoa)): ?>
                        <div class="form-row">
                            <?php 
                                $pessoa->cat_func = ''; // Para garantir que escolha um cat_func
                                echo $htmlCatFunc;
                                if ($_GET['cargo'] != 'ag'){
                                    echo $htmlRT;
                                }
                            ?>
                            <input type="hidden" name="solicitacao_ReativaPessoa" value="<?= $pessoa->id ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Segunda linha para desativação -->
                    <?php if($_GET['tipo'] == 'desativacao' && !in_array($pessoa->id, $listPessoa)): ?>
                        <div class="form-row">
                            <?php 
                                $anos=null;

                                // desativação de professores
                                if($_GET['cargo'] == 'pf'){ 
                                    $vinculos = Vinculo::gets('id_prof = "'.$pessoa->id.'" and ano >= "'.date('Y').'" ');
                                    foreach ($vinculos as $vlr => $vinculo){
                                        $newAno[] = $vinculo->ano;
                                        $anos = $newAno;
                                    }
                                    $newAno = null;
                                    // 
                                    if ($anos) {
                                        $htmlVinc = '<div class="form-group col-md-12">
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            <label class="mb-0 mr-3">
                                                                Selecionar o vínculo que deseja remover:
                                                            </label>';

                                        foreach ($anos as $ano) {
                                            $htmlVinc .= '<div class="mr-2">
                                                            <label class="card-opcao mb-0">
                                                                <input type="radio" name="ano" value="' . $ano . '" required>
                                                                <span class="indicador"></span>
                                                                <span class="numero">' . $ano . '</span>
                                                            </label>
                                                        </div>';
                                        }

                                        $htmlVinc .= '   </div>
                                                    </div>';

                                        echo $htmlVinc;
                                    } 
                                    else {
                                        echo '<label class="mb-0 mr-3">
                                            Não há vínculos no ano de '.date('Y').' ou em anos posteriores!
                                        </label>';
                                    }
                                }

                            ?>
                            <input type="hidden" name="solicitacao_DesativaPessoa" value="<?= $pessoa->id ?>">
                        </div>
                    <?php endif; ?>
                    
                </div>

                <!-- Lado direito -->
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    
                    <?php if (in_array($pessoa->id, $listPessoa)): ?>
                        <?php if ($_GET['valida']=='true'): ?>
                            <button disabled class="btn btn-warning" style="width: 170px;">
                                Já solicitado
                            </button>
                        <?php else: ?>
                            <button type="submit" name="remover_solicitacao" value="<?=$pessoa->id;?>" class="btn btn-warning" style="width: 170px;">
                                Remover solicitação
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button type="submit" class="btn btn-danger" style="width: 170px;">
                            <?= $btnEnviar ?>
                        </button>
                    <?php endif; ?>

                </div>

            </form>

        </div>
    </div>
    
    <?php 
    endforeach; 
    
    include_once '../includes/paginacao.php';
    echo $paginacao;    
    ?>
    <br>
</main>
    