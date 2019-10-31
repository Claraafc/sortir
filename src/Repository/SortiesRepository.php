<?php

namespace App\Repository;

use App\Entity\Etat;
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

        //1st we get 'passee' state in 'Etat' for the last checkbox
        $etatPassee = $this->getEntityManager()->getRepository(Etat::class)->findOneBySomeField('passee');

        //2nd we order 'Sorties' by the date of the event
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.dateDebut', 'DESC');
        $qb->select('s');

        //3rd declaration of a empty table of parameters
        $params = [];

        //for all fields that are'nt checkboxes the requests are exclusives
        //name of event's field
        if (!empty($nomSortie)) {
            $params["nomSortie"] ="%" . $nomSortie . "%";
            $qb->andWhere('s.name LIKE :nomSortie');
        }

        //name of event's school place (Site)
        if (!empty($site)) {
            $params["site"] = $site;
            $qb->andWhere('s.site = :site');
        }

        //events we search between two dates
        if (!empty($dateDebutRecherche) && !empty($dateFinRecherche)) {
            $params["dateDebutRecherche"] = $dateDebutRecherche;
            $params["dateFinRecherche"] = $dateFinRecherche;
            $qb->andWhere('s.dateDebut >= :dateDebutRecherche');
            $qb->andWhere('s.dateDebut <= :dateFinRecherche');
        }

        //declaration of an empty table of requests for the checkboxes, all this requests are inclusive
        $req = [];

        //search by organiser
        if ($organisateur) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit = s.organisateur';
        }

        //search by events we're registered
        if ($inscrit) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit MEMBER OF s.users';
        }

        //search by events we're not registered
        if ($nonInscrit) {
            $params["inscrit"] = $user;
            $req[] = ':inscrit NOT MEMBER OF s.users';
        }

        //search by events passed
        if ($passee) {
            $params["etatPassee"] = $etatPassee;
            $req[] = ':etatPassee = s.etat';
        }

        //if the table of requests of the checkboxes is not empty we add this requests to others
        if (count($req) > 0) {
            $orX = $qb->expr()->orX();
            $orX->addMultiple($req);
            $qb->andWhere(
                $orX
            );
        }

        //if the table of parameters is not empty we send the parameters to the controller
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
