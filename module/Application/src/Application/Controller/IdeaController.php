<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 21/06/2015
 * Time: 03:04
 */


namespace Application\Controller;

use Application\Model\Idea;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\SessionManager;

class IdeaController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toRoute('home');
    }

    public function addAction()
    {
        if (!SessionManager::sessionExists())
        {
            return $this->redirect()->toRoute('home');
        }

        return;
    }
}