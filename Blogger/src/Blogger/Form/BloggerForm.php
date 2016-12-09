<?php

namespace Blogger\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

/**
 * Class BloggerForm
 * @package Blogger\Form
 */
class BloggerForm extends Form
{

    protected $adapter;

    /**
     * BloggerForm constructor.
     * @param AdapterInterface $dbAdapter
     * @param bool $userid
     */
    public function __construct(AdapterInterface $dbAdapter, $userid = false)
    {
        $this->adapter = $dbAdapter;
        parent::__construct('blogger');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'userid',
            'type' => 'Select',

            'options' => array(
                'label' => 'Author',
                'empty_option' => 'Please select an author',
                'value_options' => $this->getOptionsForSelect($userid),
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'attributes' => array(
                'maxlength' => '60',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'message',
            'type' => 'textarea',
            'attributes' => array(
                'rows' => '10',
                'cols' => '50',
            ),
            'options' => array(
                'label' => 'Message',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }

    /**
     * @param bool $userid
     * @return array
     */
    public function getOptionsForSelect($userid = false)
    {
        $dbAdapter = $this->adapter;

        if ($userid) {
            $sql = 'SELECT user_id AS id ,display_name AS name  FROM user WHERE user_id = ' . $userid . ' LIMIT 1';
        } else {
            $sql = 'SELECT id,name  FROM blogger_users ORDER BY name ASC';
        }
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['name'];
        }
        return $selectData;
    }
}
 
 
 