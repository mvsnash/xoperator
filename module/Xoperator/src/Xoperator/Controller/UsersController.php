<?php

namespace Xoperator\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController,
     Zend\View\Model\ViewModel,
     Xoperator\EntityTable\User,
     Xoperator\Form\UserForm,
     Xoperator\Model\EntityDoctrineModel;
 
class UsersController extends AbstractActionController
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

        $user = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\User'))
                ->findBy(array(),array('id' => 'DESC'));
        
        
        return new ViewModel(array(
            'users' => $user,
        ));
    }

    public function addAction()
    {
        
        $this->is_Logged();
        
        $form = new UserForm();
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {            
            
            $data_form = $request->getPost();
            $user_count = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\User'))
                ->findBy(array('email'=>$data_form['email']));
                
            if(count($user_count) > 1){
                    $this->flashMessenger()->addMessage('E-mail '.$data_form['email'].', já foi cadastrado');
            }else{
            
                $user = new User();

                $form->setInputFilter($user->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                        $user->populate($form->getData());
                        $this->getEntityManager()->persist($user);
                        $this->getEntityManager()->flush();
                        // Redirect to list of albums
                        return $this->redirect()->toRoute('users');
                }
            }
        }
        
        return new ViewModel(array(
            'form'  => $form,
            'flashmessenger' => $this->flashMessenger()->getMessages(),
        ));
        
    }
    
    public function editAction()
    {
        
        $this->is_Logged();
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        
     
        if (!$id) {
            $this->redirect()->toRoute('users', array('action'=>'add'));
        }
        
        $user = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\User'), $id);
 
        $form = new UserForm();
        $form->setBindOnValidate(false);
        $form->bind($user);
        
        $pass = null;
        $useron = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\User'))
                ->findBy(array('id'=>$id));
        $xopencrypt = new \Xoperator\Xcore\XopEncrypt();
        foreach ($useron as $us){
            $pass = $xopencrypt->toDecrypt($us->password);
        }
        $form->get('password')->setAttribute('value', $pass);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {            
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
 
                // Redirect to list of albums
                return $this->redirect()->toRoute('users');
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
        
        $user = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\User'), $id);
        if($user){
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();
        }
        
         return $this->redirect()->toRoute('users');
    }
    
 }