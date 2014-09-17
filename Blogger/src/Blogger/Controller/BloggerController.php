<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blogger\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcUser\Entity;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

use Zend\Paginator\Paginator;

use Blogger\Entity\BloggerPost;
use Blogger\Model\BloggerModel;      
use Blogger\Model\BloggerClass;     
use Blogger\Form\BloggerForm; 
 
class BloggerController extends AbstractActionController
{
	protected $_objectManager;
	protected $entityManager;
 	protected $bloggerTable;
	const maxview = 3;
	const maxvpost = 3;
	
    public function indexAction()
    {
    	/*
    	 *  Authentication needed.
    	 *  View list of Blogger Posts
    	 * 
    	 */
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		  return $this->redirect()->toRoute('zfcuser/login');
    	}
    	
    	/*
    	 * Call of ORM template and create a database connection.
    	 */
    	$blogs = $this->getEntityManager()->getRepository('\Blogger\Entity\BloggerPost')->findAll();

    	/*
    	 * Use paginator standard lib from zend studio
    	 */
    	$adapter = $this->paginator_adapter();
    	$paginator = new Paginator($adapter);
   		$paginator->setDefaultItemCountPerPage(self::maxview);
    	$page = (int)$this->params()->fromRoute('id');
    	    	
    	if($page) $paginator->setCurrentPageNumber($page);
    
    	/*
    	 * Set return values
    	 * $pagiator contains data values
    	 * $view information for the paginator 
    	 */
    	$view =  new ViewModel();
    	$view->setVariable('paginator',$paginator);
    	
    	return new ViewModel(array('blogposts' => $paginator,'view' => $view));;
    	
    }
    
 	 public function addAction()
     {
     /*
    	 *  Authentication needed.
    	 *  View list of Blogger Posts
    	 * 
    	 */
     	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		 $userid = false;
    		 $type = 0;
    	}else{
    		$zfcuser_id =	$this->zfcUserAuthentication()->getIdentity()->getId();
    		$zfcuser_name = $this->zfcUserAuthentication()->getIdentity()->getDisplayname();
    		$userid = $zfcuser_id;
    		$type = 1;
    	}
    	
    	
    	
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	$form = new BloggerForm($dbAdapter,$userid);

        $blogger = new BloggerModel();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
             
             $form->setInputFilter($blogger->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
             	 $blogger->exchangeArray($form->getData());
             	 $blogs = new BloggerPost();
             	 
                 //$blogs->//$this->getAlbumTable()->saveAlbum($album);
                $blogs->setUserid($blogger->userid);
				$blogs->setTitle($blogger->title);
				$blogs->setMessage($blogger->message);
				$blogs->setControl($type);
				$blogs->setCreated(new \DateTime());
               // $blogs->setFullName($this->getRequest()->getPost('fullname'));
                 
                 
                $this->getEntityManager()->persist($blogs);
            	$this->getEntityManager()->flush();
            
            
                 // Redirect to list of albums
                 return $this->redirect()->toRoute('blogger',array('action' => 'view'));
             }
             return new ViewModel(array('blogposts' => $blogs,'form' => $form));
         }
         return array('form' => $form);
     }
    
	public function editAction()
    {
    	/*
    	 *  Authentication needed.
    	 *  View list of Blogger Posts
    	 * 
    	 */
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		  return $this->redirect()->toRoute('zfcuser/login');
    	}
    	
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	$form = new BloggerForm($dbAdapter);
    	
        $id = (int) $this->params()->fromRoute('id', 0);
        $blogs = $this->getEntityManager()->find('\Blogger\Entity\BloggerPost', $id);

        if ($this->request->isPost()) {
            $blogs->setTitle($this->getRequest()->getPost('title'));
			$blogs->setMessage($this->getRequest()->getPost('message'));

            $this->getEntityManager()->persist($blogs);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('blogger',array('action' => 'view'));
        }

        return new ViewModel(array('blogposts' => $blogs,'form' => $form));
    }
    
	public function deleteAction()
    {
    	/*
    	 *  Authentication needed.
    	*  Deleting  of Blogger Posts
    	*
    	*/
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		  return $this->redirect()->toRoute('zfcuser/login');
    	}
    	
        $id = (int) $this->params()->fromRoute('id', 0);
        $blogs = $this->getEntityManager()->find('\Blogger\Entity\BloggerPost', $id);

        if ($this->request->isPost()) {
            $this->getEntityManager()->remove($blogs);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('blogger',array('action' => 'view'));
        }

        return new ViewModel(array('blogposts' => $blogs));
    }
    
	public function viewAction()
	{
		
	// Table gate way.	
	// grab the paginator from the AlbumTable
    //$paginator = $this->getBloggerTable()->fetchAll(true);
    // set the current page to what has been passed in query string, or to 1 if none set
    //$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
    // set the number of items per page to 10
    //$paginator->setItemCountPerPage(self::maxvpost);
;
    
    //return new ViewModel(array('blogposts' => $blogs, 'paginator' => $paginator
    //
    //));
    
		$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$blogs = $this->getEntityManager()->getRepository('\Blogger\Entity\BloggerPost')->findAll();
		
		$users = new BloggerClass($dbAdapter);
		// Optional to use later doctrine settings
		//$users->setDbAdapter($dbAdapter);
		$adapter = $this->paginator_adapter();
    	$paginator = new Paginator($adapter);
   		$paginator->setDefaultItemCountPerPage(self::maxvpost);
    	
   		$page = (int)$this->params()->fromRoute('id');
   		//$page = (int)$this->params()->fromQuery('id');
    	if($page) $paginator->setCurrentPageNumber($page);
    	
    	$view =  new ViewModel();
    	$view->setVariable('paginator',$paginator);
    	
    	return new ViewModel(array('blogposts' => $paginator,'view' => $view,'blogusers'=>$users));
	 
	}

	
	// CategoryRepository.php
	public function getAllinfo()
	{
		/*
		 * INNER JOIN WITH Users 
		 * SELECT * FROM blogger_post INNER JOIN blogger_users ON blogger_post.userid = blogger_users.id
		 * 
		 */
	$query = "SELECT * FROM blogger_post u LEFT JOIN blogger_users a ON u.userid = a.id";	
    return $query;
	}

	public function paginator_adapter(){
		$count=10;
		// Bug in paginator 
	    //$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
	    //$query = $objectManager->createQuery("SELECT DISTINCT u FROM Blogger\Entity\BloggerPost u JOIN Blogger\Entity\BloggerPost p WHERE u.userid =  p.id ")
	    //  ->setHint('knp_paginator.count', $count);
	    //$query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, true);
		//$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		
		$repository = $this->entityManager->getRepository('\Blogger\Entity\BloggerPost');
    	$adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('u')
    	->orderBy('u.id', 'DESC')
    	));
    	
		return $adapter;
	}
	
	protected function setEntityManager(EntityManager $em)
	{
		$this->entityManager = $em;
	    return $this;
	}	
  
  	protected function getEntityManager()
  	{
    	if (null === $this->entityManager) {
    	  $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
    	}
    return $this->entityManager;
  	}
  
	public function getBloggerTable()
    {
        if (!$this->bloggerTable) {
            $sm = $this->getServiceLocator();
            $this->bloggerTable = $sm->get('Blogger\Model\BloggerTable');
        }
        return $this->bloggerTable;
    }
  
}
