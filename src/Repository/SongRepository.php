<?php

namespace App\Repository;

use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }


    public function findAllOrderDescByTitleUsingQueryBuilder(array $relations = []) {
        $builder = $this->createQueryBuilder('s')
            ->orderBy('s.title', 'desc');

        if (in_array('album', $relations)) {
            $builder
                ->addSelect('album')
                ->innerJoin('s.album', 'album');
        }

        if (in_array('playlists', $relations)) {
            $builder
                ->addSelect('playlist')
                ->innerJoin('s.playlists', 'playlist');
        }

        $query = $builder->getQuery()->getResult();
        return $query;
    }

    public function findAllUsingDql($relations) {

    }
}
