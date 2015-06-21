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


                if (trim($nameCommunity) != '' && trim($descriptionCommunity) != '')
                {
                    (new Community())->addCommunity($nameCommunity, $descriptionCommunity);
                    return $this->redirect()->toRoute('home');
                }
            }
            return;
        }

        public function addCommentAction()
        {
            $request = $this->getRequest();
            if ($request->isPost())
            {
                $comment =  strip_tags(htmlspecialchars($this->getRequest()->getPost('comment')));
                $idCommunity = (int) $this->getRequest()->getPost('idCommunity');
                $idUser = 1;

                if(empty($comment) || empty($idCommunity))
                {
                    $this->redirect()->toRoute('community');
                }
                $community  = new Community();
                $community->addComment($idCommunity, $comment, $idUser);
                return $this->redirect()->toUrl("../community/" . $idCommunity);
            }
        }

        public function addIdeaAction($aCommunityId, $aIdea)
        {
            $request = $this->getRequest();
            if ($request->isPost())
            {

            }
        }

        public function addIdeaCommentAction($aIdeaId, $aComment)
        {
            $request = $this->getRequest();
            if ($request->isPost())
            {

            }
        }
    }
