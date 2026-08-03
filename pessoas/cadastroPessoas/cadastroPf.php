<?php

require '../vendor/autoload.php';

use App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();

$tipo = 'prof';
$mensagem = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Cadastro de Admin
    // Cadastra direto sem precisar de aprovação
    if ($validade == 1){

        if ($_POST['regime'] == 'TIDE'){
            $tide = 1;
        } else {
            $tide = 0;
        }

        $novaSenha = substr(md5(uniqid()), 0, 8); 

        $post = [
            // Identificador de tabela e tipo de Cadastro
            'tp_solicitacao' => 'cadastroAdmin',
            'tp_cadastro' => 'pf',
            // Quem cadastrou
            'idResponsavel' => $user['id'],
            // Dados que serão inseridos
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'titulacao' => $_POST['titulacao'],
            'lattes' => $_POST['lattes'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'ca_id' => '',
            'co_id' => $_POST['co'],
            'cat_func' => $_POST['categoria'],
            'rt' => $_POST['regime'],
            'tide' => $tide,
            'portaria' => $_POST['portaria'],
            'ano_letivo' => $_POST['ano'],
            'vinculo_remocao' => '',
            'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];
        require_once '../includes/funcoes/func_solicitaPessoas.php';
        $insert = insercaoPessoasAdmin($post);

        if($insert){
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=pf&valida".$true."&sucesso=2';
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=false';
                </script>
            ";
        }
    }
    // Cadastro de Coordenador
    else{
        $post = [
            'tp_solicitacao' => 'cadastro',
            'tp_cadastro' => 'pf',
            'id_solicitador' => $user['id'],
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'titulacao' => $_POST['titulacao'],
            'lattes' => $_POST['lattes'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'ca_id' => '',
            'co_id' => $_POST['co'],
            'cat_func' => $_POST['categoria'],
            'rt' => $_POST['regime'],
            'portaria' => $_POST['portaria'],
            'ano_letivo' => $_POST['ano'],
            'vinculo_remocao' => '',
        ];
        
        require_once '../includes/funcoes/func_solicitaPessoas.php';
        $insert = solicitacaoPessoas($post);

        if($insert){
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=pf&valida".$true."&sucesso=1';
                </script>
            ";
            exit;
        } else {
            echo "
                <script>
                    window.location.href = 'index.php?tipo=cadastro&cargo=ag&valida".$true."&sucesso=false';
                </script>
            ";
        }
    }
}

include 'includes/form.php';