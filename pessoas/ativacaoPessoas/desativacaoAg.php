<?php

require '../vendor/autoload.php';

use App\Db\Pagination;
use App\Entity\Agente;
use App\Entity\Solicita_Pessoas;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($validade == 1){  // SE FOR ADMIN
        if (array_key_exists('solicitacao_DesativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Prof

            $where = 'id = "'.$_POST['solicitacao_DesativaPessoa'].'"';
            $agnt = Agente::gets($where);
            $agnt[0]->ativo = 0;
            
            if($agnt[0]->atualizarAtivo()){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=ag&valida".$true."&sucesso=2'
                    </script>
                ";
                exit;
            }
  
        }
    }
    else {  // SE FOR DEC
        // Coloca na tabela tb_solicita_pessoa
        if (array_key_exists('solicitacao_DesativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Prof
            // Aqui é para a inserção de pessoas
            $wherePessoa = 'id = "'.$_POST['solicitacao_DesativaPessoa'].'"'; 
            $pessoa_requisicao = Agente::gets($wherePessoa);

            $post = [
                'tp_solicitacao' => 'desativacao',
                'tp_cadastro' => 'ag',
                'id_solicitador' => $user['id'],
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => 'n/a',
                'lattes' => '',
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => $pessoa_requisicao[0]->lotacao,
                'co_id' => '',
                'cat_func' => $pessoa_requisicao[0]->cat_func,
                'ano_letivo' => date('Y'),
                'rt' => '',
                'portaria' => '',
                'vinculo_remocao' => '',
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            $insert = solicitacaoPessoas($post);

            if($insert){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=ag&valida".$true."&sucesso=1'
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
            $remove = removeSolicitacao($IdP);

            if($remove){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=ag&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
        }
    }
}

require_once './func_exibirSolicitacao.php';
$listPessoa = listaPessoas('desativacao');

$tipo = 'ag';
$func = 'desativa';

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
    $where = 'ativo = "1"'.$qryLotacao.$qryNome;
} else {
    $caId = preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $user['ca_id']) ? $user['ca_id'] : '';
    $where = 'lotacao = "'.$caId.'" AND ativo = "1"';
}

// Para usar a paginação
$agentesCount = Agente::getQntd($where);
$obPagination = new Pagination($agentesCount, $_GET['pagina'] ?? 1, 6);

$agentes = Agente::gets($where, null, $obPagination->getLimite());
include 'includes/form.php';
?>