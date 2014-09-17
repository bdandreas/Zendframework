<?php

namespace Blogger;

return array(
	'bloggerauth' => array('authentication'=>'zfs'),

	'router' => array(
	         'routes' => array(
	          
            	'blogger' => array(
	                 'type'    => 'segment',
	                 'options' => array(
	                     'route'    => '/blogger[/][:action][/:id]',
	                     'constraints' => array(
	                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
	                         'id'     => '[0-9]+',
	                     ),
	                     'defaults' => array(
	                         'controller' => 'Blogger\Controller\Blogger',
	                         'action'     => 'view',
	                     ),
	                 ),
	             ),
	             'blogger-author' => array(
	                 'type'    => 'segment',
	                 'options' => array(
	                     'route'    => '/blogger-author[/][:action][/:id]',
	                     'constraints' => array(
	                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
	                         'id'     => '[0-9]+',
	                     ),
	                     'defaults' => array(
	                         'controller' => 'Blogger\Controller\BloggerUsers',
	                         'action'     => 'index',
	                     ),
	                 ),
	             ),
		
	         ),
	     ),

	
	'bloggerauth' => array (
	     'dbdriver' => array(
	     	'adapter' => true,
	     	'doctrine' => true,
	     	),
	     'auth' => array(
	     	'zfcuser' => true,
	     	'blogger' => true,
	     	),	
	     ),         
	     
 	'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Blogger/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Blogger\Entity' => 'application_entities'
                )
            )
        )
    ),		
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action

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
            'Blogger\Controller\Index' => 'Blogger\Controller\IndexController',
    		'Blogger\Controller\Blogger' => 'Blogger\Controller\BloggerController',
    		'Blogger\Controller\BloggerUsers' => 'Blogger\Controller\BloggerUsersController',
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
            'Blogger/index/index' => __DIR__ . '/../view/blogger/index/index.phtml',
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

