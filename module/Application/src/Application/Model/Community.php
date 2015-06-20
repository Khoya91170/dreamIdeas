<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 09/06/2015
 * Time: 10:51
 */

namespace Application\Model;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class Community
{
    public function getAllCommunities()
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

        $select = $sql->select();
        $select->from('community');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $returnArray = array();
        /* le resultat de la requete se trouve dans $returnArray */
        foreach ($result as $row) {
            $returnArray[] = $row;
        }

        return array('community' => $returnArray);
    }
}
?>