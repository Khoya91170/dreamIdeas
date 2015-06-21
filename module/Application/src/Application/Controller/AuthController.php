<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;
use Application\Model\User;
use Application\Model\SessionManager;
use Application\Model\DbAdapterConfig;
use Zend\Db\Sql\Sql;

class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }

        return $this->authservice;
    }

    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Application\Model\MyAuthStorage');
        }

        return $this->storage;
    }

    public function getForm()
    {
        if (! $this->form) {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }

        return $this->form;
    }

    public function loginAction()
    {
        //if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }

        $form       = $this->getForm();

        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }

    public function authenticateAction()
    {

        $form       = $this->getForm();
        $redirect = 'login';

        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential(sha1($request->getPost('password')));

                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }


                if ($result->isValid()) {
                    $redirect = 'home';

                    $dbAdapter = new Adapter(DbAdapterConfig::getDbAdapter());
                    $sql = new Sql($dbAdapter);

                    $select = $sql->select();
                    $select->from('user',
                                  'id_user')
                            ->where("login = '" .  $request->getPost('username') . "'");
                    $statement = $sql->prepareStatementForSqlObject($select);
                    $result = $statement->execute();

                    $returnArray = array();
                    foreach ($result as $row) {
                        $returnArray[] = $row;
                    }

                    SessionManager::setLogin($request->getPost('username'));
                    SessionManager::setIdUser($returnArray[0]['id_user']);

                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //set storage again
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    $this->getAuthService()->getStorage()->write($request->getPost('username'));
                }
            }
        }

        return $this->redirect()->toRoute($redirect);
    }

    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        SessionManager::destroy();
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('home');
    }
}