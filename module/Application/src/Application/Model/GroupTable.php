<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 09/06/2015
 * Time: 10:51
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class GroupTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

}