<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Community;
use Application\Model\Idea;
use Zend\Session\Container;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $userContainer = new Container('user');
        if ($userContainer->offsetExists('logged'))
        {
            echo "LOGGED";
        }
        else
        {
            echo "NOT LOGGED";
        }
        $userContainer->locale = 'fr-FR';
        $results = array();
        $results['communities'] = (new Community())->getAllCommunities();
        $results['ideas'] = (new Idea())->getAllIdeas();
        return new ViewModel($results);
    }
}
