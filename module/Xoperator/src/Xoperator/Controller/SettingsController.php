<?php

namespace Xoperator\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController,
     Zend\View\Model\ViewModel;
 
class SettingsController extends AbstractActionController
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
        
        $binsettings = new \Xoperator\Model\Settings;
        $settings_global = $binsettings->openFileSettings('xoperator.config.php');
        $set_replace = str_replace(
                array("<?php","define(",",",")","'",";"),
                array("","#"," ==> ","",""),
                $settings_global
                );
        
        return new ViewModel(array(
            'settings_global' => $set_replace,
        ));
    }

    public function addAction()
    {
        
        $this->is_Logged();
        
        $form = new UserForm();
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
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
        
        return new ViewModel(array(
            'form'  => $form,
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