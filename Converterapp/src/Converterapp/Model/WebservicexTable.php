<?php
namespace Converterapp\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Class WebservicexTable
 * @package Converterapp\Model
 */
class WebservicexTable
{
    protected $tableGateway;

    /**
     * WebservicexTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getContact($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    /**
     * @param Contact $contact
     */
    public function saveContact(Contact $contact)
    {
        $data = array(
            'firstName' => $contact->firstName,
            'lastName' => $contact->lastName,
            'eMail' => $contact->eMail,
            'messageRequest' => $contact->messageRequest,
        );

        $id = (int)$contact->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                //throw new \Exception('Album id does not exist');
            }
        }
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
