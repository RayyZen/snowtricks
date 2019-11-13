<?php

namespace App\Repository;

use App\Entity\TricksVideos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TricksVideos|null find($id, $lockMode = null, $lockVersion = null)
 * @method TricksVideos|null findOneBy(array $criteria, array $orderBy = null)
 * @method TricksVideos[]    findAll()
 * @method TricksVideos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksVideosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TricksVideos::class);
    }

    public function findAllTrickVideos($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return TricksVideos[] Returns an array of TricksVideos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TricksVideos
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
