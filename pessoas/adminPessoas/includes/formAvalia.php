<?php

use App\Entity\Professor;

function solicitador($id_solicitador){
    $pessoa = (object) Professor::getProfessor($id_solicitador);
    return $pessoa->nome;
}

$valueCard = null;
?>

<?php if(!$solicitacao_pessoas): ?>
    <div class="alert alert-info text-center">
        Não há pessoas aqui!
    </div>
<?php endif; ?>

<?php foreach ($solicitacao_pessoas as $pessoa): ?>
<!-- Card Solicitação -->
<div class="card shadow mb-2">
    <div class="card-body">
                
        <form class="row align-items-center" method="POST">

            <?php $valueCard = $valueCard+1; ?>

            <div class="col-md-6">
                <strong class="text-primary">Nome:</strong>
                <?= $pessoa->nome ?>
            </div>

            <div class="col-md-3">
                <strong class="text-primary">Tipo:</strong>
                <?php
                    require_once '../includes/funcoes/func_mudaAbreviacao.php';
                    echo tipoSolicitacao($pessoa->tp_solicitacao);
                ?>
            </div>

            <div class="col-md-1 pl-0 pr-1">
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseDados<?=$valueCard?>" aria-expanded="false" aria-controls="collapseDados<?=$valueCard?>">
                    Infos
                </button>
                
            </div>

            <div class="col-md-1 pl-0 pr-0 d-flex align-items-center justify-content-center">
                <button type="submit" name="resultado" value="a" class="btn btn-light shadow">
                    ✅
                </button>
            </div>
            <div class="col-md-1 pl-0 pr-0 d-flex align-items-center justify-content-center">
                <button type="submit" name="resultado" value="r" class="btn btn-light shadow">
                    🚫
                </button>
            </div>

            <div class="collapse mt-2 col-md-12" id="collapseDados<?=$valueCard?>">
                <div class="card card-body">
                    <div class="form-row">
                        <!-- Linha 1 -->
                        <div class="col-md-6 mb-1">
                            <strong class="text-primary">E-mail:</strong>
                            <?= $pessoa->email ?>
                        </div>
                        <div class="col-md-6 mb-1">
                            <strong class="text-primary">Cargo:</strong>
                            <?php
                                require_once '../includes/funcoes/func_mudaAbreviacao.php';
                                echo tipoCargos($pessoa->tp_cadastro);
                            ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Linha 2 -->
                        <div class="col-md-6">
                            <strong class="text-primary">Categoria funcional:</strong>
                            <?php
                                require_once '../includes/funcoes/func_mudaAbreviacao.php';
                                echo mudaAbreviacaoCatFunc($pessoa->cat_func);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <strong class="text-primary">Solicitante:</strong>
                            <?= solicitador($pessoa->id_solicitador) ?>
                        </div>
                    </div>
                </div>
            </div>


            <input type="hidden" name="solicitacao_pessoa" value="<?= $pessoa->id ?>">
        </form>

    </div>
</div>

<?php 
endforeach; 

    include_once '../includes/paginacao.php';
    echo $paginacao;    
?>    