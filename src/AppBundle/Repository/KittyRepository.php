<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Kitty;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class KittyRepository extends ServiceEntityRepository
{
    protected $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

    public function findKittiesNameByPage(int $pageNumber, int $maxResults = 2)
    {
        $firstResult = ($pageNumber - 1) * $maxResults;
        $qb = $this->createQueryBuilder('Kitty');
        $qb->select('Kitty.name')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param Kitty $kittyToCreate
     * @param mixed $fileInfo Les informations du fichier envoyé en POST
     * @return Kitty Le chat nouvellement créé
     */
    public function createKitty(Kitty $kittyToCreate, $fileInfo = null)
    {
        if ($fileInfo !== null) {
            $media = new Media();
            $media->setProviderName('sonata.media.provider.image');
            $media->setBinaryContent($fileInfo);
            $media->setName($fileInfo->getClientOriginalName());
            $media->setEnabled(true);
            $media->setContext('default');
            $kittyToCreate->setImage($media);
        }
        $this->entityManager->persist($kittyToCreate);
        $this->entityManager->flush();
        return $kittyToCreate;
    }
}
