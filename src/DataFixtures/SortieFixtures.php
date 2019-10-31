<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;



class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public const SORTIE_1 = 'sortie-1';
    public const SORTIE_2 = 'sortie-2';
    public const SORTIE_3 = 'sortie-3';
    public const SORTIE_4 = 'sortie-4';
    public const SORTIE_5 = 'sortie-5';
    public const SORTIE_6 = 'sortie-6';
    public const SORTIE_7 = 'sortie-7';
    public const SORTIE_8 = 'sortie-8';

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
         $sortie1->setNbInscriptionsMax('3');
         $sortie1->setDescription('Tapas, tapas, tapas !!!!');
         $sortie1->setUrlPhoto('tapas.jpg');
         $etat1 = $this->getReference(EtatFixtures::ETAT_CREE);
         $sortie1->setEtat($etat1);
         $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
         $sortie1->setLieu($lieu1);
         $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
         $sortie1->setSite($site1);
         $user1 = $this->getReference(UserFixtures::USER_ADMIN);
         $sortie1->setOrganisateur($user1);

         $manager->persist($sortie1);

        $sortie2 = new Sortie();
        $sortie2->setName('fête de la bière');
        $sortie2->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
        $sortie2->setDuree('120');
        $sortie2->setDateCloture(new \DateTime('2020-01-09 05:20:30'));
        $sortie2->setNbInscriptionsMax('5');
        $sortie2->setDescription('A boire, à boire, à boire !!!!');
        $sortie2->setUrlPhoto('bieres.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_OUVERTE);
        $sortie2->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_BRASSEES);
        $sortie2->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_RENNES);
        $sortie2->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_TOTO);
        $sortie2->setOrganisateur($user1);

        $user3 = $this->getReference(UserFixtures::USER_3);
        $sortie2->addUser($user3);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie2->addUser($user4);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie2->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie2->addUser($user6);

        $manager->persist($sortie2);

        $sortie3 = new Sortie();
        $sortie3->setName('Soirée poker');
        $sortie3->setDateDebut(new \DateTime('2019-10-25 05:20:30'));
        $sortie3->setDuree('120');
        $sortie3->setDateCloture(new \DateTime('2019-10-12 05:20:30'));
        $sortie3->setNbInscriptionsMax('10');
        $sortie3->setDescription('All in!!!!');
        $sortie3->setUrlPhoto('poker.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_CLOTUREE);
        $sortie3->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie3->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie3->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie3->setOrganisateur($user1);
        $user3 = $this->getReference(UserFixtures::USER_3);
        $sortie3->addUser($user3);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie3->addUser($user4);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie3->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie3->addUser($user6);

        $manager->persist($sortie3);

        $sortie4 = new Sortie();
        $sortie4->setName('karting');
        $sortie4->setDateDebut(new \DateTime('2019-10-23 05:20:30'));
        $sortie4->setDuree('12000');
        $sortie4->setDateCloture(new \DateTime('2019-10-12 05:20:30'));
        $sortie4->setNbInscriptionsMax('5');
        $sortie4->setDescription('Courses de kart dans un décors SuperMario!!! INEDIT!!!!');
        $sortie4->setUrlPhoto('kart.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_EN_COURS);
        $sortie4->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie4->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie4->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie4->setOrganisateur($user1);
        $user3 = $this->getReference(UserFixtures::USER_3);
        $sortie4->addUser($user3);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie4->addUser($user4);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie4->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie4->addUser($user6);
        $user1 = $this->getReference(UserFixtures::USER_ADMIN);
        $sortie4->addUser($user1);
        $user10 = $this->getReference(UserFixtures::USER_10);
        $sortie4->addUser($user10);


        $manager->persist($sortie4);

        $sortie5 = new Sortie();
        $sortie5->setName('esclalade');
        $sortie5->setDateDebut(new \DateTime('2018-01-09 05:20:30'));
        $sortie5->setDuree('120');
        $sortie5->setDateCloture(new \DateTime('2018-01-09 05:20:30'));
        $sortie5->setNbInscriptionsMax('18');
        $sortie5->setDescription('Venez faire une scéance d\'escalade avec notre ami El Jefe!!!!');
        $sortie5->setUrlPhoto('escalade.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_PASSEE);
        $sortie5->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_IKEA);
        $sortie5->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_ST_HERBLAIN);
        $sortie5->setSite($site1);
        $user2 = $this->getReference(UserFixtures::USER_TOTO);
        $sortie5->setOrganisateur($user2);
        $user8 = $this->getReference(UserFixtures::USER_8);
        $sortie5->addUser($user8);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie5->addUser($user4);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie5->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie5->addUser($user6);
        $user9 = $this->getReference(UserFixtures::USER_9);
        $sortie5->addUser($user9);

        $manager->persist($sortie5);

        $sortie6 = new Sortie();
        $sortie6->setName('noche de cumbia');
        $sortie6->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
        $sortie6->setDuree('120');
        $sortie6->setDateCloture(new \DateTime('2020-01-09 05:20:30'));
        $sortie6->setNbInscriptionsMax('15');
        $sortie6->setDescription('Venez danser!!!!');
        $sortie6->setUrlPhoto('cumbia.jpg');
        $sortie6->setMotifAnnulation('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam');
        $etat1 = $this->getReference(EtatFixtures::ETAT_ANNULEE);
        $sortie6->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_TAPEO);
        $sortie6->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $sortie6->setSite($site1);
        $user1 = $this->getReference(UserFixtures::USER_4);
        $sortie6->setOrganisateur($user1);

        $manager->persist($sortie6);

        $sortie7 = new Sortie();
        $sortie7->setName('noche de cumbia');
        $sortie7->setDateDebut(new \DateTime('2020-01-01 05:20:30'));
        $sortie7->setDuree('120');
        $sortie7->setDateCloture(new \DateTime('2019-10-10 05:20:30'));
        $sortie7->setNbInscriptionsMax('40');
        $sortie7->setDescription('PARTY NEW YEAR!!!!');
        $sortie7->setUrlPhoto('cumbia.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_OUVERTE);
        $sortie7->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_CHAMBOULTOU);
        $sortie7->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_NIORT);
        $sortie7->setSite($site1);
        $user2 = $this->getReference(UserFixtures::USER_TOTO);
        $sortie7->setOrganisateur($user2);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie7->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie7->addUser($user6);
        $user9 = $this->getReference(UserFixtures::USER_9);
        $sortie7->addUser($user9);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie7->addUser($user4);
        $user3 = $this->getReference(UserFixtures::USER_3);
        $sortie7->addUser($user3);
        $user8 = $this->getReference(UserFixtures::USER_8);
        $sortie7->addUser($user8);
        $user10 = $this->getReference(UserFixtures::USER_10);
        $sortie7->addUser($user10);

        $manager->persist($sortie7);

        $sortie8 = new Sortie();
        $sortie8->setName('Paintball');
        $sortie8->setDateDebut(new \DateTime('2019-01-12 20:20:30'));
        $sortie8->setDuree('120');
        $sortie8->setDateCloture(new \DateTime('2019-11-09 15:20:30'));
        $sortie8->setNbInscriptionsMax('18');
        $sortie8->setDescription('Soot dem up!!!!');
        $sortie8->setUrlPhoto('paintball2.jpg');
        $etat1 = $this->getReference(EtatFixtures::ETAT_OUVERTE);
        $sortie8->setEtat($etat1);
        $lieu1 = $this->getReference(LieuFixtures::LIEU_RB);
        $sortie8->setLieu($lieu1);
        $site1 = $this->getReference(SiteFixtures::SITE_CHARTRES);
        $sortie8->setSite($site1);
        $user8 = $this->getReference(UserFixtures::USER_6);
        $sortie8->setOrganisateur($user8);
        $user8 = $this->getReference(UserFixtures::USER_8);
        $sortie8->addUser($user8);
        $user4 = $this->getReference(UserFixtures::USER_4);
        $sortie8->addUser($user4);
        $user10 = $this->getReference(UserFixtures::USER_10);
        $sortie8->addUser($user10);
        $user5 = $this->getReference(UserFixtures::USER_5);
        $sortie8->addUser($user5);
        $user6 = $this->getReference(UserFixtures::USER_6);
        $sortie8->addUser($user6);
        $user9 = $this->getReference(UserFixtures::USER_9);
        $sortie8->addUser($user9);

        $manager->persist($sortie8);

         $manager->flush();

        $this->addReference(self::SORTIE_1, $sortie1);
        $this->addReference(self::SORTIE_2, $sortie2);
        $this->addReference(self::SORTIE_3, $sortie3);
        $this->addReference(self::SORTIE_4, $sortie4);
        $this->addReference(self::SORTIE_5, $sortie5);
        $this->addReference(self::SORTIE_6, $sortie6);
        $this->addReference(self::SORTIE_7, $sortie7);
        $this->addReference(self::SORTIE_8, $sortie8);
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
            EtatFixtures::class
        ];
    }
}
