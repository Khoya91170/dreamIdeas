<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 21/06/2015
 * Time: 01:02
 */

namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class LayoutController
{
    public function indexAction()
    {
        $userContainer = new Container('user');
        $results = array();
        $results['logged'] = $userContainer->offsetExists('logged');
        if ($results['logged'])
        {
            echo "LOGGED";
        }
        else
        {
            echo "NOT LOGGED";

        }

        return new ViewModel($results);
    }
}