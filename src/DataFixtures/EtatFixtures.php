<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class EtatFixtures extends Fixture
{

    public const ETAT_CREE = 'etat-cree';
    public const ETAT_OUVERTE = 'etat-ouverte';
    public const ETAT_CLOTUREE = 'etat-cloturee';
    public const ETAT_EN_COURS = 'etat-cours';
    public const ETAT_PASSEE = 'etat-passee';
    public const ETAT_ANNULEE = 'etat-annulee';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $etat1 = new Etat();
         $etat1->setLibelle('cree');
         $manager->persist($etat1);

        $etat2 = new Etat();
        $etat2->setLibelle('ouverte');
        $manager->persist($etat2);

        $etat3 = new Etat();
        $etat3->setLibelle('cloturee');
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle('en cours');
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle('passee');
        $manager->persist($etat5);

        $etat6 = new Etat();
        $etat6->setLibelle('annulee');
        $manager->persist($etat6);

         $manager->flush();
        $this->addReference(self::ETAT_CREE, $etat1);
        $this->addReference(self::ETAT_OUVERTE, $etat2);
        $this->addReference(self::ETAT_CLOTUREE, $etat3);
        $this->addReference(self::ETAT_EN_COURS, $etat4);
        $this->addReference(self::ETAT_PASSEE, $etat5);
        $this->addReference(self::ETAT_ANNULEE, $etat6);
    }
}
