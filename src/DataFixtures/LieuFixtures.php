<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIEU_TAPEO = 'lieu-tapeo';
    public const LIEU_BRASSEES = 'lieu-brassees';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $lieu1 = new Lieu();
         $lieu1->setNom('tapeo');
         $lieu1->setRue('rue de la faim');
         $lieu1->setLongitude('18.478');
         $lieu1->setLatitude('68.5987');
         $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
         $lieu1->setVille($ville);

         $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('brassees');
        $lieu2->setRue('rue de la soif');
        $lieu2->setLongitude('24.554');
        $lieu2->setLatitude('12.587');
        $ville = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $lieu2->setVille($ville);

        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom('dance');
        $lieu3->setRue('rue de la dance');
        $lieu3->setLongitude('25.5');
        $lieu3->setLatitude('15.75');
        $ville = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $lieu3->setVille($ville);

        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNom('hockey');
        $lieu4->setRue('rue du hockey');
        $lieu4->setLongitude('7.154');
        $lieu4->setLatitude('78.526');
        $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
        $lieu4->setVille($ville);

        $manager->persist($lieu4);

        $lieu5 = new Lieu();
        $lieu5->setNom('foot');
        $lieu5->setRue('rue du foot');
        $lieu5->setLongitude('75.45');
        $lieu5->setLatitude('14.526');
        $ville = $this->getReference(VilleFixtures::VILLE_NIORT);
        $lieu5->setVille($ville);

        $manager->persist($lieu5);

        $lieu6 = new Lieu();
        $lieu6->setNom('salsa');
        $lieu6->setRue('rue de la salsa');
        $lieu6->setLongitude('45.36');
        $lieu6->setLatitude('45.36');
        $ville = $this->getReference(VilleFixtures::VILLE_NIORT);
        $lieu6->setVille($ville);

        $manager->persist($lieu6);

        $lieu7 = new Lieu();
        $lieu7->setNom('resto');
        $lieu7->setRue('rue du resto');
        $lieu7->setLongitude('4.256');
        $lieu7->setLatitude('758.36');
        $ville = $this->getReference(VilleFixtures::VILLE_SAINT_HERBLAIN);
        $lieu7->setVille($ville);

        $manager->persist($lieu7);

        $lieu8 = new Lieu();
        $lieu8->setNom('hackaton');
        $lieu8->setRue('rue du travail');
        $lieu8->setLongitude('45.36');
        $lieu8->setLatitude('54.364');
        $ville = $this->getReference(VilleFixtures::VILLE_SAINT_HERBLAIN);
        $lieu8->setVille($ville);

        $manager->persist($lieu8);

        $lieu9 = new Lieu();
        $lieu9->setNom('hackaton');
        $lieu9->setRue('rue du travail');
        $lieu9->setLongitude('45.36');
        $lieu9->setLatitude('54.364');
        $ville = $this->getReference(VilleFixtures::VILLE_CHARTRES);
        $lieu9->setVille($ville);

        $manager->persist($lieu9);

        $lieu10 = new Lieu();
        $lieu10->setNom('hockey');
        $lieu10->setRue('rue du hockey');
        $lieu10->setLongitude('7.154');
        $lieu10->setLatitude('78.526');
        $ville = $this->getReference(VilleFixtures::VILLE_CHARTRES);
        $lieu10->setVille($ville);

        $manager->persist($lieu10);

         $manager->flush();
        $this->addReference(self::LIEU_TAPEO, $lieu1);
        $this->addReference(self::LIEU_BRASSEES, $lieu2);
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
            VilleFixtures::class
        ];
    }
}
