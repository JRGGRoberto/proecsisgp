<?php

// $diretorio_destino = '/home/sistemaproec/www/sistema/upload/uploads/'; // Certifique-se de que esta pasta exista e tenha permissões de escrita
$diretorio_destino = 'C:/Users/Roberto/Dev/dockersist/www/php7/proecsisgp/upload/uploads/'; // Certifique-se de que esta pasta exista e tenha permissões de escrita
$nome_arquivo = $_FILES['arquivo']['name'];
$caminho_temporario = $_FILES['arquivo']['tmp_name'];
$caminho_destino = $diretorio_destino.$nome_arquivo;

echo '<hr>';
echo $diretorio_destino.'<br>';
echo $nome_arquivo.'<br>';
echo $caminho_temporario.'<br>';
echo $caminho_destino.'<br>';
echo '<hr>';

echo '<pre>';
print_r($_FILES);
echo '<hr>';
print_r($_POST);
echo '</pre>';

if (move_uploaded_file($caminho_temporario, $caminho_destino)) {
    echo 'Arquivo enviado com sucesso para: '.$caminho_destino;
} else {
    echo 'Erro ao enviar o arquivo.';
}
