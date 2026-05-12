<?php

$keys = [];
echo $_SERVER['DOCUMENT_ROOT'].'/sistema/.env';

$linhas = file('/.env');
if (file_exists($linhas)) {
    foreach ($linhas as $linha) {
        if (strlen($linha) > 1) {
            $keyValue = explode('=', $linha);
            $keys = array_merge($keys, [$keyValue[0] => $keyValue[1]]);
        }
    }
} else {
    echo 'O arquivo '.$linhas.' não foi encontrado.';
    exit;
}
