<?php

require '../vendor/autoload.php';

function mailRecuperarSenha($destinatario, $nome, $idref, $novaSenha) {

    $tipo = 11;

    $assunto = 'Recuperação de senha';
    $mensagem = '
        <div style="font-family: Arial, sans-serif; color:#333;">
            <h3>Recuperação de senha</h3>

            <p>Olá <strong>'.$nome.'</strong>,</p>
            <p>Segue sua nova senha:</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                <tr>
                    <td align="center">
                        <div style="
                            display:inline-block;
                            background-color:#1e73be;
                            color:#ffffff;
                            padding:20px 40px;
                            font-size:28px;
                            font-weight:bold;
                            border-radius:8px;
                        ">'.$novaSenha.'</div>
                    </td>
                </tr>
            </table>

            <p style="text-align:center;">
                Recomendamos que você altere essa senha após o login.
            </p>

            <br>
            <small>Este e-mail é automático.</small>
        </div>
    ';

    $dados = [
        'tipo' => $tipo,
        'idref' => $idref,
        'destinatario' => $destinatario,
        'nome' => $nome,
        'assunto' => $assunto,
        'mensagem' => $mensagem,
    ];

    return $dados;
}