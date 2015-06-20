<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 09/06/2015
 * Time: 12:01
 */

namespace Application\Controller;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class RegisterController extends AbstractActionController{

    public function indexAction()
    {
        return new ViewModel();
    }


    public function addUserAction(){
        $request = $this->getRequest();
        if($request->isPost()){

            //Récupère les données
            $login =  $this->getRequest()->getPost('login');
            //$this->layout()->login = $this ->getRequest()->getPost('login');

            $password = $this->getRequest()->getPost('pass');
            $password = sha1($password);
           // $this->layout()->password = $this ->getRequest()->getPost('pass');

            // Insertion des données
            // Définition des parametres de la base de données
            if($login =='' || $password ==''){
                $this->redirect()->toRoute('register');
            }
            else{
                $dbAdapterConfig = array(
                    'driver'   => 'Pdo_mysql',
                    'database' => 'zend_test',
                    'username' => 'root',
                    'password' => 'root'
                );
                $dbAdapter = new Adapter($dbAdapterConfig);
                $sql = new Sql($dbAdapter);

                $insert = $sql->insert('users'); // Définition de la table concernée
                $newData = array(
                    'username'=> $login,
                    'password'=> $password
                );
                $insert->values($newData);
                $statement = $sql->prepareStatementForSqlObject($insert);
                $result = $statement->execute();
            }






        }



        return;

    }

}