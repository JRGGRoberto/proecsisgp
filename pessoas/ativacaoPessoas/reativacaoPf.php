<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Professor;
use App\Entity\Solicita_Pessoas;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if ($validade == 1){ // PARA ADMINISTRADOR
        if (array_key_exists('solicitacao_ReativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Professor

            $wherePessoa = 'id = "'.$_POST['solicitacao_ReativaPessoa'].'"';
            $pessoa_requisicao = Professor::getProfessores($wherePessoa);
            $pessoa_requisicao[0]->ativo = 1;

            // Para garantir que tenha um email para acessar e esteja em um colegiado
            if(!$pessoa_requisicao[0]->email || !$pessoa_requisicao[0]->id_colegiado){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

            if ($_POST['regime'] == 'TIDE'){
                $tide = 1;
            } else {
                $tide = 0;
            }

            $pessoa_requisicao[0]->cat_func = $_POST['categoria'];

            $post = [  // O que vai para a tabela Vínculo
                'ano' => date('Y'), // ANO ATUAL
                'rt' => $_POST['regime'], // PEGAR REGIME POR POST
                'tide' => $tide,
                'id_prof' => $pessoa_requisicao[0]->id,
                'user' => $user['id'],
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            $insert = reativacaoPessoasAdmin($post);

            if($pessoa_requisicao[0]->atualizarAtivo() && $pessoa_requisicao[0]->atualizarCatFunc() && $insert){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=2'
                    </script>
                ";
                exit;
            }
        }
    }
    else { // QUANDO É FEITO POR UM COORDENADOR
        if (array_key_exists('solicitacao_ReativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Professor

            $wherePessoa = 'id = "'.$_POST['solicitacao_ReativaPessoa'].'"'; 
            $pessoa_requisicao = Professor::getProfessores($wherePessoa);

            // Para garantir que tenha um email para acessar e esteja em um colegiado
            if(!$pessoa_requisicao[0]->email || !$pessoa_requisicao[0]->id_colegiado){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

            if(!$pessoa_requisicao[0]->titulacao){
                $titulacao = 'n/a';
            } else {
                $titulacao = $pessoa_requisicao[0]->titulacao;
            }

            $post = [
                'tp_solicitacao' => 'reativacao',
                'tp_cadastro' => 'pf',
                'id_solicitador' => $user['id'],
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => $titulacao,
                'lattes' => $pessoa_requisicao[0]->lattes,
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => '',
                'co_id' => $pessoa_requisicao[0]->id_colegiado,
                'cat_func' => $_POST['categoria'],
                'ano_letivo' => date('Y'),
                'rt' => $_POST['regime'],
                'portaria' => '',
                'vinculo_remocao' => '',
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            $insert = solicitacaoPessoas($post);

            if($insert){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }

        }
        elseif (array_key_exists('remover_solicitacao', $_POST)) {
            // Aqui é para a desativação de pessoas
            require_once '../includes/funcoes/func_solicitaPessoas.php';

            $IdP = $_POST['remover_solicitacao'];
            $remove = removeSolicitacao($IdP);

            if($remove){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
        }
    }

}

require_once './func_exibirSolicitacao.php';
$listPessoa = listaPessoas('reativacao');

// Alterar para quando a $validade == 1 ele ver todos os professores 
$tipo = 'pf';
$func = 'reativa';

// Query baseada em filtros
// Lotação
$qryLotacao = null;
if (isset($_GET['fId']) && is_array($_GET['fId'])) {
    $idColegiados = [];

    // Limpa a string de ID de alguns injections
    foreach ($_GET['fId'] as $id) {
        $id = trim($id);
        if (!preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $id)) {
            continue;
        }
        $idColegiados[] = $id;
    }

    if (!empty($idColegiados)) {
        $total = count($idColegiados);
        $i = 0;

        foreach ($idColegiados as $ids) {
            $i++;
            $qryLotacao .= 'id_colegiado = "'.$ids.'"';
            if ($i < $total) {
                $qryLotacao .= ' OR ';
            }
        }
        $qryLotacao = ' AND (' . $qryLotacao . ')';
    }
}
//Nome
$qryNome = null;
if (isset($_GET['fNome'])) {
    $fNome = trim($_GET['fNome']);
    if (preg_match('/^[\p{L}\s]+$/u', $fNome)) {
        $fNome = addslashes($fNome);
        $qryNome = ' AND nome LIKE "%' . $fNome . '%"';
    }
}

if ($validade == 1) {
    $where = 'ativo = "0"'.$qryLotacao.$qryNome;
} else {
    $caId = preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $user['co_id']) ? $user['co_id'] : '';
    $where = 'id_colegiado = "'.$caId.'" AND ativo = "0"';
}


// Para usar a paginação
$professoresCount = Professor::getQntdProfessores($where);
$obPagination = new Pagination($professoresCount, $_GET['pagina'] ?? 1, 6);

$professores = Professor::getProfessores($where, null, $obPagination->getLimite());
include 'includes/form.php';
?>