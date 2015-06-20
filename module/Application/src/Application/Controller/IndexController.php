<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $dbAdapterConfig = array(
            'driver'   => 'Pdo_mysql',
            'database' => 'dreamideas',
            'username' => 'root',
            'password' => ''
        );
        $dbAdapter = new Adapter($dbAdapterConfig);
        $sql = new Sql($dbAdapter);

        $select = $sql->select();
        $select->from('community');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        //var_dump( $result);
        $returnArray = array();
        /* le resultat de la requete se trouve dans $returnArray */
        foreach ($result as $row) {
            $returnArray[] = $row;
        }

        return new ViewModel(array('community' => $returnArray));
    }


}
