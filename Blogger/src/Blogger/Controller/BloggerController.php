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

        if ($page) $paginator->setCurrentPageNumber($page);

        /*
         * Set return values
         * $pagiator contains data values
         * $view information for the paginator 
         */
        $view = new ViewModel();
        $view->setVariable('paginator', $paginator);

        return new ViewModel(array('blogposts' => $paginator, 'view' => $view));;

    }

    public function addAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $userid = false;
            $type = 0;
        } else {
            $zfcuser_id = $this->zfcUserAuthentication()->getIdentity()->getId();
            $zfcuser_name = $this->zfcUserAuthentication()->getIdentity()->getDisplayname();
            $userid = $zfcuser_id;
            $type = 1;
        }

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new BloggerForm($dbAdapter, $userid);

        $blogger = new BloggerModel();

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter($blogger->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $blogger->exchangeArray($form->getData());
                $blogs = new BloggerPost();
                $blogs->setUserid($blogger->userid);
                $blogs->setTitle($blogger->title);
                $blogs->setMessage($blogger->message);
                $blogs->setControl($type);
                $blogs->setCreated(new \DateTime());
                $this->getEntityManager()->persist($blogs);
                $this->getEntityManager()->flush();

                return $this->redirect()->toRoute('blogger', array('action' => 'view'));
            }
            return new ViewModel(array('blogposts' => $blogs, 'form' => $form));
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new BloggerForm($dbAdapter);

        $id = (int)$this->params()->fromRoute('id', 0);
        $blogs = $this->getEntityManager()->find('\Blogger\Entity\BloggerPost', $id);

        if ($this->request->isPost()) {
            $blogs->setTitle($this->getRequest()->getPost('title'));
            $blogs->setMessage($this->getRequest()->getPost('message'));

            $this->getEntityManager()->persist($blogs);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('blogger', array('action' => 'view'));
        }

        return new ViewModel(array('blogposts' => $blogs, 'form' => $form));
    }

    public function deleteAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $id = (int)$this->params()->fromRoute('id', 0);
        $blogs = $this->getEntityManager()->find('\Blogger\Entity\BloggerPost', $id);

        if ($this->request->isPost()) {
            $this->getEntityManager()->remove($blogs);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('blogger', array('action' => 'view'));
        }

        return new ViewModel(array('blogposts' => $blogs));
    }

    public function viewAction()
    {

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $blogs = $this->getEntityManager()->getRepository('\Blogger\Entity\BloggerPost')->findAll();

        $users = new BloggerClass($dbAdapter);
        $adapter = $this->paginator_adapter();
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(self::maxvpost);

        $page = (int)$this->params()->fromRoute('id');
        if ($page) $paginator->setCurrentPageNumber($page);

        $view = new ViewModel();
        $view->setVariable('paginator', $paginator);

        return new ViewModel(array('blogposts' => $paginator, 'view' => $view, 'blogusers' => $users));

    }

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

    public function paginator_adapter()
    {
        $count = 10;
        $repository = $this->entityManager->getRepository('\Blogger\Entity\BloggerPost');
        $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
        ));

        return $adapter;
    }

    /**
     * @param EntityManager $em
     * @return $this
     */
    protected function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->entityManager;
    }

    /**
     * @return mixed
     */
    public function getBloggerTable()
    {
        if (!$this->bloggerTable) {
            $sm = $this->getServiceLocator();
            $this->bloggerTable = $sm->get('Blogger\Model\BloggerTable');
        }
        return $this->bloggerTable;
    }

}
