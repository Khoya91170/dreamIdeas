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

class IndexController extends AbstractActionController
{
    protected $communityTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'communities' => $this->getCommunityTable()->fetchAll(),
        ));
    }

    public function getCommunityTable()
    {
        if (!$this->communityTable) {
            $sm = $this->getServiceLocator();
            $this->communityTable = $sm->get('Application\Model\CommunityTable');
        }
        return $this->communityTable;
    }


}
