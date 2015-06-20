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
    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;

    class CommunityController extends AbstractActionController
    {
        public function indexAction()
        {
            $id = (int) $this->params()->fromRoute('id', 0);
            return new ViewModel((new Community())->getCommunity($id));
        }
        public function addAction(){
            $request = $this->getRequest();
            if ($request->isPost())
            {
                //Récupère les données
                $nameCommunity =  $this->getRequest()->getPost('name');
                $descriptionCommunity = $this->getRequest()->getPost('desc');

                // Insertion des données
                // Définition des parametres de la base de données
                if (trim($nameCommunity) != '' && trim($descriptionCommunity) != '')
                {
                    return new ViewModel((new Community())->addCommunity($nameCommunity, $descriptionCommunity));
                }
            }
            return;
        }
    }
