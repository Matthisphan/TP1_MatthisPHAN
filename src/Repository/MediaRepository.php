<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }
    public function findPopular(int $maxResults): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.watchHistories', 'wh')
            ->groupBy('m.id')
            ->orderBy('COUNT(wh)', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
