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
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
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

        return $returnArray;
    }

    public function getCommunity($aCommunityId)
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->from('community')
               ->where('id_Community = ' . $aCommunityId);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $returnCmy = array();
        foreach ($result as $row)
        {
            $returnCmy[] = $row;
        }

        $select = $sql->select();
        $select->from(array('c' => 'comment'),
                      array('description_comment'))
               ->join(array('u' => 'user'),
                      'c.id_user = u.id_user',
                      array('login'))
               ->where('id_Community = ' . $aCommunityId);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $returnCmt = array();
        foreach ($result as $row)
        {
            $returnCmt[] = $row;
        }

        $select = $sql->select();
        $select->from('idea')
            ->where('id_Community = ' . $aCommunityId);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $returnIdeas = array();
        $returnIdeasComments = array();
        $cpt = 0;
        foreach($result as $row)
        {
            $returnIdeas[] = $row;

        }

        return array('community' => $returnCmy,
                     'comments' => $returnCmt,
                      'ideas' => $returnIdeas);
    }

    public function addComment($aCommunityId, $aComment, $aUserId)
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $insert = $sql->insert('comment'); // Définition de la table concernée

        $newData = array(
            'description_comment' => $aComment,
            'id_Community' => $aCommunityId,
            'id_user' => $aUserId
        );
        $insert->values($newData);
        $sql->prepareStatementForSqlObject($insert)
            ->execute();

        return;
    }

    public function addCommunity($nameCommunity, $descriptionCommunity){

        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $insert = $sql->insert('community'); // Définition de la table concernée
        $newData = array(
            'name_Community' => $nameCommunity,
            'description_Community' => $descriptionCommunity

        );
        $insert->values($newData);
        $sql->prepareStatementForSqlObject($insert)
            ->execute();

        return;

    }
}
?>