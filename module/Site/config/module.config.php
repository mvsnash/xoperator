<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Site;

return array(
    'router' => array(
        'routes' => array(            
        
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Site\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'article' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/article[/][:article]',
                     'constraints' => array(
                         //aceita letra e numeros
                         'article'     => '[i|0-9a-zA-Z_-]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Site\Controller\Index',
                         'action'     => 'article',
                     ),
                 ),
             ),
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /site/:controller/:action
            'site' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/site',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Site\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
//                'may_terminate' => true,
//                'child_routes' => array(
//                    'default' => array(
//                        'type'    => 'Segment',
//                        'options' => array(
//                            'route'    => '/[:controller[/:action]]',
//                            'constraints' => array(
//                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                            ),
//                        ),
//                    ),
//                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        //'locale' => 'en_US',//antes
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => 'pt_BR.mo',
                //'pattern'  => '%s.mo',//antes
            ),
        ),
    ),
    
    //definition controllers of the site
    'controllers' => array(
        'invokables' => array(
            'Site\Controller\Index' => 'Site\Controller\IndexController',
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'Site/index/index' => __DIR__ . '/../view/site/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    
);
