<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{

    public function getCollectionById()
    {
        $collection = [];
        foreach ($this->getEntityManager()->getRepository('AppBundle:Item')->findAll() as $item) {
            $collection[$item->getId()] = $item;
        }
        
        return $collection;
    }
    
}
