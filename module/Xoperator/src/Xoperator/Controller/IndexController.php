<?php

namespace Xoperator\Controller;

 
use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Xoperator\Form\LoginForm,
    Xoperator\EntityTable\User,
    Xoperator\Form\UserForm,
    Xoperator\Model\EntityDoctrineModel,
    Zend\Authentication\Result,
    Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
 {
     
    //importante para controlar permissão
    public function setSession($value)
    {           
        $xop_session = $this->getServiceLocator()->get('SessionXop');
        $xop_session->xopuserSESSION = $value;
    }
    
    public function getSessionUser()
    {
        $xop_session = $this->getServiceLocator()->get('SessionXop');
        return $xop_session->xopuserSESSION;
    } 
    //importante para controlar permissão<--
    
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
    
    public function logoutAction()
    {       
        $xop_session = $this->getServiceLocator()->get('SessionXop');
        $xop_session->getManager()->getStorage()->clear('userxop');
        
        $auth = new AuthenticationService();
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute('login');
    } 
    
     
    public function indexAction() {
        
        $this->is_Logged();
        
        $usuario = $this->getSessionUser();  
               
        return new ViewModel(array(
                    'usuario'   => $usuario,
                ));
    }
    public function loginAction()
    {        
        if ($this->is_Logged(false)){
            $this->redirect()->toRoute('xoperator');
        }
        
        $message_login = '';
        
        $form = new LoginForm();
        $form->get('submit')->setAttribute('label', 'Entrar');
        
        $request = $this->getRequest();
        $dataPost = $request->getPost();
        if ($request->isPost()) {          
            
            $xopencrypt = new \Xoperator\Xcore\XopEncrypt();
            
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($dataPost['email']);
            
            $user_pass = $this->getEntityManager()->getRepository(EntityDoctrineModel::getXopTable('\User'))
                ->findBy(array('email'=>$dataPost['email']));
            $pass_user_for = null;
            foreach($user_pass as $arr_u_p):
                $pass_user_for = $arr_u_p->password;
            endforeach;
            $pass_user_bd = $pass_user_for = null ? $dataPost['password']:$pass_user_for;
            
            if(!$pass_user_bd == ""){
                if($dataPost['password'] === $xopencrypt->toDecrypt($pass_user_bd)){
                    
                    $adapter->setCredentialValue($pass_user_bd);
                    $authResult = $authService->authenticate($adapter);
                    if ($authResult->isValid()) {
                        $xop_session = $this->setSession($adapter->getIdentity());
                        return $this->redirect()->toRoute('xoperator');
                    }
                }else{
                   $message_login = '<div class="alert alert-dismissable alert-danger">E-mail ou Senha não confere</div>'; 
                }
            }
            else if(!$dataPost['email'] == ""){
                $adapter->setCredentialValue($dataPost['password']);
                $authResult = $authService->authenticate($adapter);
                switch ($authResult->getCode()) {

                    case Result::FAILURE_IDENTITY_NOT_FOUND:
                        $message_login = '<div class="alert alert-dismissable alert-danger">Identificação inválida!</div>';
                        break;

                    case Result::FAILURE_CREDENTIAL_INVALID:
                        $message_login = '<div class="alert alert-dismissable alert-danger">Senha incorreta!</div>';
                        break;

                    case Result::SUCCESS:
                        /** do stuff for successful authentication * */
                        break;

                    default:
                        $message_login = '<div class="alert alert-dismissable alert-danger">Digite seus dados corretamente!</div>';
                        break;
                }
            }
            
        }       
        
        $result = new ViewModel(array(
            'message_login'      => $message_login,
            'form'  => $form,
        ));
        //excluir layout
        $result->setTerminal(true);
        return $result;
    }

 }