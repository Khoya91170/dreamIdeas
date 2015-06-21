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
    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Application\Model\SessionManager;

    class CommunityController extends AbstractActionController
    {
        public function indexAction()
        {
            $id = (int) $this->params()->fromRoute('id', 0);

            $results = array(
                'logged' => SessionManager::sessionExists(),
                'results' => (new Community())->getCommunity($id));
            //$results['logged'] = SessionManager::sessionExists();
           // var_dump($results[0]);
           // die();
            return new ViewModel($results);
        }
        public function addAction(){
            if (!SessionManager::sessionExists())
            {
                return $this->redirect()->toRoute('home');
            }

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
                $idUser = SessionManager::getIdUser();

                if(empty($comment) || empty($idCommunity))
                {
                    $this->redirect()->toRoute('community');
                }
                $community  = new Community();
                $community->addComment($idCommunity, $comment, $idUser);
                return $this->redirect()->toUrl("../community/" . $idCommunity);
            }
        }

        public function addIdeaAction()
        {
            $request = $this->getRequest();
            if ($request->isPost())
            {
                $ideaTitle=  strip_tags(htmlspecialchars($this->getRequest()->getPost('ideaTitle')));
                $ideaDesc =  strip_tags(htmlspecialchars($this->getRequest()->getPost('idea')));

                $idUser = SessionManager::getIdUser();
                $idCommunity = (int) $this->getRequest()->getPost('idCommunity');

                if(empty($ideaTitle) || empty($ideaDesc) || empty($idCommunity))
                {
                    $this->redirect()->toRoute('community');
                }
                $idea  = new Idea();
                $idea->addIdea($ideaTitle, $ideaDesc, $idUser, $idCommunity);
                return $this->redirect()->toUrl("../community/" . $idCommunity);
            }
        }

        public function addIdeaCommentAction()
        {
            $request = $this->getRequest();
            if ($request->isPost())
            {
                $commentIdea=  strip_tags(htmlspecialchars($this->getRequest()->getPost('commentIdea')));
                $idCommunity = (int) $this->getRequest()->getPost('idCommunity');
                $idIdea = (int) $this->getRequest()->getPost('idIdea');
                $idUser = (new SessionManager())->getIdUser();

                if(empty($comment) || empty($idCommunity))
                {
                    $this->redirect()->toRoute('community');
                }
                $idea  = new Idea();
                $idea->addComment($commentIdea, $idIdea, $idUser);
                return $this->redirect()->toUrl("../community/" . $idCommunity);
            }
        }
    }
