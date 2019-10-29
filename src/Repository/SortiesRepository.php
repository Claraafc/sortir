<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use function Doctrine\ORM\QueryBuilder;

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
        $qb->select('s.id, count(u.id)')
            ->innerJoin('s.users', 'u');
        return $qb->getQuery()->getScalarResult();

    }

    public function findByParams($user, $inscrit, $nonInscrit, $nomSortie, $organisateur, $passee, $dateDebutRecherche, $dateFinRecherche, $site)
    {
        //dump($user, $inscrit, $nonInscrit, $nomSortie, $organisateur, $passee, $dateDebutRecherche, $dateFinRecherche, $site);

        $qb = $this->createQueryBuilder('s');
        $qb->select('s');

        $params = [];
        if (!empty($nomSortie)) {
            $params["nomSortie"] = $nomSortie . "%";
            $qb->andWhere('s.name LIKE :nomSortie');
        }

        if (!empty($site)) {
            $params["site"] = $site;
            $qb->andWhere('s.site = :site');
        }

        if (!empty($dateDebutRecherche) && !empty($dateFinRecherche)) {
            $params["dateDebutRecherche"] = $dateDebutRecherche;
            $params["dateFinRecherche"] = $dateFinRecherche;
            $qb->andWhere('s.dateDebut > :dateDebutRecherche');
            $qb->andWhere('s.dateDebut < :dateFinRecherche');
        }

        $req = [];

        if ($organisateur) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit = s.organisateur';
        }
        if ($inscrit) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit MEMBER OF s.users';
        }
        if ($nonInscrit) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit NOT MEMBER OF s.users';
        }
        if ($passee) {
            $params["etatPassee"] = 71;
            $req[] = ':etatPassee = s.etat';
        }

        if (count($req) > 0) {

            $orX = $qb->expr()->orX();
            $orX->addMultiple($req);

            $qb->andWhere(
                $orX
            );

        }

        if (count($params) > 0) {
            $qb->setParameters($params);
        }

        return $qb->getQuery()->getResult();

    }


    /**
     * public function findOneBySomeField($check): ?Sortie
     * {
     * return $this->createQueryBuilder('s')
     * ->andWhere('s.exampleField = :val')
     * ->setParameter('val', $value)
     * ->getQuery()
     * ->getOneOrNullResult()
     * ;
     * }
     */
}
