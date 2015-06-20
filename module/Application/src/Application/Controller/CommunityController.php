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
            $request = $this->getRequest();
            if($request->isPost()){
                //Récupère les données
                //$communityId =  $this->getRequest()->getPost('communityId', null);
                $communityId = $this->params()->fromQuery('id_Community', null);
                if($communityId != null)
                {
                    return new ViewModel((new Community())->getCommunity($communityId));
                }
            }
        }
    }
