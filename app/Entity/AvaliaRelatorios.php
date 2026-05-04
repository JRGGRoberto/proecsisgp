<?php

namespace App\Entity;

use App\Db\Database;

class AvaliaRelatorios
{
    public $id;
    public $id_rel;
    public $ver;
    public $regra_def;
    public $fase_seq;
    public $form;
    public $tp_instancia;
    public $id_instancia;
    public $resultado;
    public $created_at;
    public $updated_at;
    public $user;

    /**
     * Método responsável por obter as registros do banco de dados.
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     *
     * @return array
     */
    public static function getRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('avalia_relatorios'))->select($where, $order, $limit)
                                      ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter a quantidade de registros.
     *
     * @return int
     */
    public static function getQntdRegistros($where = null)
    {
        return (new Database('avaliacoes_rel'))->select($where, null, null, 'COUNT(*) as qtd')
                                      ->fetchObject()
                                      ->qtd;
    }

    /**
     * Método responsável por buscar um Registro com base em seu ID.
     *
     * @param int $id
     */
    public static function getById($id)
    {
        return (new Database('avalia_relatorios'))->select('id =  "'.$id.'"')
                                      ->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar um Registro com base em seu ID.
     */
    public static function getByWhere($where)
    {
        return (new Database('avalia_relatorios'))->select($where, null, 1)
                                      ->fetchObject(self::class);
    }

    /**
     * Método responsável por excluir a Registro do banco.
     *
     * @return bool
     */
    public function excluir()
    {
        return (new Database('avaliacoes_rel'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por atualizar a Registro no banco.
     *
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('avaliacoes_rel'))->update('id = "'.$this->id.'"', [
            'id_instancia' => $this->id_instancia,
            'resultado' => $this->resultado,
            'updated_at' => date('Y-m-d H:i:s'),
            'user' => $this->user,
        ]);
    }

    /**
     * Método responsável por inserir uma nova avaliação.
     *
     * @param string $id_rel ID do relatório
     * @param string $fase   Fase a qual ele se referencia
     */
    public static function cadastrar($id_rel, $fase, $id_professor = null)
    {
        $qry = '
        select 
          id, id_rel, ver, regra_def, fase_seq, form, r.tp_avaliador , COALESCE(id_instancia, "'.$id_professor.'" ) id_instancia
        from 
          to_avaliar_rel r
        where 
          r.id_rel  = "'.$id_rel.'" 
          and r.fase_seq = "'.$fase.'"
        limit 1
       ';

        /*
                 echo '<hr>'.
                      '$id_rel: '.$id_rel.'<br>'.
                      '$fase: '.$fase.'<br>'.
                      '$id_professor: '.$id_professor.'<br>'.
                      '<hr>'.$qry.'<hr>';
        */
        $dados = Outros::q($qry);
        $instancia = $dados->id_instancia;
        // Se for uma resubmissão de uma recusa de [professor selecionado] a view to_avaliar_rel não retorna id_instancia
        //

        $where = '
            id_rel = "'.$id_rel.'" and 
            tp_instancia = "pf" and
            LENGTH(id_instancia) > 2
        ';

        if ($fase > 1) {
            $avaliacaoAnterior = AvaliaRelatorios::getByWhere($where);
            if (
                ($avaliacaoAnterior->tp_instancia == 'pf')
                and ($avaliacaoAnterior->resultado == 'r')
                and (is_null($instancia) or $instancia == '')
            ) {
                $instancia = $avaliacaoAnterior->id_instancia;
            }
        }

        $obDatabase = new Database('avaliacoes_rel');
        $obDatabase->insert([
            'id' => $dados->id,
            'id_rel' => $dados->id_rel,
            'ver' => $dados->ver,
            'regra_def' => $dados->regra_def,
            'fase_seq' => $dados->fase_seq,
            'form' => $dados->form,
            'tp_instancia' => $dados->tp_avaliador,
            'id_instancia' => $instancia,
            // 'resultado' => $dados->resultado,
            // 'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    // Nova etapa ou Publicação
    public function novaEtapaAvaliacao($id_professor = null)
    {
        $this->resultado = 'a';
        $this->atualizar();

        $relatorio = (object) Relatorio::getById($this->id_rel);

        echo '<pre>';
        print_r($relatorio);
        echo '</pre>';
        if ($relatorio->fase_atual < $relatorio->fases) {
            $novaFase = $relatorio->fase_atual + 1;
            $this->cadastrar($this->id_rel, $novaFase, $id_professor);
        }

        $relatorio->aprovar();
    }

    public function solicitarAlteracoes()
    {
        $this->resultado = 'r';
        $this->atualizar();
        $rela = (object) Relatorio::getById($this->id_rel);
        $rela->adequacoes();
    }
}
