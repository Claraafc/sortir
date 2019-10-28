<?php

namespace App\Repository;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }


    public function findByInscrit($inscrit)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
            ->andwhere(':inscrit MEMBER OF s.users')
            ->setParameter('inscrit', $inscrit);

        return $qb->getQuery()->getResult();

    }

    public function findByNonInscrit($inscrit)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
            ->andwhere(':inscrit NOT MEMBER OF s.users')
            ->setParameter('inscrit', $inscrit);

        return $qb->getQuery()->getResult();

    }


/**
    public function findOneBySomeField($check): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
*/
}
