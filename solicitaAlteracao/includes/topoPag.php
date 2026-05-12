<?php

function topo(){
    if ($_GET['tipo'] == 'atualizar'){
        $newPage = 'atualizados';
        $textoTopo = 'Solicitações de alteração de propostas';
        $textoBotao = 'Ir para projetos atualizados';
    } elseif ($_GET['tipo'] == 'atualizados'){
        $newPage = 'atualizar';
        $textoTopo = 'Histórico de alteração de propostas';
        $textoBotao = 'Ir para atualizar projetos';
    }
    
    $valTopo = '
    <div class="d-flex align-items-stretch">
        <!-- Esquerda -->
        <div class="d-flex flex-column gap-3 pe-3" style="flex: 3;">
            <h2 class="mb-4">'.$textoTopo.'</h2>
        </div>

        <!-- Direita -->
        <div class="d-flex justify-content-center align-items-center ps-3" style="flex: 1;">
            <a class="btn btn-secondary mb-1" 
                href="../solicitaAlteracao/index.php?tipo='.$newPage.'&solicita='.$_GET['solicita'].'&idLocal='.$_GET['idLocal'].'"
            >
                '.$textoBotao.'
            </a>
        </div>
        
    </div>';

    return $valTopo;
}

?>


