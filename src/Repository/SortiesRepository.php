<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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

    public function getName($name){
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.name = $name');

         $query = $qb->getQuery();
         $resultat = $query->getResult();

         return $resultat;
    }

    public function selectAll(){
        $rqt = $this->createQueryBuilder('a');
        $rqt->orderBy('a.dateDebut = DESC');


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


    /*
    public function findOneBySomeField($value): ?Sortie
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
