<?php

namespace Converterapp;

return array(
'router' => array(
        'routes' => array(
            'converter' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/converter',
                    'defaults' => array(
                        'controller' => 'Converterapp\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                
            ),
 			'webservicex' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/converter/webservicex[:action][/:id]',
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
            
                    'defaults' => array(
                        'controller' => 'Converterapp\Controller\Webservicex',
                        'action'     => 'index',
                    ),
                ),
            ),    
            'kowabunga' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/converter/kowabunga',
                    'defaults' => array(
                        'controller' => 'Converterapp\Controller\Kowabunga',
                        'action'     => 'index',
                    ),
                ),
                
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'converterapp' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/converterapp',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Converterapp\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
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
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Converterapp\Controller\Index' => 'Converterapp\Controller\IndexController',
    		'Converterapp\Controller\Webservicex' => 'Converterapp\Controller\WebservicexController',
    		'Converterapp\Controller\Kowabunga' => 'Converterapp\Controller\KowabungaController',
        ),
    ),
    //setting up view_manager
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'converterapp/index/index' => __DIR__ . '/../view/converterapp/index/index.phtml',
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

