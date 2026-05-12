<?php

namespace App\Entity;

use App\Db\Database;
use App\Db\LerDot;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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
    private function cadastrarDB()
    {
        $obDatabase = new Database('mailsmsgs');
        $this->id = $obDatabase->insert([
            'destinatario' => $this->destinatario,
            'nome' => $this->nome,
            'sistema' => $this->sistema,
            'tipo' => $this->tipo,
            'idref' => $this->idref,
            'status' => $this->status,
            'assunto' => $this->assunto,
            'mensagem' => $this->mensagem,
            //  'created_at'    =>$this->created_at,
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    private function formatData($dt)
    {
        $date = date_create($dt);

        return date_format($date, 'd/m/Y');
    }

    private function validaDestinatario()
    {
        $env = new LerDot();
        if (Database::NAME != $env::get('NAMEPROD')) {
            $this->destinatario = $env::get('MAILTESTER');
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
        $this->validaDestinatario();
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

            $mail->addAddress($this->destinatario, $nome);
            $mail->Subject = $assunto;

            // email
            $mail->Body = $mensagem;

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    private function getProximoAvaliador($idProjeto)
    {
        $sql = "
            select 
                a.fase_seq,
                a.tp_instancia,
                COALESCE(uca.nome,  uco.nome,   pf.nome,  uce.nome,  udc.nome  ) as nome,                
                COALESCE(uca.email, uco.email,  pf.email, uce.email, udc.email ) as email, 
                COALESCE(ca.nome, ce.nome, co.nome, 'Parecerista') as local,
                CASE a.tp_instancia
                    WHEN 'dc' THEN 'Diretor de Campus'
                    WHEN 'ca' THEN 'Chefe de Divisão'
                    WHEN 'ce' THEN 'Diretor(ª) de Centro de Área'
                    WHEN 'co' THEN 'Coordenador(ª)'
                    ELSE 'Professor(ª)'
                END funcao
            from avaliacoes a
                left join campi ca on a.id_instancia = ca.id and a.tp_instancia = 'ca'
                left join campi dc on a.id_instancia = dc.id and a.tp_instancia = 'dc'
                left join centros ce on a.id_instancia = ce.id and a.tp_instancia = 'ce'
                left join colegiados co on a.id_instancia = co.id and a.tp_instancia = 'co'
                left join userprof pf on a.id_instancia = pf.id and a.tp_instancia = 'pf'
                left join userprof udc on dc.dir_campus_id = udc.id 
                left join userprof uca on ca.chef_div_id = uca.id
                left join userprof uce on ce.dir_ca_id = uce.id
                left join userprof uco on co.coord_id = uco.id
            where 
                a.id_proj = '{$idProjeto}'
                and a.resultado = 'e'
            order by a.fase_seq asc
        ";

        return Diversos::qry($sql)[0] ?? null;
    }

    private function getAutorProp($idProjeto)
    {
        $sqlAutor = "
            select 
                p.id_prof as id,
                p.nome_prof as nome,
                u.email
            from projetos p
            join userprof u on u.id = p.id_prof
            where p.id = '{$idProjeto}'
        ";

        return Diversos::qry($sqlAutor)[0] ?? null;
    }

    private function tipoProposta($tipoProp)
    {
        switch ($tipoProp) {
            case 1:
                $tpMSG = 'Curso';
                break;
            case 2:
                $tpMSG = 'Evento';
                break;
            case 3:
                $tpMSG = 'Prestação de Serviço';
                break;
            case 4:
                $tpMSG = 'Programa';
                break;
            case 5:
                $tpMSG = 'Projeto';
                break;
        }

        return $tpMSG;
    }

    private function getTituloProp($idproj)
    {
        $sqlTitulo = "
            select
                p.titulo
            from projetos p
            where p.id = '".$idproj."'
        ";

        return Diversos::qry($sqlTitulo)[0] ?? null;
    }

    public function cadastrarProposta($destinatario, $nomeUser, $tipoMail, $idProp, $tipoProp, $tituloProp, $idUser)
    {
        $this->destinatario = $destinatario;
        $this->nome = $nomeUser;
        $this->definirBaseUrl();
        $this->validarSistema(); // $this->sistema = $sistema;
        $this->tipo = $tipoMail;
        $this->idref = $idProp;
        $this->user = $idUser;

        $this->assunto = $assunto = 'Proposta cadastrada no Sistema da PROEC';
        $tpMSG = $this->tipoProposta($tipoProp);

        // email
        $this->mensagem = $mensagem = '
            <h2>Proposta cadastrada no Sistema da PROEC</h2>
  
            <p><strong>'.$nomeUser.'</strong>, sua proposta de extensão foi cadastrada no Sistema da PROEC.</p>
            <p><strong>Título: </strong> '.$tituloProp.'</p>
            <p><strong>Tipo: </strong>'.$tpMSG.'</p>
            
            <p>Para que ela siga para etapas de avaliação, após o cadastro clique em SUBMETER no sistema, 
            Se você já fez isso, desconsidere essa orientação.</p>
            
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ';

        // $destinatario, $nome, $assunto, $mensagem;

        $this->status = $this->sendMail($destinatario, $nomeUser, $assunto, $mensagem) ? 1 : 0;
        $this->cadastrarDB();
    }

    public function avaliacaoProposta($projeto, $resultado)
    {
        // define o sistema (epad, sistema, etc)
        $this->validarSistema();
        $this->definirBaseUrl();

        if ($resultado == 'a') {
            $avaliador = $this->getProximoAvaliador($projeto->id);
            $autor = $this->getAutorProp($projeto->id);

            if ($avaliador) {
                // envia para próximo avaliador
                $this->destinatario = $avaliador->email;
                $this->nome = $avaliador->nome;
                $this->tipo = 2;
                $this->idref = $projeto->id;

                $this->assunto = 'Proposta aguardando avaliação';
                $this->mensagem = '
                    <h3>Proposta aguardando avaliação</h3>
                    <p>Existe uma proposta aguardando sua avaliação no sistema.</p>
                    <p>Título: '.$projeto->titulo.'</p>
                    <p>Coordenador: '.$autor->nome.'

                    </p>

                    
                    <br>
                    <small>Este e-mail é automático.</small>
                ';

                $this->status = $this->sendMail(
                    $this->destinatario,
                    $this->nome,
                    $this->assunto,
                    $this->mensagem
                ) ? 1 : 0;

                $this->cadastrarDB();

                // avisa autor que está em avaliação
                $this->destinatario = $autor->email;
                $this->nome = $autor->nome;
                $this->tipo = 2;
                $this->idref = $projeto->id;

                $this->assunto = 'Sua proposta está em nova fase de avaliação';
                $this->mensagem = '
                    <h3>Sua proposta está em nova fase de avaliação.</h3>
                    <p>Instância responsável: '.$avaliador->funcao.' - '.$avaliador->nome.'</p>
                    <p>Título da proposta a ser avaliada: <strong>'.$projeto->titulo.'</strong></p>
                    <p>Protocolo: <strong>'.$projeto->protocolo.'</strong></p>

                    <br>
                    <small>Este e-mail é automático.</small>
                ';

                $this->status = $this->sendMail(
                    $this->destinatario,
                    $this->nome,
                    $this->assunto,
                    $this->mensagem
                ) ? 1 : 0;

                $this->cadastrarDB();
            } else {
                $this->destinatario = $autor->email;
                $this->nome = $autor->nome;
                $this->tipo = 2;
                $this->idref = $projeto->id;

                $this->assunto = 'Sua proposta foi aprovada em todas as instâncias';
                $this->mensagem = '
                    <h3>Proposta aprovada com sucesso</h3>
                    <p>Sua proposta concluiu todas as etapas de avaliação.</p>
                    <p>Título: <strong>'.$projeto->titulo.'</strong></p>
                    <p>Este '.$this->tipoProposta($projeto->tipo_exten).' deve ser executado dentro da vigência informada</p>
                    <p>Vigência informada: <strong>'.$this->formatData($projeto->vigen_ini).'<strong> - </strong>'.$this->formatData($projeto->vigen_fim).'</strong></p>
                    <p>Dentro deste período podem ser inseridos <strong>relatórios parciais</strong></p>
                    <p>Ao seu término, <strong>relatórios finais</strong>.</p>

                    <br>
                    <small>Este e-mail é automático.</small>
                ';

                $this->status = $this->sendMail(
                    $this->destinatario,
                    $this->nome,
                    $this->assunto,
                    $this->mensagem
                ) ? 1 : 0;

                $this->cadastrarDB();
            }
        } elseif ($resultado == 'n') {
            $avaliador = $this->getProximoAvaliador($projeto->id);
            $autor = $this->getAutorProp($projeto->id);

            if (!$avaliador) {
                return; // ninguém aguardando avaliação
            }

            $this->destinatario = $avaliador->email;
            $this->nome = $avaliador->nome;
            $this->tipo = 2; // avaliação
            $this->idref = $projeto->id;

            $this->assunto = 'Submissão de proposta de extensão';

            $this->mensagem = '
                <h3>Chegou uma nova avaliação a ser realizada no sistema da PROEC</h3>
                <p>Título da proposta a ser avaliada: <strong>'.$projeto->titulo.'</strong></p>
                <p>Protocolo: <strong>'.$projeto->protocolo.'</strong></p>
                
                <br>
                <small>Este e-mail é automático.</small>
            ';

            $this->status = $this->sendMail(
                $this->destinatario,
                $this->nome,
                $this->assunto,
                $this->mensagem
            ) ? 1 : 0;

            $this->cadastrarDB();

            $autor = $this->getAutorProp($projeto->id);

            if (!$autor) {
                return;
            }

            $this->destinatario = $autor->email;
            $this->nome = $autor->nome;
            $this->tipo = 3; // primeira submissão da proposta
            $this->idref = $projeto->id;

            $this->assunto = 'Submissão de Proposta';
            /* Coordenador do projeto */
            $this->mensagem = '
                <h3>Submissão de proposta de extensão</h3>
                <p>'.$autor->nome.', sua proposta de extensão de título "'.$projeto->titulo.'",
                protocolo '.$projeto->protocolo.'  foi encaminhada para análise da Divisão de Extensão do campus de '.$projeto->campus.'. </p>
                <p>Instância responsável: '.$avaliador->funcao.' - '.$avaliador->nome.'</p>
                <p>Após o parecer da Divisão de Extensão, a proposta poderá retornar para ajustes ou seguir o trâmite descrito no Regulamento de Extensão da Unespar.</p>

                <p>Acesse o sistema para dar continuidade ao fluxo.</p>


                <br>
                <small>Este e-mail é automático.</small>
            ';

            $this->status = $this->sendMail(
                $this->destinatario,
                $this->nome,
                $this->assunto,
                $this->mensagem
            ) ? 1 : 0;

            $this->cadastrarDB();
        } elseif ($resultado == 'r') {
            // achar o autor do proejto pra enviar email
            $autor = $this->getAutorProp($projeto->id);
            if (!$autor) {
                return;
            }
            $this->destinatario = $autor->email;
            $this->nome = $autor->nome;
            $this->tipo = 3;
            // aviso de avaliação ao autor

            $this->idref = $projeto->id;
            $this->assunto = 'Solicitação de Alteração';
            $this->mensagem = ' 
                <h3>Solicitação de ajustes na proposta</h3> 
                <p>Acesse o sistema para visualizar e realizar as adequações necessárias.</p> 
                <p>Título: <strong>'.$projeto->titulo.'</strong></p>
                <p>Após reajustar a proposta, reenvie para uma nova avaliação.</p> 
                <br> 
                <small>Este e-mail é automático.</small> ';
            $this->status = $this->sendMail(
                $this->destinatario,
                $this->nome,
                $this->assunto,
                $this->mensagem
            ) ? 1 : 0;
            $this->cadastrarDB();
        }
    }

    public function avaliacaoRelatorio($relatorio, $projeto, $resultado)
    {
        $this->validarSistema();
        $this->definirBaseUrl();

        $autor = $this->getAutorProp($projeto->id);

        // echo '<pre>';
        // print_r($projeto);
        // print_r($relatorio);
        // echo '</pre>';
        // exit;

        $tipoRel = $this->getTipoRel($relatorio);

        if ($resultado == 'a') {
            // ainda tem próxima etapa?
            if ($relatorio->etapa < $relatorio->etapas) {
                $avaliador = $this->getAvaliadorRelatorio($relatorio);

                if ($avaliador) {
                    // email para próximo avaliador
                    $this->destinatario = $avaliador['email'];
                    $this->nome = $avaliador['nome'];
                    $this->tipo = 2;
                    $this->idref = $relatorio->id;

                    $this->assunto = $tipoRel['tipoNome'].' aguardando avaliação';
                    $this->mensagem = '
                        <h3>'.$tipoRel['tipoNome'].' aguardando avaliação</h3>
                        <p>Existe um '.$tipoRel['tipoNome'].' aguardando sua avaliação.</p>
                        <p><strong>Projeto:</strong> '.$projeto->titulo.'</p>


                        <small>Este e-mail é automático.</small>
                    ';

                    $this->status = $this->sendMail(
                        $this->destinatario,
                        $this->nome,
                        $this->assunto,
                        $this->mensagem
                    ) ? 1 : 0;

                    $this->cadastrarDB();
                }
            } else {
                $this->destinatario = $autor->email;
                $this->nome = $autor->nome;
                $this->tipo = 2;
                $this->idref = $relatorio->id;

                $this->assunto = $tipoRel['tipoNome'].' aprovado e publicado';
                $this->mensagem = '
                    <h3>'.$tipoRel['tipoNome'].' aprovado</h3>
                    <p>Seu '.$tipoRel['tipoNome'].' foi aprovado e publicado no sistema.</p>
                    <p><strong>Projeto:</strong> '.$projeto->titulo.'</p>

        
                    <small>Este e-mail é automático.</small>
                ';

                $this->status = $this->sendMail(
                    $this->destinatario,
                    $this->nome,
                    $this->assunto,
                    $this->mensagem
                ) ? 1 : 0;

                $this->cadastrarDB();
            }
        }

        if ($resultado == 'r') {
            $this->destinatario = $autor->email;
            $this->nome = $autor->nome;
            $this->tipo = 3;
            $this->idref = $relatorio->id;

            $this->assunto = 'Solicitação de adequações - '.$tipoRel['tipoNome'];
            $this->mensagem = '
                <h3>Solicitação de ajustes</h3>
                <p>Foram solicitadas adequações no '.$tipoRel['tipoNome'].' da proposta:</p>
                <p><strong>'.$projeto->titulo.'</strong></p>

                <p>Acesse o sistema para visualizar os apontamentos e reenviar o relatório.</p>


                <small>Este e-mail é automático.</small>
            ';

            $this->status = $this->sendMail(
                $this->destinatario,
                $this->nome,
                $this->assunto,
                $this->mensagem
            ) ? 1 : 0;

            $this->cadastrarDB();
        }
    }

    private function getAvaliadorRelatorio($relatorio)
    {
        switch ($relatorio->tp_avaliador) {
            case 'ca':
                return [
                    'email' => $relatorio->chef_mail,
                    'nome' => 'Chefe de Divisão',
                ];

            case 'ce':
                return [
                    'email' => $relatorio->ce_mail,
                    'nome' => 'Diretor(a) de Centro',
                ];

            case 'co':
                return [
                    'email' => $relatorio->co_mail,
                    'nome' => 'Coordenador(a)',
                ];

            case 'dc':
                return [
                    'email' => $relatorio->dc_mail,
                    'nome' => 'Diretor(a) de Campus',
                ];

            default:
                return null;
        }
    }

    public function submissaoRelatorio($relatorio, $projeto)
    {
        $this->validarSistema();
        $this->definirBaseUrl();

        $autor = $this->getAutorProp($projeto->id);

        // echo '<pre>';
        // print_r($relatorio);
        // echo '</pre>';
        // exit;

        $avaliador = $this->getAvaliadorRelatorio($relatorio);
        // echo '<pre>';
        //     print_r($avaliador['nome']);
        //     print_r($avaliador['email']);
        //     print_r($autor);
        // echo '</pre>';
        // exit;
        // var_dump($avaliador);
        // var_dump($autor);
        // exit;
        if (!$avaliador || !$autor) {
            return;
        }

        $tipoRel = $this->getTipoRel($relatorio);

        $this->destinatario = $avaliador['email'];
        $this->nome = $avaliador['nome'];
        $this->tipo = 2;
        $this->idref = $relatorio->id;

        $this->assunto = 'Relatório aguardando avaliação';
        $this->mensagem = '
            <h3>Relatório aguardando avaliação</h3>
            <p>Existe um relatório aguardando sua avaliação.</p>
            <p><strong>Projeto:</strong> '.$projeto->titulo.'</p>

            <small>Este e-mail é automático.</small>
        ';

        $this->status = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        ) ? 1 : 0;

        $this->cadastrarDB();

        $this->destinatario = $autor->email;
        $this->nome = $autor->nome;
        $this->tipo = 3;
        $this->idref = $relatorio->id;

        $this->assunto = 'Relatório enviado para avaliação';
        $this->mensagem = '
            <h3>Relatório enviado com sucesso</h3>
            <p>Seu relatório foi encaminhado para avaliação.</p>
            <p><strong>Projeto:</strong> '.$projeto->titulo.'</p>
            <p><strong>Instância atual:</strong> '.$avaliador['nome'].' — teste</p>

            <small>Este e-mail é automático.</small>
        ';

        $this->status = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        ) ? 1 : 0;

        $this->cadastrarDB();
    }

    public function getTipoRel($relatorio)
    {
        switch ($relatorio->tipo ?? $relatorio->tp_relatorio) {
            case 'pa':
                return [
                    'tipoNome' => 'Relatório Parcial',
                    'tipoAbr' => 'p',
                ];
            case 'fi':
                return [
                    'tipoNome' => 'Relatório Final',
                    'tipoAbr' => 'f',
                ];
            case 're':
                return [
                    'tipoNome' => 'Relatório Final com Renovação',
                    'tipoAbr' => 'f',
                ];
            case 'pr':
                return [
                    'tipoNome' => 'Relatório Final com Prorrogação',
                    'tipoAbr' => 'f',
                ];
            default:
                return [
                    'tipoNome' => 'erro',
                    'tipoAbr' => 'erro',
                ];
        }
    }

    public function recuperarSenha($email, $nome, $novaSenha)
    {
        $this->validarSistema();
        $this->definirBaseUrl();
        $this->destinatario = $email;
        $this->nome = $nome;
        $this->tipo = 6; // to vendo ainda
        // $this->idref = ?;

        $this->assunto = 'Recuperação de senha';

        $this->mensagem = '
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

        $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        ) ? 1 : 0;

        $this->cadastrarDB();
    }

    // ===============================================================

    // $idSolicitacao é o ID do projeto que está sendo enviado, para modificar é em enviaAlteracao.php
    public function solicitacaoAlteracaoPropostas($idSolicitacao, $userEmail, $userNome)
    {
        if (empty($idSolicitacao)) {
            // throw new Exception("ID da solicitação não informado para envio de email");
            throw new Exception('Solicitação de alteração não encontrada!');
        }

        // Pega as infos da view solicitacao_adendos_v
        $where = 'id = "'.$idSolicitacao.'"';
        $ObjSolicitacao = solicitacao_adendos::getRegistros($where);

        $avaliador = null;
        // Pega quem vai receber o projeto para avaliação
        if ($ObjSolicitacao[0]->campoAlterado == 'id_prof') {
            // Garante que vai apenas para o Diretor de Programas e Projetos de Extensão (Dantas)
            $whr = 'idLocalCargo = "'.$ObjSolicitacao[0]->id_localValidador.'" and id = "6d7582d1-3998-11f1-aed4-66a0b0dd1af7"';
            $flds = 'nome, email';
            $data = Cargos_Especiais::getRegistros($whr, '', '', $flds);
            // print_r($avaliador);
            // exit;
            $avaliador = $data[0]->nome;
            $emailAvaliador = $data[0]->email;
        } else {
            $whr = 'ca_id = "'.$ObjSolicitacao[0]->id_localValidador.'"';
            $flds = 'chef, chef_mail';
            $data = Ca_Ce_Co::getRegistros($whr, '', '1', $flds);
            // print_r($avaliador);
            // exit;
            $avaliador = $data[0]->chef;
            $emailAvaliador = $data[0]->chef_mail;
        }

        $this->validarSistema();
        $this->definirBaseUrl();

        require_once '../includes/funcoes/func_mudaAbreviacao.php';
        $campoAlterado = mudaAbreviacao($ObjSolicitacao[0]->campoAlterado);

        // Quem enviou a solicitação de modificação
        $this->destinatario = $userEmail;
        $this->nome = $userNome;
        $this->tipo = 7;

        $this->assunto = 'Solicitação de alteração de proposta';
        $this->mensagem = '
            <h2>Solicitação enviada com sucesso!</h2>
              
            <p>Olá <strong>'.$userNome.'</strong>,</p>
                    
            <p>Sua solicitação de alteração foi enviada para <strong>'.$avaliador.'</strong> e será devidamente avaliada.</p>
            <p>O retorno da avaliação será informado via e-mail.</p>
              
            <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
            <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>

            <br><br>
            <small>Este e-mail é automático.</small>
        ';

        $enviado = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        );
        $this->status = $enviado ? 1 : 0;
        $arrEnviados[] = $enviado;
        $this->cadastrarDB();

        // Quem irá avaliar a solicitação de alteração
        $this->destinatario = $emailAvaliador;
        $this->nome = $avaliador;
        $this->tipo = 7;

        $this->assunto = 'Solicitação de alteração de proposta';
        $this->mensagem = '
            <h2>Você recebeu uma nova solicitação de alteração de proposta!</h2>
              
            <p>Olá <strong>'.$avaliador.'</strong>,</p>
                    
            <p>Você recebeu uma solicitação de alteração de proposta de: <strong>'.$userNome.'</strong>.</p>
            <p>Faça a avaliação para finalizar a solicitação.</p>
              
            <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
            <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>

            <br><br>
            <small>Este e-mail é automático.</small>
        ';

        $enviado = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        );
        $this->status = $enviado ? 1 : 0;
        $arrEnviados[] = $enviado;
        $this->cadastrarDB();

        foreach ($arrEnviados as $arr) {
            if ($arr != '1') {
                return false;
            } else {
                return true;
            }
        }
    }

    public function analiseAlteracaoPropostas($idSolicitacao, $resultado, $userNome, $userEmail)
    {
        if (empty($idSolicitacao)) {
            // throw new Exception("ID da solicitação não informado para envio de email");
            throw new Exception('Solicitação de alteração não encontrada!');
        }

        // Pega as infos da view solicitacao_adendos_v
        $where = 'id = "'.$idSolicitacao.'"';
        $ObjSolicitacao = solicitacao_adendos::getRegistros($where);

        $nomeDonoProj = $ObjSolicitacao[0]->solicitante_nome;
        $emailDonoProj = $ObjSolicitacao[0]->solicitante_email;

        $this->validarSistema();
        $this->definirBaseUrl();

        require_once '../includes/funcoes/func_mudaAbreviacao.php';
        $campoAlterado = mudaAbreviacao($ObjSolicitacao[0]->campoAlterado);
        $resultadoAvalia = mudaAbreviacao($resultado);

        // Quem enviou a avaliação de modificação
        $this->destinatario = $userEmail;
        $this->nome = $userNome;
        $this->tipo = 8;

        $this->assunto = 'Avaliação de alteração de proposta';
        $this->mensagem = '
            <h2>Avaliação enviada com sucesso!</h2>
            <p>Olá <strong>'.$userNome.'</strong>,</p>
            <p>Sua avaliação de alteração foi retornada para <strong>'.$nomeDonoProj.'</strong>.</p>
            <p>Agradecemos à avaliação.</p>
            <p><strong>Título do projeto a ser alterado: </strong>'.$ObjSolicitacao[0]->titulo.'</p>
            <p><strong>Campo a ser alterado: </strong>'.$campoAlterado.'</p>
            <p><strong>Resultado da avaliação: </strong>'.$resultadoAvalia.'</p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ';

        $enviado = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        );
        $this->status = $enviado ? 1 : 0;
        $arrEnviados[] = $enviado;
        $this->cadastrarDB();

        // Quem vai receber a avaliação de modificação
        $this->destinatario = $emailDonoProj;
        $this->nome = $nomeDonoProj;
        $this->tipo = 8;

        $this->assunto = 'Avaliação de alteração de proposta';
        $this->mensagem = '
            <h2>Sua solicitação foi avaliada!</h2>
            <p>Olá <strong>'.$nomeDonoProj.'</strong>,</p>
            <p>
                Informamos que foi <strong>'.strtolower($resultadoAvalia).'</strong> 
                a alteração do campo <strong>'.$campoAlterado.'</strong> 
                referente à proposta <strong>"'.$ObjSolicitacao[0]->titulo.'"</strong>.
            </p>
            <br><br>
            <small>Este e-mail é automático.</small>
        ';

        $enviado = $this->sendMail(
            $this->destinatario,
            $this->nome,
            $this->assunto,
            $this->mensagem
        );
        $this->status = $enviado ? 1 : 0;
        $arrEnviados[] = $enviado;
        $this->cadastrarDB();

        // O novo coordenador caso a proposta seja aprovado
        if ($ObjSolicitacao[0]->campoAlterado == 'id_prof' && $ObjSolicitacao[0]->resultado == 'a') {
            $idNovoCoord = $ObjSolicitacao[0]->dado_novo;
            $where = 'id = "'.$idNovoCoord.'"';
            $registro = Professor::getProfessores($where);
            $nomeNovoCoord = $registro[0]->nome;
            $emailNovoCoord = $registro[0]->email;

            $this->destinatario = $emailNovoCoord;
            $this->nome = $nomeNovoCoord;
            $this->tipo = 8;

            $this->assunto = 'Avaliação de alteração de proposta';
            $this->mensagem = '
                <h2>Alteração de coordenador realizada!</h2>
                <p>Olá <strong>'.$nomeNovoCoord.'</strong>,</p>
                <p>
                    Informamos que foi <strong>'.strtolower($resultadoAvalia).'</strong> 
                    a alteração do campo <strong>'.$campoAlterado.'</strong> 
                    referente à proposta <strong>"'.$ObjSolicitacao[0]->titulo.'"</strong>.
                </p>
                <p>
                    O projeto já consta na aba "Meus projetos/propostas" do seu sistema!
                </p>
                <br><br>
                <small>Este e-mail é automático.</small>
            ';

            $enviado = $this->sendMail(
                $this->destinatario,
                $this->nome,
                $this->assunto,
                $this->mensagem
            );
            $this->status = $enviado ? 1 : 0;
            $arrEnviados[] = $enviado;
            $this->cadastrarDB();
        }

        foreach ($arrEnviados as $arr) {
            if ($arr != '1') {
                return false;
            } else {
                return true;
            }
        }
    }
}
