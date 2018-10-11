<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class KittyRepository extends EntityRepository
{
    public function findKittiesByPage(int $pageNumber, int $maxResults = 2)
    {
        $firstResult = ($pageNumber - 1) * $maxResults;
        $qb = $this->createQueryBuilder('Kitty');
        $qb->select('Kitty')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        $paginator = new Paginator($qb);
        return iterator_to_array($paginator->getIterator());
    }

    public function countAllKitties()
    {
        $qb = $this->createQueryBuilder('Kitty');
        $qb->select('count(Kitty)');
        return intval($qb->getQuery()->getOneOrNullResult()[1]);
    }

    public function findKittiesNameByPage(int $pageNumber, int $maxResults = 2)
    {
        $firstResult = ($pageNumber - 1) * $maxResults;
        $qb = $this->createQueryBuilder('Kitty');
        $qb->select('Kitty.name')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        return $qb->getQuery()->getArrayResult();
    }
}
