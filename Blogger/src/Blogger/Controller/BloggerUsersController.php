<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blogger\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Zend\Db\Adapter\Adapter;
use ZfcUser\Entity;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use Blogger\Model\BloggerUsersModel;
use Blogger\Form\BloggerUsersForm;
use Blogger\Entity\BloggerUsers;

class BloggerUsersController extends AbstractActionController
{
    protected $_objectManager;
    protected $adapter;
    const maxview = 2;

    public function __construct()
    {
    }

    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $view = new ViewModel();
        $blogs_users = $this->getObjectManager()->getRepository('\Blogger\Entity\BloggerUsers')->findAll();
        $adapter = $this->paginator_adapter();
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(self::maxview);

        $page = (int)$this->params()->fromRoute('id');
        //$page = (int)$this->params()->fromQuery('page');
        if ($page) $paginator->setCurrentPageNumber($page);

        $view->setVariable('paginator', $paginator);
        return new ViewModel(array('blogusers' => $paginator, 'view' => $view));;
    }

    public function addAction()
    {
        // Private section 
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $form = new BloggerUsersForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $blogger = new BloggerUsersModel();
            $form->setInputFilter($blogger->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $blogger->exchangeArray($form->getData());

                if (isset($blogger)) {
                    $blogs = new BloggerUsers();
                    $blogs->setName($blogger->name);
                    $blogs->setEmail($blogger->email);
                    $blogs->setCreated(new \DateTime());
                    $this->getObjectManager()->persist($blogs);
                    $this->getObjectManager()->flush();
                }

                // Redirect to list of authors
                return $this->redirect()->toRoute('blogger-author', array('action' => 'index'));
            }
            return new ViewModel(array('blogusers' => $blogs, 'form' => $form));
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        // Private section 
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $form = new BloggerUsersForm();

        $id = (int)$this->params()->fromRoute('id', 0);
        $blogs = $this->getObjectManager()->find('\Blogger\Entity\BloggerUsers', $id);
        $request = $this->getRequest();

        if ($request->isPost()) {

            $blogger = new BloggerUsersModel();
            $form->setInputFilter($blogger->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $blogger->exchangeArray($form->getData());
                $blogs->setName($blogger->name);
                $blogs->setEmail($blogger->email);
                $blogs->setCreated(new \DateTime());
                $this->getObjectManager()->persist($blogs);
                $this->getObjectManager()->flush();

                return $this->redirect()->toRoute('blogger-author', array('action' => 'index'));
            }
            return new ViewModel(array('blogusers' => $blogs, 'form' => $form));
        }
        return new ViewModel(array('blogusers' => $blogs, 'form' => $form));

    }

    public function deleteAction()
    {
        // Private section 
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $id = (int)$this->params()->fromRoute('id', 0);
        $blogs = $this->getObjectManager()->find('\Blogger\Entity\BloggerUsers', $id);

        if ($this->request->isPost()) {
            $this->getObjectManager()->remove($blogs);
            $this->getObjectManager()->flush();
            return $this->redirect()->toRoute('blogger-author', array('action' => 'index'));
        }
        return new ViewModel(array('blogusers' => $blogs));
    }

    public function viewAction()
    {
        return $this->indexAction();
    }

    protected function paginator_adapter()
    {
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $repository = $entityManager->getRepository('\Blogger\Entity\BloggerUsers');
        $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('u')
            ->orderBy('u.created', 'DESC')
        ));
        return $adapter;
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->_objectManager;
    }
}
