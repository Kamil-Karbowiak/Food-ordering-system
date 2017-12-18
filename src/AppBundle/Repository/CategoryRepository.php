<?php

namespace AppBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllAssoc(){
        $em = $this->getEntityManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $assocCategories = [];
        foreach ($categories as $category){
            $assocCategories[$category->getName()] = $category;
        }
        return $assocCategories;
    }
}
