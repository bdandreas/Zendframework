<?php 
//module/Blogger/src/Blogger/Repository/BloggerUsersRepository
namespace Blogger\Form;
 
use Doctrine\ORM\EntityRepository;
 
class BloggerUsersRepository extends EntityRepository
{
    public function getName()
    {
        $querybuilder = $this->_em
                             ->getRepository($this->getEntityName())
                             ->createQueryBuilder('c');
        return $querybuilder->select('c')
                    ->orderBy('c.id', 'ASC')
                    ->getQuery()->getResult();
    }
}