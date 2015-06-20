<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 20/06/2015
 * Time: 18:27
 */

namespace Application\Model;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class Register
{
    public function addUser($login, $password, $type) //Il manque le type
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $insert = $sql->insert('user'); // Définition de la table concernée

        $type = strtolower($type);
        $newData = array(
            'login' => $login,
            'password' => sha1($password),
            'id_user_type' => $type == "admin" ? 1 : 2
        );
        $insert->values($newData);
        $sql->prepareStatementForSqlObject($insert)
            ->execute();

        return;
    }
}
?>