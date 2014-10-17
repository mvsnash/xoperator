<?php

namespace Xoperator\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController,
     Zend\View\Model\ViewModel,
     Xoperator\EntityTable\Library,
     Xoperator\Form\LibraryForm,
     Xoperator\Model\EntityDoctrineModel;
 
class LibraryController extends AbstractActionController
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
        
        $library = $this->getEntityManager()
                ->getRepository(EntityDoctrineModel::getXopTable('\Library'))
                ->findBy(array(),array('id' => 'DESC'));
        
        
        return new ViewModel(array(
            'librarys' => $library,
        ));
    }

    public function addAction()
    {
        
        $this->is_Logged();
        
        $form = new LibraryForm();
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $library = new Library();
            
            $form->setInputFilter($library->getInputFilter());
            $form->setData($request->getPost());
            
            $data = $request->getPost();
            $File = $this->params()->fromFiles('file_image');
            $data->file_image = $File['name'];        
            //$file_tmp = $File['tmp_name'];            

            $form->setData($data);            
            
            if ($form->isValid()) {
                
                $size = new \Zend\Validator\File\Size(array(
                    'max' => 5000000,
                ));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                //$adapter->setValidators((array($size)), $File['name']);
                $adapter->setValidators((array($size)), $File['name']);
                
                preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|txt|doc|docx){1}$/i", $File['name'], $ext);
                $new_name_image = md5(uniqid(time())) . "." . $ext[1];
                
                $adapter->addFilter('Rename', __xopUPLOADS__.'/'.$new_name_image.'');
                
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('file_image' => $error));
                } else {
                    $directory = $request->getServer('DOCUMENT_ROOT', false);                  
                    
                    //$adapter->setDestination(__xopUPLOADS__);                    
                                    
                    if ($adapter->receive($File['name'])) {
                    }
                    $dataPost = $form->getData();
                    $getDataPost = array(
                        'file_name'     => $dataPost['file_name'],
                        'file_image'    => $new_name_image,
                        'description'   => $dataPost['description']
                        );
                    $library->populate($getDataPost);
                    $this->getEntityManager()->persist($library);
                    $this->getEntityManager()->flush();
                }                
                
                // Redirect to list of library
                return $this->redirect()->toRoute('library');
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
            $this->redirect()->toRoute('library', array('action'=>'add'));
        }
        
        $library = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Library'), $id);
 
        $form = new LibraryForm();
        $form->setBindOnValidate(false);
        $form->bind($library);
        $form->get('submit')->setAttribute('label', 'Salvar');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
 
                // Redirect to list of albums
                return $this->redirect()->toRoute('library');
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
        
        $library = $this->getEntityManager()->find(EntityDoctrineModel::getXopTable('\Library'), $id);
        if($library){
            
            $library_head_file = $this->getEntityManager()
                    ->getRepository(EntityDoctrineModel::getXopTable('\Library'))
                    ->findBy(array('id' => $id));
            
            $image_file = null;
            foreach($library_head_file as $ar):
                $image_file_dir = $ar->file_image;
            endforeach;            
            if($image_file_dir == null){
                $image_file = '<div class="alert alert-dismissable alert-danger">Não foi apagado arquivos: </div>';
            }else{
                $image_file = '<div class="alert alert-dismissable alert-success">Arquivo apagado: '.$image_file_dir.'</div>';
            }
            
            array_map('unlink', glob('./data/uploads/'.$image_file_dir));
            
            $this->getEntityManager()->remove($library);
            $this->getEntityManager()->flush();
        }
        
         //return $this->redirect()->toRoute('library');
        
        return new ViewModel(
                array(
                 'image_file' => $image_file,
                ));
    }
    
 }
