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
<!-- Card Solicitação -->
<div class="card shadow mb-2">
    <div class="card-body">

        <div class="row align-items-center">

            <?php $valueCard++; ?>

            <div class="col-md-5">
                <strong class="text-primary">Nome:</strong><br>
                <?= $pessoa->nome ?>
            </div>

            <div class="col-md-3">
                <strong class="text-primary">Tipo:</strong><br>
                <?php
                    require_once '../includes/funcoes/func_mudaAbreviacao.php';
                    echo tipoSolicitacao($pessoa->tp_solicitacao);
                ?>
            </div>

            <div class="col-md-2">
                <strong class="text-primary">Resultado:</strong><br>

                <?php
                    $classe = "secondary";
                    if($pessoa->resultado == "a") $classe = "success";
                    elseif($pessoa->resultado == "r") $classe = "danger";
                ?>

                <span class="badge badge-<?= $classe ?>">
                    <?= mudaAbreviacaoAprovacao($pessoa->resultado); ?>
                </span>
            </div>

            <div class="col-md-2 text-right">
                <button class="btn btn-info btn-sm"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseDados<?=$valueCard?>"
                        aria-expanded="false">

                    <i class="fas fa-info-circle"></i> Infos
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

        </div>

    </div>
</div>

<?php 
endforeach; 

    include_once '../includes/paginacao.php';
    echo $paginacao;    
?>    