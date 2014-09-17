<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Converterapp;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Facebook\FacebookSession;

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
        $translator->setLocale('nl_NL');
        
        FacebookSession::setDefaultApplication('542469915899430', '569ba871001ac6a159561b612e3e6c57');
        
        
		

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
     * 
     
    public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Application\Model\ContactTable' =>  function($sm) {
                     $tableGateway = $sm->get('ContactTableGateway');
                     $table = new ContactTable($tableGateway);
                     return $table;
                 },
                 'ContactTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Contact());
                     return new TableGateway('tbl_contact', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
    */
}
