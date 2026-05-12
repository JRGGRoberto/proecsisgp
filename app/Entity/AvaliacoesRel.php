<?php

namespace App\Entity;

use App\Db\Database;

class AvaliacoesRel
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
        return (new Database('avaliacoes_rel'))->select($where, $order, $limit)
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
    public static function getRegistro($id)
    {
        return (new Database('avaliacoes_rel'))->select('id =  "'.$id.'"')
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
    public function cadastrar($id_rel, $fase)
    {
        $qry = '
        select 
          id, id_rel, ver, regra_def, fase_seq, form, r.tp_avaliador , id_instancia
        from 
          to_avaliar_rel r
        where 
          r.id_rel  = "'.$id_rel.'" 
          and r.fase_seq = "'.$fase.'";
       ';

        $dados = Outros::q($qry);
        $obDatabase = new Database('relats');
        $obDatabase->insert([
            'id' => $dados->id,
            'id_rel' => $dados->id_rel,
            'ver' => $dados->ver,
            'regra_def' => $dados->regra_def,
            'fase_seq' => $dados->fase_seq,
            'form' => $dados->form,
            'tp_instancia' => $dados->tp_instancia,
            'id_instancia' => $dados->id_instancia,
            'resultado' => $dados->resultado,
            'user' => $this->user,
        ]);

        // RETORNAR SUCESSO
        return true;
    }

    public function novaEtapaAvaliacao()
    {
        $rela = (object) Relats::getRegistro($this->id_rel);
        $qnt = Outros::q('select count(1) qnt from to_avaliar_rel where id_rel = "'.$this->id.'"');
        if ($rela->fase_atual < $qnt) {
            ++$rela->fase_atual; // testar para ver se é a ultima
            $this->cadastrar($this->id_rel, $rela->fase_atual);
        }
        $rela->last_result = 'a';
        $rela->atualizar();
        $this->resultado = 'a';
        $this->atualizar();
    }

    public function solicitarAlteracoes()
    {
        $rela = (object) Relats::getRegistro($this->id_rel);
        $rela->last_result = 'r';
        $rela->tramitar = '0';
        ++$rela->ver;
        $rela->atualizar();
        $this->resultado = 'r';
        $this->atualizar();
    }
}
