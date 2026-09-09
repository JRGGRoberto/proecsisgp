<?php

namespace App\Entity;

// require '../../vendor/autoload.php';

use App\Db\Database;
use App\Db\LerDot;
use PHPMailer\PHPMailer\Exception;

// require_once '../includes/funcoes/func_mudaAbreviacao.php';

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
     * Método responsável por obter as pessoas do banco de dados.
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function getEmails($where = null, $order = null, $limit = null)
    {
        return (new Database('mailsmsgs'))->select($where, $order, $limit)
                                    ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por cadastrar um novo email no banco.
     *
     * @return bool
     */
    private function cadastrarDB($dados)
    {
        // Espera 0 segundos e 100.000.000 nanossegundos
        //                     900.000.000
        // Isso é feito para que o envio de email possa pegar o created certo
        // time_nanosleep(0, 900000000); // Não está usando, modificado em banco

        $obDatabase = new Database('mailsmsgs');

        if (
            // Pega negação de negação pq o insert retorna FALSE quando cadastra
            !$this->id = $obDatabase->insert([
                'destinatario' => $dados['destinatario'],
                'nome' => $dados['nome'],
                'sistema' => $this->sistema,
                'tipo' => $dados['tipo'],
                'idref' => $dados['idref'],
                'status' => $this->status,
                'assunto' => $dados['assunto'],
                'mensagem' => $dados['mensagem'],
                'user' => $this->user,
            ])
        ) {
            // RETORNAR SUCESSO
            return true;
        } else {
            // NÃO RETORNAR SUCESSO
            return false;
        }
    }

    /**
     * Método responsável por atualizar o email no banco.
     *
     * @return bool
     */
    public function atualizarStatus()
    {
        return (new Database('mailsmsgs'))->update('(id) = ( "'.$this->id.'" )',
            [
                'status' => $this->status,
            ]);
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

    // Aqui que valida o que será inserido no banco de dados
    public function enviar($dados)
    {
        $this->definirBaseUrl();
        $this->validarSistema();

        $destinatario = $this->validaDestinatario();
        if ($destinatario) {
            $dados['destinatario'] = $destinatario;
        }

        $this->destinatario = $dados['destinatario'];
        $this->idref = $dados['idref'];
        $this->nome = $dados['nome'];
        $this->assunto = $dados['assunto'];
        $this->mensagem = $dados['mensagem'];
        $this->tipo = $dados['tipo'];
        $this->status = '0';

        return $this->cadastrarDB($dados);
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
            'idref' => $dados['idref'],
        ];

        if ($dados['avaliador']) {
            $dadosAvaliador = array_merge($insert, $dados['avaliador']);
            $this->enviar($dadosAvaliador);
        }

        if ($dados['autor']) {
            $dadosAutor = array_merge($insert, $dados['autor']);
            $this->enviar($dadosAutor);
        }

        if (!$dados['autor'] || !$dados['avaliador']) {
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
            'idref' => $dados['idref'],
        ];

        $return = null;

        if (!empty($dados['autor'])) {
            $dadosAutor = array_merge($insert, $dados['autor']);
            if (!$this->enviar($dadosAutor)) {
                $return = 'autor';
            }
        }

        if (!empty($dados['avaliador'])) {
            $dadosAvaliador = array_merge($insert, $dados['avaliador']);
            if (!$this->enviar($dadosAvaliador)) {
                $return = 'avaliador';
            }
        }

        if (!empty($return)) {
            return $return;
        } else {
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
            'idref' => $dados['idref'],
        ];

        if ($dados['autor']) {
            $dadosAutor = array_merge($insert, $dados['autor']);
            if (!$this->enviar($dadosAutor)) {
                $return = 'autor';
            }
        }

        if ($dados['novoAutor']) {
            $dadosNovoAutor = array_merge($insert, $dados['novoAutor']);
            if (!$this->enviar($dadosNovoAutor)) {
                $return = 'novoAutor';
            }
        }

        if ($dados['avaliador']) {
            $dadosAvaliador = array_merge($insert, $dados['avaliador']);
            if (!$this->enviar($dadosAvaliador)) {
                $return = 'avaliador';
            }
        }

        if (!empty($return)) {
            return $return;
        } else {
            return 'passou';
        }
    }

    // --------------------------------------------------------------------------------

    // Exemplo no arquivo includes\funcoes\func_solicitaPessoas.php
    public function alteracaoPessoas($post, $senha = '', $resultado = '')
    {
        // Não preciso do ID do interessado pois como será enviado os dados por $post pega lá mesmo

        // ID de quem avaliou, no caso como foi feito por ADM não teve avaliação
        /** @var Professor */
        $responsavelAvaliacao = Professor::getProfessor($post->id_avaliador);

        // ID do chefe da pessoa que vai sair (coord ou DEC)
        if ($post->co_id && !$post->ca_id) {
            $co = Colegiado::getRegistro($post->co_id);
            /** @var Professor */
            $responsavelLocal = Professor::getProfessor($co->coord_id);
        } elseif ($post->ca_id && !$post->co_id) {
            $ca = Campi::getRegistro($post->ca_id);
            /** @var Professor */
            $responsavelLocal = Professor::getProfessor($ca->chef_div_id);
        } else {
            exit;
        }

        $dadosEmail = [
            'nomeResponsavelAvaliacao' => $responsavelAvaliacao->nome ?? '',
            'emailResponsavelAvaliacao' => $responsavelAvaliacao->email ?? '',

            'nomeResponsavelLocal' => $responsavelLocal->nome,
            'emailResponsavelLocal' => $responsavelLocal->email,

            'nomeInteressado' => $post->nome,
            'emailInteressado' => $post->email,
            'senhaAcesso' => $senha,
            'vinculo_remocao' => $post->vinculo_remocao ?? '',

            'tp_solicitacao' => $post->tp_solicitacao,
            'tp_cadastro' => $post->tp_cadastro,
            'resultado' => $resultado,
        ];

        require_once '../includes/mailBody/mailAlteracaoPessoas.php';

        // Quando é feito pelo admin é enviado para o admin, o chefe e o interessado
        if ($post->tp_solicitacao == 'cadastroAdmin' || $post->tp_solicitacao == 'desativacaoAdmin' || $post->tp_solicitacao == 'reativacaoAdmin') {
            // Aqui pega o que vai ser enviado escrito para o email das pessoas
            $dados = mailInsercaoADM($dadosEmail);
            $insert = [
                'tipo' => $dados['tipo'],
                'idref' => $post->id,
            ];

            if ($dados['administrador']) {
                $dadosAdministrador = array_merge($insert, $dados['administrador']);
                $arrEnviadosAdministrador = $this->enviar($dadosAdministrador);
            }
            if ($dados['chefe']) {
                $dadosChefe = array_merge($insert, $dados['chefe']);
                $arrEnviadosChefe = $this->enviar($dadosChefe);
            }
            if ($dados['interessado']) {
                $dadosInteressado = array_merge($insert, $dados['interessado']);
                $arrEnviadosInteressado = $this->enviar($dadosInteressado);
            }

            if ($arrEnviadosAdministrador == '0') {
                return 'administrador';
            } elseif ($arrEnviadosChefe == '0') {
                return 'chefe';
            } elseif ($arrEnviadosInteressado == '0') {
                return 'interessado';
            } else {
                return 'passou';
            }
        }
        // Ou seja, se for algo que tenha que ser aceito para que possa ser feito
        elseif ($post->tp_solicitacao == 'cadastro' || $post->tp_solicitacao == 'desativacao' || $post->tp_solicitacao == 'reativacao') {
            if ($post->resultado == 'r') { // Se o ADM reprovar
                // Aqui pega o que vai ser enviado escrito para o email das pessoas
                $dados = mailAvaliacaoADM($dadosEmail);
                $insert = [
                    'tipo' => $dados['tipo'],
                    'idref' => $post->id,
                ];

                if ($dados['administrador']) {
                    $dadosAdministrador = array_merge($insert, $dados['administrador']);
                    $arrEnviadosAdministrador = $this->enviar($dadosAdministrador);
                }
                if ($dados['chefe']) {
                    $dadosChefe = array_merge($insert, $dados['chefe']);
                    $arrEnviadosChefe = $this->enviar($dadosChefe);
                }

                if ($arrEnviadosAdministrador == '0') {
                    return 'administrador';
                } elseif ($arrEnviadosChefe == '0') {
                    return 'chefe';
                } else {
                    return 'passou';
                }
            } elseif ($post->resultado == 'a') { // Se o ADM aprovar
                // Aqui pega o que vai ser enviado escrito para o email das pessoas
                $dados = mailAvaliacaoADM($dadosEmail);
                $insert = [
                    'tipo' => $dados['tipo'],
                    'idref' => $post->id,
                ];

                if ($dados['administrador']) {
                    $dadosAdministrador = array_merge($insert, $dados['administrador']);
                    $arrEnviadosAdministrador = $this->enviar($dadosAdministrador);
                }
                if ($dados['chefe']) {
                    $dadosChefe = array_merge($insert, $dados['chefe']);
                    $arrEnviadosChefe = $this->enviar($dadosChefe);
                }
                if ($dados['interessado']) {
                    $dadosInteressado = array_merge($insert, $dados['interessado']);
                    $arrEnviadosInteressado = $this->enviar($dadosInteressado);
                }

                if ($arrEnviadosAdministrador == '0') {
                    return 'administrador';
                } elseif ($arrEnviadosChefe == '0') {
                    return 'chefe';
                } elseif ($arrEnviadosInteressado == '0') {
                    return 'interessado';
                } else {
                    return 'passou';
                }
            } else { // Aqui é para quando o DEC ou o Coord faz a solicitação, dessa forma ainda não teve resultado
                $dados = mailSolicitacaoPessoas($dadosEmail);

                $insert = [
                    'tipo' => $dados['tipo'],
                    'idref' => $post->id,
                ];

                if ($dados['chefe']) {
                    $dadosChefe = array_merge($insert, $dados['chefe']);
                    $arrEnviadosChefe = $this->enviar($dadosChefe);
                }

                if ($arrEnviadosChefe == '0') {
                    return 'chefe';
                } else {
                    return 'passou';
                }
            }
        } elseif ($post->tp_solicitacao == 'cadastroRm' || $post->tp_solicitacao == 'desativacaoRm' || $post->tp_solicitacao == 'reativacaoRm') {
            $dados = mailRemocaoSolicitacaoPessoas($dadosEmail);

            $insert = [
                'tipo' => $dados['tipo'],
                'idref' => $post->id,
            ];

            if ($dados['chefe']) {
                $dadosChefe = array_merge($insert, $dados['chefe']);
                $arrEnviadosChefe = $this->enviar($dadosChefe);
            }

            if ($arrEnviadosChefe == '0') {
                return 'chefe';
            } else {
                return 'passou';
            }
        }
    }

    public function cadastrarCandidato($cand, $idCand)
    {
        require_once '../includes/mailBody/mailCadastrarCand.php';
        $dados = mailCadastrarCand($cand, $idCand);

        $this->enviar($dados);
    }

    public function avaliacaoRelatorio($relatorio, $projeto, $resultado)
    {
        // $relatorio -> obj
        // $resultado -> 'n' 'a' 'r'

        require_once '../includes/mailBody/mailAvaliacaoRelatorio.php';
        $dados = mailAvaliacaoRelatorio($relatorio, $projeto, $resultado);

        $insert = [
            'tipo' => $dados['tipo'],
            'idref' => $dados['idref'],
        ];

        if ($dados['avaliador']) {
            $dadosAvaliador = array_merge($insert, $dados['avaliador']);
            $this->enviar($dadosAvaliador);
        }

        if ($dados['autor']) {
            $dadosAutor = array_merge($insert, $dados['autor']);
            $this->enviar($dadosAutor);
        }

        if (!$dados['autor'] || !$dados['avaliador']) {
            $this->enviar($dados);
        }
    }
}
