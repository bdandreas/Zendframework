<?php
namespace Blogger\Model;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class BloggerTable
 * @package Blogger\Model
 */
class BloggerTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * BloggerTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param bool $paginated
     * @return Paginator
     */
    public function fetchAll($paginated = false)
    {
        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('blogger_post');
            // Join Blogger_users too

            $select->join(
                array('u' => 'blogger_users'),     // join table with alias
                'blogger_post.userid = u.id ',
                Select::SQL_STAR,
                Select::JOIN_LEFT
            )->order('blogger_post.created');


            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new BloggerModel());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
            // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * @param $id
     */
    public function deleteContact($id)
    {
        $this->tableGateway->delete(array('id' => (int)$id));
    }
}

?>
