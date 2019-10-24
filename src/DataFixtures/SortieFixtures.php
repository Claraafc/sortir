<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;



class SortieFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $sortie1 = new Sortie();
         $sortie1->setName('tapas');
         $sortie1->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
         $sortie1->setDuree('120');
         $sortie1->setDateCloture(new \DateTime('2020-01-09 05:20:30'));
         $sortie1->setNbInscriptionsMax('15');
         $sortie1->setDescription('Tapas, tapas, tapas !!!!');
         $sortie1->setUrlPhoto('photos/tapas.jpg');
         $etat1 = $this->getReference(EtatFixtures::ETAT_CREE);
         $sortie1->setEtat($etat1);
        $ville1 = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $sortie1->setVille($ville1);
         $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
         $sortie1->setLieu($lieu1);
         $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
         $sortie1->setSite($site1);
         $user1 = $this->getReference(UserFixtures::USER_ADMIN);
         $sortie1->setOrganisateur($user1);

         $manager->persist($sortie1);

        $sortie2 = new Sortie();
        $sortie2->setName('tapas');
        $sortie2->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
        $sortie2->setDuree('120');
        $sortie2->setDateCloture(new \DateTime('2020-01-09 05:20:30'));
        $sortie2->setNbInscriptionsMax('15');
        $sortie2->setDescription('A boire, à boire, à boire !!!!');
        $sortie2->setUrlPhoto('photos/bieres.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_OUVERTE);
        $sortie2->setEtat($etat1);
        $ville2 = $this->getReference(VilleFixtures::VILLE_RENNES);
        $sortie2->setVille($ville2);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_BRASSEES);
        $sortie2->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_RENNES);
        $sortie2->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_TOTO);
        $sortie2->setOrganisateur($user1);

        $manager->persist($sortie2);

        $sortie3 = new Sortie();
        $sortie3->setName('tapas');
        $sortie3->setDateDebut(new \DateTime('2019-10-25 05:20:30'));
        $sortie3->setDuree('120');
        $sortie3->setDateCloture(new \DateTime('2019-10-12 05:20:30'));
        $sortie3->setNbInscriptionsMax('15');
        $sortie3->setDescription('Tapas, tapas, tapas !!!!');
        $sortie3->setUrlPhoto('photos/tapas.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_CLOTUREE);
        $sortie3->setEtat($etat1);
        $ville3 = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $sortie3->setVille($ville3);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie3->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie3->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie3->setOrganisateur($user1);

        $manager->persist($sortie3);

        $sortie4 = new Sortie();
        $sortie4->setName('tapas');
        $sortie4->setDateDebut(new \DateTime('2019-10-23 05:20:30'));
        $sortie4->setDuree('12000');
        $sortie4->setDateCloture(new \DateTime('2019-10-12 05:20:30'));
        $sortie4->setNbInscriptionsMax('15');
        $sortie4->setDescription('Tapas, tapas, tapas !!!!');
        $sortie4->setUrlPhoto('photos/tapas.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_EN_COURS);
        $sortie4->setEtat($etat1);
        $ville4 = $this->getReference(VilleFixtures::VILLE_RENNES);
        $sortie4->setVille($ville4);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie4->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie4->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie4->setOrganisateur($user1);

        $manager->persist($sortie4);

        $sortie5 = new Sortie();
        $sortie5->setName('tapas');
        $sortie5->setDateDebut(new \DateTime('2018-01-09 05:20:30'));
        $sortie5->setDuree('120');
        $sortie5->setDateCloture(new \DateTime('2018-01-09 05:20:30'));
        $sortie5->setNbInscriptionsMax('15');
        $sortie5->setDescription('Tapas, tapas, tapas !!!!');
        $sortie5->setUrlPhoto('photos/tapas.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_PASSEE);
        $sortie5->setEtat($etat1);
        $ville5 = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $sortie5->setVille($ville5);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie5->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie5->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie5->setOrganisateur($user1);

        $manager->persist($sortie5);

        $sortie6 = new Sortie();
        $sortie6->setName('tapas');
        $sortie6->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
        $sortie6->setDuree('120');
        $sortie6->setDateCloture(new \DateTime('2020-01-09 05:20:30'));
        $sortie6->setNbInscriptionsMax('15');
        $sortie6->setDescription('Tapas, tapas, tapas !!!!');
        $sortie6->setUrlPhoto('photos/tapas.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_ANNULEE);
        $sortie6->setEtat($etat1);
        $ville6 = $this->getReference(VilleFixtures::VILLE_RENNES);
        $sortie6->setVille($ville6);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie6->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie6->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie6->setOrganisateur($user1);

        $manager->persist($sortie6);


         $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            LieuFixtures::class,
            SiteFixtures::class,
            EtatFixtures::class,
            VilleFixtures::class
        ];
    }
}
