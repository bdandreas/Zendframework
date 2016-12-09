<?php
namespace Blogger\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation;

/**
 * Entity Class representing a Post of our Zend Framework 2 Blogging Application
 *
 *
 * @ORM\Table(name="blogger_post")
 * @ORM\Entity
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class BloggerPost
{
    /**
     * Primary Identifier
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     * @access protected
     */
    protected $id;


    /**
     * @ORM\Column(length=11)
     * @ORM\Column(type="integer")
     */
    protected $userid;


    /**
     * Title of our Blog Post
     *
     * @ORM\Column(type="string")
     * @var string
     * @access protected
     */
    protected $title;


    /**
     * Textual content of our Blog Post
     *
     * @ORM\Column(type="text")
     * @var string
     * @access protected
     */
    protected $message;

    /**
     * @ORM\Column(length=11)
     * @ORM\Column(type="integer")
     */
    protected $control;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * Sets the Identifier
     *
     * @param int $id
     * @access public
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the Identifier
     *
     * @access public
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUserid()
    {
        return $this->userid;
    }

    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getControl()
    {
        return $this->control;
    }

    public function setControl($control)
    {
        $this->control = $control;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }


}