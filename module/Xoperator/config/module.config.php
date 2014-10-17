<?php

namespace Xoperator;

use Zend\Session\Config\SessionConfig,
    Zend\Session\Container,
    Zend\Session\SessionManager;

return array(
     'controllers' => array(
         'invokables' => array(
             'Xoperator\Controller\Xoperator\Index' => 'Xoperator\Controller\IndexController',
             'Xoperator\Controller\Xoperator\Articles' => 'Xoperator\Controller\ArticlesController',
             'Xoperator\Controller\Xoperator\Users' => 'Xoperator\Controller\UsersController',
             'Xoperator\Controller\Xoperator\Library' => 'Xoperator\Controller\LibraryController',
             'Xoperator\Controller\Xoperator\Settings' => 'Xoperator\Controller\SettingsController',
             'Xoperator\Controller\Xoperator\Menus' => 'Xoperator\Controller\MenusController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'xoperator' => array(
                 'type'    => 'literal',
                 'options' => array(
                     'route'    => '/xoperator',
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Index',
                         'action'     => 'index',
                     ),
                 ),
             ),
             
             'login' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/login',
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Index',
                         'action'     => 'login',
                     ),
                 ),
             ),
             
             'logout' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/logout',
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Index',
                         'action'     => 'logout',
                     ),
                 ),
             ),
             
             'articles' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/articles[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Articles',
                         'action'     => 'index',
                     ),
                 ),
             ),
             
             'users' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/users[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Users',
                         'action'     => 'index',
                     ),
                 ),
             ),
             
             'gallery' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/gallery[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Gallery',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'library' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/library[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Library',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'settings' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/settings[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Settings',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'menus' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/xoperator/menus[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Xoperator\Controller\Xoperator\Menus',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
        'doctype' => 'HTML5',
        'template_map' => array(
            //layout for each module that comes from Module.php
            'xoperator/layout' => __DIR__ . '/../view/layout/xoperador.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
        ),
        'template_path_stack' => array(
            'xoperator' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'SessionXop' => function($sm) {
                $nameSession = 'xop_SESSION';
                $config = array(
                    'remember_me_seconds' => 4,
                    'use_cookies'       => true,
                    'cookie_httponly'   => true,
                    'cookie_lifetime'   => 6,
                );
                $sessionConfig = new SessionConfig();
                $sessionConfig->setOptions($config);
                $sessionManager = new SessionManager($sessionConfig);
                $sessionManager->start();
                Container::setDefaultManager($sessionManager);
                return  new \Zend\Session\Container($nameSession);            
            },
            'Cache' => function($sm) {
                $config = $sm->get('Configuration');
                $cache = StorageFactory::factory(
                    array(
                        'adapter' => $config['cache']['adapter'],
                        'plugins' => array(
                            'exception_handler' => array('throw_exceptions' => false),
                            'Serializer'
                        ),
                    )
                );
 
                return $cache;
            },
            'Doctrine\ORM\EntityManager' => function($sm) {
                $config = $sm->get('Configuration');
                
                $doctrineConfig = new \Doctrine\ORM\Configuration();
                $cache = new $config['doctrine']['driver']['cache'];
                $doctrineConfig->setQueryCacheImpl($cache);
                $doctrineConfig->setProxyDir('/tmp');
                $doctrineConfig->setProxyNamespace('EntityProxy');
                $doctrineConfig->setAutoGenerateProxyClasses(true);
                
                $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
                    new \Doctrine\Common\Annotations\AnnotationReader(),
                    array($config['doctrine']['driver']['paths'])
                );
                $doctrineConfig->setMetadataDriverImpl($driver);
                $doctrineConfig->setMetadataCacheImpl($cache);
                \Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
                    getenv('PROJECT_ROOT'). 'vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
                );
                $em = \Doctrine\ORM\EntityManager::create(
                    $config['doctrine']['connection'],
                    $doctrineConfig
                );
                return $em;
 
            },
        )    
    ),
    'doctrine' => array(
        'driver' => array(
            
            'cache' => 'Doctrine\Common\Cache\ArrayCache',
            'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/EntityTable')
          ),
         'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Xoperator\EntityTable\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
            ),
        ),
    ),    
 );