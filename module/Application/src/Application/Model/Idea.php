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
                      'i.id_user = u.id_user')
               ->join(array('c' => 'community'),
                      'c.id_Community = i.id_Community');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $returnArray = array();
        /* le resultat de la requete se trouve dans $returnArray */
        foreach ($result as $row) {
            $returnArray[] = $row;
        }

        return $returnArray;
    }

    public function getIdea($aIdeaId)
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->from('idea')
            ->where('id_idea = ' . $aIdeaId);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $returnIdea = array();
        foreach ($result as $row) {
            $returnIdea[] = $row;
        }

        $select = $sql->select();
        $select->from(array('c' => 'comment'),
            array('description_comment'))
            ->join(array('u' => 'user'),
                'c.id_user = u.id_user',
                array('login'))
            ->where('id_Idea = ' . $aIdeaId);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $returnCmt = array();
        foreach ($result as $row)
        {
            $returnCmt[] = $row;
        }

        return array('ideas' => $returnIdea,
            'comments' => $returnCmt);
    }

    public function addComment($aDescription, $aIdeaId, $aUserId)
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);
        $insert = $sql->insert('comment'); // Définition de la table concernée

        $newData = array(
            'description_comment' => $aDescription,
            'id_idea' => $aIdeaId,
            'id_user' => $aUserId
        );
        $insert->values($newData);
        $sql->prepareStatementForSqlObject($insert)
            ->execute();

        return;
    }

    public function addIdea($aTitleIdea, $aDescriptionIdea, $aUserId, $aCommunityId)
    {
        $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
        $sql = new Sql($dbAdapter);

        $insert = $sql->insert('idea'); // Définition de la table concernée
        $newData = array(
            'title_idea' => $aTitleIdea,
            'text_idea' => $aDescriptionIdea,
            'id_user' => $aUserId,
            'id_community' => $aCommunityId
        );


        $insert->values($newData);
        $sql->prepareStatementForSqlObject($insert)
            ->execute();

        return;
    }
}