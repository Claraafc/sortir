<?php

namespace App\Repository;

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


     /**
      * @return Sortie[] Returns an array of Sortie objects
      */

    public function findByInscrits($value)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select( 's.id, count(u.id)' )
            ->innerJoin('s.users', 'u');
        return $qb->getQuery()->getScalarResult();

    }

    public function findByInscrit($inscrit)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select( 's.id' , 'u.id = :29')
            ->innerJoin('s.etat', 'u');
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
