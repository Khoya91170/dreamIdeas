<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 20/06/2015
 * Time: 18:54
 */

namespace Application\Model;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class Idea
{
    public function getAllIdeas()
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);

        $select = $sql->select();
        $select->from(array('i' => 'idea'),
                      array('title_idea', 'text_idea'))
                ->join(array('u' => 'user'),
                       'i.id_user = u.id_user');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        //var_dump( $result);
        $returnArray = array();
        /* le resultat de la requete se trouve dans $returnArray */
        foreach ($result as $row) {
            $returnArray[] = $row;
        }

        return $returnArray;
    }
}