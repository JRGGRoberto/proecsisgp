<?php

require '../vendor/autoload.php';

use App\Entity\Professor;
use App\Entity\Vinculo;
use App\Db\Pagination;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($validade == 1){  // SE FOR ADMIN  
        if (array_key_exists('solicitacao_DesativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Prof

            $where = 'id = "'.$_POST['solicitacao_DesativaPessoa'].'"';
            $pessoa_requisicao = Professor::getProfessores($where);  // Valida que o ID é de um professor

            // Aqui é para fazer a remoção de professores se tiver vinculo
            if(isset($_POST['ano'])){
                $vinculo_remocao = Vinculo::getByAnoProf($pessoa_requisicao[0]->id, $_POST['ano']);

                require_once '../includes/funcoes/func_conexaoEpad.php';
                if(conexaoEpad($user['id'], $pessoa_requisicao[0]->id, $vinculo_remocao->id, $v=false)){
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=2'
                        </script>
                    ";
                    exit;
                } else {
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false'
                        </script>
                    ";
                    exit;
                }

            } 
            // Aqui é para fazer a remoção de professores se não tiver vinculo
            else {
                $pessoa_requisicao[0]->ativo = 0;
                if($pessoa_requisicao[0]->atualizarAtivo()){
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=2'
                        </script>
                    ";
                    exit;
                } else {
                    echo "
                        <script>
                            window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false'
                        </script>
                    ";
                    exit;
                }
            }
        }
    }
    else { // SE FOR COORDENADOR
        if (array_key_exists('solicitacao_DesativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Prof
            // Aqui é para a inserção de pessoas
            $wherePessoa = 'id = "'.$_POST['solicitacao_DesativaPessoa'].'"'; 
            $pessoa_requisicao = Professor::getProfessores($wherePessoa);

            if(isset($_POST['ano'])){
                // $vinculo_remocao = $_POST['ano'].'_'.date('m').'_'.$pessoa_requisicao[0]->id;
                $vinculo_remocao = date('Y_m_d_').$pessoa_requisicao[0]->id;
                $ano = $_POST['ano'];
            }else{
                $vinculo_remocao = '';
                $ano = date('Y');
            }

            $post = [
                'tp_solicitacao' => 'desativacao',
                'tp_cadastro' => 'pf',
                'id_solicitador' => $user['id'],
                'id_avaliador' => null,
                'resultado' => null,
                'id_pessoa' => $pessoa_requisicao[0]->id,
                'nome' => $pessoa_requisicao[0]->nome,
                'cpf' => $pessoa_requisicao[0]->cpf,
                'titulacao' => $pessoa_requisicao[0]->titulacao,
                'lattes' => $pessoa_requisicao[0]->lattes,
                'email' => $pessoa_requisicao[0]->email,
                'telefone' => $pessoa_requisicao[0]->telefone,
                'ca_id' => '',
                'co_id' => $pessoa_requisicao[0]->id_colegiado,
                'cat_func' => $pessoa_requisicao[0]->cat_func,
                'rt' => '',
                'portaria' => '',
                'ano_letivo' => $ano,
                'vinculo_remocao' => $vinculo_remocao,
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            if(solicitacaoPessoas($post)){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
            else {
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }

        }
        elseif (array_key_exists('remover_solicitacao', $_POST)) {
            // Aqui é para a desativação da solicitação
            require_once '../includes/funcoes/func_solicitaPessoas.php';
            if(removeSolicitacao($_POST['remover_solicitacao'])){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }
            else {
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false'
                    </script>
                ";
                exit;
            }
        }
    }

}

require_once './func_exibirSolicitacao.php';
$listPessoa = listaPessoas('desativacao');

// Alterar para quando a $validade == 1 ele ver todos os professores 
$tipo = 'pf';
$func = 'desativa';

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
    $where = 'ativo = "1"'.$qryLotacao.$qryNome;
} else {
    $caId = preg_match('/^(?!.*--)[A-Za-z0-9-]+$/', $user['co_id']) ? $user['co_id'] : '';
    $where = 'id_colegiado = "'.$caId.'" AND ativo = "1"';
}

// Para usar a paginação
$professoresCount = Professor::getQntdProfessores($where);
$obPagination = new Pagination($professoresCount, $_GET['pagina'] ?? 1, 6);

$professores = Professor::getProfessores($where, null, $obPagination->getLimite());
include 'includes/form.php';

?>