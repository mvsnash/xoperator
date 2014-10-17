<?php
namespace Xoperator;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Site\Module as ModuleSite;
use Zend\Authentication\AuthenticationService;

 class Module
 {
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
     public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        define('__xopVERSION__','1.0.1');
        
        define('__xopFOLDERsettings__',__DIR__ . '/config/settings/');
        
        define('__xopROOT__', ''.__DIR__.'/../..');
        
        return include __DIR__ . '/config/settings/xoperator.config.php';
    }    
     
    //layout for each module
    public function init(ModuleManager $mm)
    {
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
        'dispatch', function($e) {
            $e->getTarget()->layout('xoperator/layout');
        });
    }
    
     public function getServiceConfig()
     {
         return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
     }
     
 }