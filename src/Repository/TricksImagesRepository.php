<?php

namespace App\Repository;

use App\Entity\TricksImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TricksImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method TricksImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method TricksImages[]    findAll()
 * @method TricksImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TricksImages::class);
    }

    public function findAllTrickImages($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.trick = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findImage($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.id = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getSingleResult()
        ;
    }

    public function findTrickThumbnail($id)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.isThumbnail = 1')
            ->andWhere('t.trick = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    // /**
    //  * @return TricksImages[] Returns an array of TricksImages objects
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
    public function findOneBySomeField($value): ?TricksImages
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
