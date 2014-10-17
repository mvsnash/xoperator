<?php

namespace Xoperator\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController,
     Zend\View\Model\ViewModel,
     Xoperator\EntityTable\LinksMenus,
     Xoperator\Form\LinksMenusForm,
     Xoperator\EntityTable\Menus,
     Xoperator\Form\MenusForm,
     Xoperator\Model\EntityDoctrineModel;
 
class MenusController extends AbstractActionController
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

        $menus = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Menus'))
                ->findBy(array(),array('id' => 'DESC'));
        
        
        return new ViewModel(array(
            'menus' => $menus,
        ));
    }

    public function addAction()
    {
        
        $this->is_Logged();
        
        $form = new MenusForm();
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {            
            
            $data_form = $request->getPost();
            $user_count = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Menus'))
                ->findBy(array('menu'=>$data_form['menu']));
                
            if(count($user_count) > 1){
                    $this->flashMessenger()->addMessage('Menu '.$data_form['menu'].', já foi cadastrado');
            }else{
            
                $menus = new Menus();

                $form->setInputFilter($menus->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                        $menus->populate($form->getData());
                        $this->getEntityManager()->persist($menus);
                        $this->getEntityManager()->flush();
                        // Redirect to list of albums
                        return $this->redirect()->toRoute('menus');
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
            $this->redirect()->toRoute('menus', array('action'=>'add'));
        }
        
        $menus = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Menus'), $id);
 
        $form = new MenusForm();
        $form->setBindOnValidate(false);
        $form->bind($menus);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {            
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
 
                // Redirect to list of albums
                return $this->redirect()->toRoute('menus');
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
        
        $user = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Menus'), $id);
        if($user){
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();
        }
        
         return $this->redirect()->toRoute('menus');
    }
    
    public function addLinkMenuAction(){
    
        $this->is_Logged();
        
        //
        $param_id = (int) isset($_GET['link-menu'])?$_GET['link-menu']:NULL;
        
        //show menus
        $menus = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Menus'))
                ->findBy(array(),array('id' => 'DESC'));
        
        if($param_id){
            return $this->redirect()->toRoute('menus',array('action'=>'add-link','id'=>$param_id));
        }
        
        return new ViewModel(
                array(
                    'param' => $param_id,
                    'menus' => $menus,
                ));
    }
    public function addLinkAction(){
        
        $this->is_Logged();
        
        $id_menu = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        
        //show menus
        $menu_sel = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Menus'))
                ->findBy(array('id'=>$id_menu));
 
        $form = new LinksMenusForm();
        $form->get('id_menu')->setAttribute('value', $id_menu);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {

            $linksmenus = new LinksMenus();

            $form->setInputFilter($linksmenus->getInputFilter());
            $form->setData($request->getPost());
              if ($form->isValid()) {
                  $linksmenus->populate($form->getData());
                  $this->getEntityManager()->persist($linksmenus);
                  $this->getEntityManager()->flush();
                  // Redirect to list of albums
                  return $this->redirect()->toRoute('menus');
           }
        }
        
        return new ViewModel(
                array(
                    'form'  => $form,
                    'flashmessenger' => $this->flashMessenger()->getMessages(),
                    'menu_selected'=>$menu_sel,
                ));
    }
    
    public function editLinkAction()
    {
        
        $this->is_Logged();
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        
     
        if (!$id) {
            $this->redirect()->toRoute('menus', array('action'=>'editLink'));
        }
        
        $linksmenus = $this->getEntityManager()
                ->find(EntityDoctrineModel::getXopTable('\LinksMenus'), $id);
 
        $form = new LinksMenusForm();
        $form->setBindOnValidate(false);
        $form->bind($linksmenus);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {            
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
 
                // Redirect to list of albums
                return $this->redirect()->toRoute('menus');
            }
        }
 
        return array(
            'id' => $id,
            'form' => $form,
            'flashmessenger' => $this->flashMessenger()->getMessages(),
            'menu_selected'=>$menu_sel,
        );
    }
    
 }