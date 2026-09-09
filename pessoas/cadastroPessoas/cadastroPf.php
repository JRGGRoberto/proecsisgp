<?php

require '../vendor/autoload.php';

use App\Entity\UuiuD;
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
            'tp_solicitacao' => 'cadastroAdmin',
            'tp_cadastro' => 'pf',
            'id_solicitador' => $user['id'],
            'id_avaliador' => $user['id'],
            'resultado' => 'a',
            'id_pessoa' => UuiuD::gera(),
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
            'tide' => $tide,
            'senha' => password_hash($novaSenha,PASSWORD_DEFAULT)
        ];

        require_once '../includes/funcoes/func_solicitaPessoas.php';
        if(solicitacaoPessoas($post, $novaSenha)){
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
            exit;
        }
    }
    // Cadastro de Coordenador
    else{
        $post = [
            'tp_solicitacao' => 'cadastro',
            'tp_cadastro' => 'pf',
            'id_solicitador' => $user['id'],
            'id_avaliador' => null,
            'resultado' => null,
            'id_pessoa' => UuiuD::gera(),
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
            'vinculo_remocao' => '',
            'ano_letivo' => $_POST['ano'],
            'tide' => $tide,
        ];
        
        require_once '../includes/funcoes/func_solicitaPessoas.php';
        if(solicitacaoPessoas($post)){
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
            exit;
        }
    }
}

include 'includes/form.php';