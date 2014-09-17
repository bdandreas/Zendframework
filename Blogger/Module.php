<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blogger;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Facebook\FacebookSession;
use Blogger\Model\BloggerModel;
use Blogger\Model\BloggerTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	$sm = $e->getApplication()->getServiceManager();
    	
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // Load translator
        $translator = $sm->get('translator');
        $translator->setLocale('en_EN');
        
        FacebookSession::setDefaultApplication('xx', 'xxx');
        
        
		

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
        	
	       'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    //
    // Gateway for mysql 
    //
    /*
     * @contact
     * */
     
    public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Blogger\Model\BloggerTable' =>  function($sm) {
                     $tableGateway = $sm->get('BloggerTableGateway');
                     $table = new BloggerTable($tableGateway);
                     return $table;
                 },
                 'BloggerTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new BloggerModel());
                     return new TableGateway('blogger_posts', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
    
}
