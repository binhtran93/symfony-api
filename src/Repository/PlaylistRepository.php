<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Playlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function findAll()
    {
        $em = $this->getEntityManager();
//        return $em->createQuery("SELECT p, s FROM App\Entity\Playlist p LEFT JOIN \App\Entity\Song s")->getResult();

        $expr = $em->getExpressionBuilder();
        $builder = $this
            ->createQueryBuilder('p')
//            ->addSelect('songs')
//            ->leftJoin('p.songs', 'songs')
            ->andWhere(
                $expr->exists('select s from App\Entity\Song s JOIN App\Entity\Playlist p1 WHERE p1.id = p.id')
            );

        return $builder
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Playlist[] Returns an array of Playlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
