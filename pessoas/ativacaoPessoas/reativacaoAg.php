<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Agente;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($validade == 1){ // PARA ADMINISTRADOR
        if (array_key_exists('solicitacao_ReativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Agente

            $where = 'id = "'.$_POST['solicitacao_ReativaPessoa'].'"';
            $pessoa_requisicao = Agente::gets($where);
            $pessoa_requisicao[0]->ativo = 1;
            $pessoa_requisicao[0]->cat_func = $_POST['categoria'];

            $post = [
                'tp_solicitacao' => 'reativacaoAdmin',
                'tp_cadastro' => 'ag',
                'id_solicitador' => $user['id'],
                'id_avaliador' => $user['id'],
                'resultado' => 'a',
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => 'n/a',
                'lattes' => '',
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => $pessoa_requisicao[0]->lotacao,
                'co_id' => '',
                'cat_func' => $_POST['categoria'],
                'rt' => '',
                'portaria' => '',
                'ano_letivo' => date('Y'),
                'vinculo_remocao' => '',
                'tide' => '',
            ];

            // Para garantir que tenha um email para acessar e esteja em um campus
            if(!$pessoa_requisicao[0]->email || !$pessoa_requisicao[0]->lotacao){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            if($pessoa_requisicao[0]->atualizarAtivo() && $pessoa_requisicao[0]->atualizarCatFunc() && solicitacaoPessoas($post)){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=ag&valida".$true."&sucesso=2'
                    </script>
                ";
                exit;
            }
            else {
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }
        }
    }
    else { // QUANDO É FEITO POR DEC
        if (array_key_exists('solicitacao_ReativaPessoa', $_POST)) {  // Verifica se foi informado um ID de um Agente

            $wherePessoa = 'id = "'.$_POST['solicitacao_ReativaPessoa'].'"'; 
            $pessoa_requisicao = Agente::gets($wherePessoa);

            // Para garantir que tenha um email para acessar e esteja em um campus
            if(!$pessoa_requisicao[0]->email || !$pessoa_requisicao[0]->lotacao){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

            $post = [
                'tp_solicitacao' => 'reativacao',
                'tp_cadastro' => 'ag',
                'id_solicitador' => $user['id'],
                'id_avaliador' => null,
                'resultado' => null,
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => 'n/a',
                'lattes' => '',
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => $pessoa_requisicao[0]->lotacao,
                'co_id' => '',
                'cat_func' => $_POST['categoria'],
                'rt' => '',
                'portaria' => '',
                'ano_letivo' => date('Y'),
                'vinculo_remocao' => '',
                'tide' => '',
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            if(solicitacaoPessoas($post)){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=ag&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
            else {
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

        }
        // Retira da tabela tb_solicita_pessoa
        elseif (array_key_exists('remover_solicitacao', $_POST)) {
            // Aqui é para a desativação de pessoas
            require_once '../includes/funcoes/func_solicitaPessoas.php';

            $IdP = $_POST['remover_solicitacao'];
            if(removeSolicitacao($IdP)){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=ag&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
            else {
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=reativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }
        }
    }
}

require_once './func_exibirSolicitacao.php';
$listPessoa = listaPessoas('reativacao');

$tipo = 'ag';
$func = 'reativa';

// Query baseada em filtros
// Lotação
$qryLotacao = null;
if (isset($_GET['fId']) && is_array($_GET['fId'])) {
    $idCampus = [];

    // Limpa a string de ID de alguns injections
    foreach ($_GET['fId'] as $id) {
        $id = trim($id);
        if (!preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $id)) {
            continue;
        }
        $idCampus[] = $id;
    }

    if (!empty($idCampus)) {
        $total = count($idCampus);
        $i = 0;

        foreach ($idCampus as $ids) {
            $i++;
            $qryLotacao .= 'lotacao = "'.$ids.'"';
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
    $caId = preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $user['ca_id']) ? $user['ca_id'] : '';
    $where = 'lotacao = "'.$caId.'" AND ativo = "0"';
}

// Para usar a paginação
$agentesCount = Agente::getQntd($where);
$obPagination = new Pagination($agentesCount, $_GET['pagina'] ?? 1, 6);

$agentes = Agente::gets($where, null, $obPagination->getLimite());
include 'includes/form.php';
?>