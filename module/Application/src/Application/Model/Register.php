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
    public function addUser($login, $password) //Il manque le type
    {

        $dbAdapterConfig = array(
            'driver' => 'Pdo_mysql',
            'database' => 'dreamideas',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        );
        $dbAdapter = new Adapter($dbAdapterConfig);
        $sql = new Sql($dbAdapter);

        $insert = $sql->insert('user'); // Définition de la table concernée
        $newData = array(
            'login'=> $login,
            'password'=> $password
        );
        $insert->values($newData);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        return;
    }
}
?>