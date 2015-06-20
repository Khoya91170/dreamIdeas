<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 09/06/2015
 * Time: 12:01
 */

namespace Application\Controller;

use Application\Model\Register;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController{

    public function indexAction()
    {
        return new ViewModel();
    }


    public function addUserAction()
    {
        $request = $this->getRequest();
        if ($request->isPost())
        {
            //Récupère les données
            $login =  $this->getRequest()->getPost('login');
            $password = $this->getRequest()->getPost('pass');
            $type = $this->getRequest()->getPost('type');

            // Insertion des données
            // Définition des parametres de la base de données
            if (trim($login) == '' || trim($password) == '' || trim($type) == '')
            {
                $this->redirect()->toRoute('register');
            }
            else
            {
                return new ViewModel((new Register())->addUser($login, $password, $type));
            }
        }
        return;
    }

}