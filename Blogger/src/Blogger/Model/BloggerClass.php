<?php

namespace Blogger\Model;
// Add these import statements
// Create PLugin for view page to fetch data from db.

use Zend\ServiceManager\AbstractPluginManager;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;


class BloggerClass extends AbstractPluginManager
{

    private $adapter;
    protected $returnData;

    const preview = 5;

    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->adapter = $dbAdapter;
    }

    /**
     * @param int|NULL $postid
     * @return mixed
     */
    public function GetBloggerPosts(int $postid = NULL)
    {

        if (isset($postid)) {

            $sql = 'SELECT id,userid,title,message,control,created  FROM blogger_post  WHERE id = ' . $postid . ' LIMIT 1 ';
        } else {

            $sql = 'SELECT id,userid,title,message,control,created  FROM blogger_post  ORDER BY created DESC LIMIT  ' . self::preview;

        }

        $dbAdapter = $this->adapter;
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }

    /**
     * @param bool $userid
     * @param bool $control
     * @return array|bool
     */
    public function GetBloggerUser($userid = false, $control = false)
    {
        if (isset($userid)) {

            switch ($control) {
                case 0:
                    $sql = 'SELECT id,name,email  FROM blogger_users WHERE id=' . $userid . ' LIMIT 1';
                    break;
                case 1:
                    $sql = 'SELECT user_id AS id ,display_name AS name, email  FROM user WHERE user_id = ' . $userid . ' LIMIT 1';
                    break;
                default:
                    $sql = 'SELECT id,name,email  FROM blogger_users WHERE id=' . $userid . ' LIMIT 1';
                    break;
            }
            $dbAdapter = $this->adapter;
            $statement = $dbAdapter->query($sql);
            $result = $statement->execute();

            $returnData = array();

            foreach ($result as $res) {
                $returnData = array("Username" => $res['name'],
                    "Email" => $res['email']);
            }
            return $returnData;
        }
        return false;
    }

    /**
     * @param $dbAdapter
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->adapter = $dbAdapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getDbAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof Adapter\AdapterInterface) {
            // we're okay
            return;
        }
        throw new Exception\RuntimeException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Adapter\AdapterInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }

}
