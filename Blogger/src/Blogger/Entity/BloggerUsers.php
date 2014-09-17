<?php
namespace Blogger\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity
 *  @ORM\Table(name="blogger_users") 
 * 
 **/
class BloggerUsers
{
    /** 
     *  @ORM\Id 
     *  @ORM\Column(type="integer")
     *  @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
     
    /** 
     * 	@ORM\String
     *  @ORM\Column(type="string")
	 *  @ORM\Column(length=50)  
	 */
    protected $name;
     
    /** 
     * 	@ORM\String
     *  @ORM\Column(type="string")
	 *  @ORM\Column(length=50)  
	 */
    protected $email;
    
    /** @ORM\Column(type="datetime") */
    protected $created;
    
	public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
	public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }	
	
    public function setCreated($created)
    {
        $this->created =  $created;
        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }
    
	
}