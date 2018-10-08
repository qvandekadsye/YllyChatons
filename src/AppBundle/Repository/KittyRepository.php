<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Kitty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class KittyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kitty::class);
    }

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
}
