<?php

namespace App\Entity;

// require '../../vendor/autoload.php';

use App\Db\Database;
use App\Db\LerDot;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once '../includes/funcoes/func_mudaAbreviacao.php';

class EmailService
{
    public $id;
    public $destinatario;
    public $nome;
    public $sistema;  // sistema / epad / futuro
    public $tipo;  // cadastro de proposta / aprovação / reprovação
    public $idref;
    public $status;  // enviado / pendente / falha
    public $assunto;
    public $mensagem;
    public $created_at;
    public $user;
    public $url;

    /**
     * Método responsável por cadastrar um novo Registro no banco.
     *
     * @return bool
     */
    private function cadastrarDB($dados)
    {
        $obDatabase = new Database('mailsmsgs');
        $this->id = $obDatabase->insert([
            'destinatario' => $dados['destinatario'],
            'nome' => $dados['nome'],
            'sistema' => $this->sistema,
            'tipo' => $dados['tipo'],
            'idref' => $dados['idref'],
            'status' => $this->status,
            'assunto' => $dados['assunto'],
            'mensagem' => $dados['mensagem'],
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    private function validaDestinatario()
    {
        $env = new LerDot();
        if (Database::NAME != $env::get('NAMEPROD')) {
            $destinatario = $env::get('MAILTESTER');

            return $destinatario;
        }
    }

    private function definirBaseUrl()
    {
        $env = new LerDot();
        if (Database::NAME != $env::get('NAMEPROD')) {
            $this->url = $env::get('URLDEV');
        } else {
            $this->url = $env::get('URLPROD');
        }
    }

    private function validarSistema()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $partes = explode('/', trim($uri, '/'));
        $this->sistema = $partes[0];
    }

    private function sendMail($destinatario, $nome, $assunto, $mensagem)
    {
        $mail = new PHPMailer(true);

        try {
            $env = new LerDot();
            $mail->isSMTP();
            $mail->Host = $env::get('HOSTMAIL');
            $mail->SMTPAuth = true;
            $mail->Username = $env::get('MAILUSERNAME');
            $mail->Password = $env::get('MAILPASSWD');
            $mail->Port = $env::get('MAILPORT');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // define para inserir html
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // remetente
            $mail->setFrom($mail->Username, 'Sistema PROEC');

            $mail->addAddress($destinatario, $nome);
            $mail->Subject = $assunto;

            // email
            $mail->Body = $mensagem;

            return $mail->send();
        }catch (Exception $e){
            return false;
        }
    }


    public function enviar($dados){
        $this->definirBaseUrl();
        $this->validarSistema();

        $destinatario = $this->validaDestinatario();

        if ($destinatario){
            $dados['destinatario'] = $destinatario;
        }

        $enviado = 0;
        $this->tipo = $dados['tipo'];
        $this->status = $this->sendMail(
            $this->destinatario = $dados['destinatario'], 
            $this->nome = $dados['nome'], 
            $this->assunto = $dados['assunto'], 
            $this->mensagem = $dados['mensagem']
        ) ? 1 : 0;
        $this->status = $enviado ? 1 : 0;
        $arrEnviados[] = $enviado;

        $this->cadastrarDB($dados);

        return $arrEnviados;
    }

    // --------------------------------------------------------------------------------
    
    public function cadastrarProposta($projeto, $user)
    {
        require_once '../includes/mailBody/mailCadastrarProposta.php';
        $dados = mailCadastrarProposta($projeto, $user);

        $this->enviar($dados);
    }

    // --------------------------------------------------------------------------------

    public function avaliacaoProposta($projeto, $resultado)
    {   
        require_once '../includes/mailBody/mailAvaliacaoProposta.php';
        $dados = mailAvaliacaoProposta($projeto, $resultado);

        $insert = [
            'tipo' => $dados['tipo'],
            'idref' => $dados['idref']
        ];

        if ($dados['avaliador']){
            $dadosAvaliador = array_merge($insert,$dados['avaliador']);
            $this->enviar($dadosAvaliador);
        }

        if ($dados['autor']){
            $dadosAutor = array_merge($insert,$dados['autor']);
            $this->enviar($dadosAutor);
        } 

        if (!$dados['autor'] || !$dados['avaliador']){
            $this->enviar($dados);
        }
    }

    // --------------------------------------------------------------------------------

    public function recuperarSenha($email, $nome, $idref, $novaSenha)
    {

        require_once '../includes/mailBody/mailRecuperarSenha.php';
        $dados = mailRecuperarSenha($email, $nome, $idref, $novaSenha);

        $this->enviar($dados);

    }

    // --------------------------------------------------------------------------------

    // $idSolicitacao é o ID do projeto que está sendo enviado, para modificar é em enviaAlteracao.php
    public function solicitacaoAlteracaoPropostas($idSolicitacao, $userEmail, $userNome)
    {
        if (empty($idSolicitacao)) {
            // throw new Exception("ID da solicitação não informado para envio de email");
            throw new Exception('Solicitação de alteração não encontrada!');
        }

        require_once '../includes/mailBody/mailSolicitacaoAlteracaoProposta.php';
        $dados = mailSolicitacaoAlteracaoProposta($idSolicitacao, $userNome, $userEmail);

        $insert = [
            'tipo' => $dados['tipo'],
            'idref' => $dados['idref']
        ];

        if ($dados['avaliador']){
            $dadosAvaliador = array_merge($insert,$dados['avaliador']);
            $arrEnviadosAvaliador = $this->enviar($dadosAvaliador);
        }

        if ($dados['autor']){
            $dadosAutor = array_merge($insert,$dados['autor']);
            $arrEnviadosAutor = $this->enviar($dadosAutor);
        }
        
        if ($arrEnviadosAvaliador == '0'){
            return 'avaliador';
        }
        elseif($arrEnviadosAutor == '0'){
            return 'autor';
        }
        else {
            return 'passou';
        }
    }

    // --------------------------------------------------------------------------------

    public function analiseAlteracaoPropostas($idSolicitacao, $resultado, $userNome, $userEmail)
    {

        if (empty($idSolicitacao)) {
            // throw new Exception("ID da solicitação não informado para envio de email");
            throw new Exception('Solicitação de alteração não encontrada!');
        }

        require_once '../includes/mailBody/mailAnaliseAlteracaoPropostas.php';
        $dados = mailAnaliseAlteracaoPropostas($idSolicitacao, $resultado, $userNome, $userEmail);

        $insert = [
            'tipo' => $dados['tipo'],
            'idref' => $dados['idref']
        ];

        if ($dados['avaliador']){
            $dadosAvaliador = array_merge($insert,$dados['avaliador']);
            $arrEnviadosAvaliador = $this->enviar($dadosAvaliador);
        }

        if ($dados['autor']){
            $dadosAutor = array_merge($insert,$dados['autor']);
            $arrEnviadosAutor = $this->enviar($dadosAutor);
        }

        if ($dados['novoAutor']){
            $dadosNovoAutor = array_merge($insert,$dados['novoAutor']);
            $arrEnviadosNovoAutor = $this->enviar($dadosNovoAutor);
        }

        if ($arrEnviadosAvaliador == '0'){
            return 'avaliador';
        }
        elseif($arrEnviadosAutor == '0'){
            return 'autor';
        }
        elseif($arrEnviadosNovoAutor == '0'){
            return 'novoAutor';
        }
        else {
            return 'passou';
        }

    }
}

