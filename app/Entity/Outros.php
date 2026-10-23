<?php

namespace App\Entity;

use App\Db\Database;

#[\AllowDynamicProperties]
class Outros
{
    /*
retorna um valor
*/
    public static function hierCol($id)
    {
        $sql = 'select * from ca_ce_co ccc ';
        $where = 'where ccc.co_id  = "'.$id.'"';

        !is_null($id) ? $sql += $where : null;

        return (new Database())->selectJ($sql)
          ->fetchObject(self::class);
    }

    /*
    retorna vários valores
    */
    public static function qry($sql)
    {
        return (new Database())->selectJ($sql)
          ->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /*
    retorna um valor
    */
    public static function q($sql)
    {
        return (new Database())->selectJ($sql)
          ->fetchObject(self::class);
    }
}
