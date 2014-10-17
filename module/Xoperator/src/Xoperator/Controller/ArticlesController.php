<?php

namespace Xoperator\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController,
     Zend\View\Model\ViewModel,
     Xoperator\EntityTable\Articles,
     Xoperator\Form\ArticlesForm,
     Xoperator\Model\EntityDoctrineModel;
 
class ArticlesController extends AbstractActionController
 {
    
    //-->@important from DOCTRINE--->
    protected $em;
    
    public function getEntityManager() {
        if (null == $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }    
    //<--@important from DOCTRINE<---
    
    //return true if be logged in all controllers
    public function is_Logged($redirect=true){
        if ($this->getServiceLocator()
                 ->get('Zend\Authentication\AuthenticationService')->hasIdentity()){    
            return true;
        }else{
            if($redirect == true){
                $this->redirect()->toRoute('login');
            }
        }
    }
    
    public function indexAction() {
        
        $this->is_Logged();        
        
        $articles = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Articles'))
                ->findBy(array(),array('id' => 'DESC'));
        
        
        return new ViewModel(array(
            'articles' => $articles,
        ));
    }

    public function addAction()
    {
        
        $this->is_Logged();
        
        
        $form = new ArticlesForm();
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $article = new Articles();
            
            $form->setInputFilter($article->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $article->populate($form->getData());
                $this->getEntityManager()->persist($article);
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('articles');
            }
        }
        
        return new ViewModel(array(
            'form'  => $form,
        ));
        
    }
    
    public function editAction()
    {
        $this->is_Logged();        
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        
     
        if (!$id) {
            $this->redirect()->toRoute('articles', array('action'=>'add'));
        }
        
        $articles = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Articles'), $id);
 
        $form = new ArticlesForm();
        $form->setBindOnValidate(false);
        $form->bind($articles);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
 
                // Redirect to list of albums
                return $this->redirect()->toRoute('articles');
            }
        }
 
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        
         $this->is_Logged();        
        
        $id = (int) $this->params()->fromRoute('id',0);
        if ($id == 0) {
            throw new \Exception('ID obligatory');
        }
        
        $articles = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Articles'), $id);
        if($articles){
            $this->getEntityManager()->remove($articles);
            $this->getEntityManager()->flush();
        }
        
         return $this->redirect()->toRoute('articles');
    }
    
 }