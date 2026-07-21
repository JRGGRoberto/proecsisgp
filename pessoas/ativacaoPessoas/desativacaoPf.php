<?php

require '../vendor/autoload.php';

use App\Entity\Professor;
use App\Entity\Solicita_Pessoas;
use App\Entity\Vinculo;
use App\Db\Pagination;
use App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($validade == 1){  // SE FOR ADMIN  
        if (array_key_exists('solicitacao_DesativaPessoa', $_POST)) { // Verifica se foi informado um ID de um Prof

            $where = 'id = "'.$_POST['solicitacao_DesativaPessoa'].'"';
            $prof = Professor::getProfessores($where);

            // Aqui é para fazer a remoção de professores se tiver vinculo
            if(isset($_POST['ano'])){
                // $vinculo_remocao = new Vinculo;
                $vinculo_remocao = Vinculo::getByAnoProf($prof[0]->id, $_POST['ano']);

                if($_SERVER['HTTP_HOST'] == 'sistemaproec.unespar.edu.br'){  // Para produção
                    $baseUrl = 'https://'.$_SERVER['HTTP_HOST']; 
                } 
                else{ // Para Localhost
                    $baseUrl = 'http://'.$_SERVER['HTTP_HOST']; 
                } 

                echo "
                    <script>
                    fetch('{$baseUrl}/epad/padstopdf/indexHtml.php?id={$vinculo_remocao->id}')
                        .then(r => r.json())
                        .then(epadResponse => {
                            if (epadResponse.status === 'ok') {

                                window.open(epadResponse.url, '_blank');

                                return fetch('../api/remocao_vinculoPf.php?vinculo_id={$vinculo_remocao->id}&prof_id={$prof[0]->id}');
                            }

                            throw new Error();
                        })
                        .then(r => r.json())
                        .then(apiResponse => {
                            if (apiResponse.status === 'ok') {
                                window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=2';
                            } else {
                                window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false';
                            }
                        })
                        .catch(() => {
                            window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=false';
                        });
                    </script>
                ";

            } 
            // Aqui é para fazer a remoção de professores se não tiver vinculo
            else {
                $prof[0]->ativo = 0;
                if($prof[0]->atualizarAtivo()){
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
                $vinculo_remocao = $_POST['ano'].'_'.date('m').'_'.$pessoa_requisicao[0]->id;
                $ano = $_POST['ano'];
            }else{
                $vinculo_remocao = '';
                $ano = date('Y');
            }

            $post = [
                'tp_solicitacao' => 'desativacao',
                'tp_cadastro' => 'pf',
                'id_solicitador' => $user['id'],
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
                'ano_letivo' => $ano,
                'rt' => '',
                'portaria' => '',
                'vinculo_remocao' => $vinculo_remocao,
            ];

            require_once '../includes/funcoes/func_solicitaPessoas.php';
            $insert = solicitacaoPessoas($post);

            if($insert){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=1'
                    </script>
                ";
                exit;
            }

        }
        elseif (array_key_exists('remover_solicitacao', $_POST)) {
            // Aqui é para a desativação da solicitação
            require_once '../includes/funcoes/func_solicitaPessoas.php';

            $IdP = $_POST['remover_solicitacao'];
            $remove = removeSolicitacao($IdP);

            if($remove){
                echo "
                    <script>
                        window.location.href = 'index.php?tipo=desativacao&cargo=pf&valida".$true."&sucesso=1'
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