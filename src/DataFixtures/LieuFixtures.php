<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIEU_TAPEO = 'Resto Tapeo';
    public const LIEU_BRASSEES = 'lieu-brassees';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lieu1 = new Lieu();
        $lieu1->setNom('Resto Racines');
        $lieu1->setRue('rue de la faim');
        $lieu1->setLongitude('18.478');
        $lieu1->setLatitude('68.5987');
        $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
        $lieu1->setVille($ville);

        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('La Bottega Resto');
        $lieu2->setRue('rue de la soif');
        $lieu2->setLongitude('24.554');
        $lieu2->setLatitude('12.587');
        $ville = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $lieu2->setVille($ville);

        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom('Le Majestic');
        $lieu3->setRue('rue de la dance');
        $lieu3->setLongitude('25.5');
        $lieu3->setLatitude('15.75');
        $ville = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $lieu3->setVille($ville);

        $manager->persist($lieu3);

        $lieu4 = new Lieu();
        $lieu4->setNom('Cinéma Arvor');
        $lieu4->setRue('29 Rue d\'Antrain');
        $lieu4->setLongitude('7.154');
        $lieu4->setLatitude('78.526');
        $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
        $lieu4->setVille($ville);

        $manager->persist($lieu4);

        $lieu5 = new Lieu();
        $lieu5->setNom('Stade René-Gaillard');
        $lieu5->setRue('rue du foot');
        $lieu5->setLongitude('75.45');
        $lieu5->setLatitude('14.526');
        $ville = $this->getReference(VilleFixtures::VILLE_NIORT);
        $lieu5->setVille($ville);

        $manager->persist($lieu5);

        $lieu6 = new Lieu();
        $lieu6->setNom('Le Chamboul\'tou');
        $lieu6->setRue('rue de la salsa');
        $lieu6->setLongitude('45.36');
        $lieu6->setLatitude('45.36');
        $ville = $this->getReference(VilleFixtures::VILLE_NIORT);
        $lieu6->setVille($ville);

        $manager->persist($lieu6);

        $lieu7 = new Lieu();
        $lieu7->setNom('Class\'Croute');
        $lieu7->setRue('rue du resto');
        $lieu7->setLongitude('4.256');
        $lieu7->setLatitude('758.36');
        $ville = $this->getReference(VilleFixtures::VILLE_SAINT_HERBLAIN);
        $lieu7->setVille($ville);

        $manager->persist($lieu7);

        $lieu8 = new Lieu();
        $lieu8->setNom('Sopra Steria');
        $lieu8->setRue('rue du travail');
        $lieu8->setLongitude('45.36');
        $lieu8->setLatitude('54.364');
        $ville = $this->getReference(VilleFixtures::VILLE_SAINT_HERBLAIN);
        $lieu8->setVille($ville);

        $manager->persist($lieu8);

        $lieu9 = new Lieu();
        $lieu9->setNom('Le Billot Resto');
        $lieu9->setRue('rue du travail');
        $lieu9->setLongitude('45.36');
        $lieu9->setLatitude('54.364');
        $ville = $this->getReference(VilleFixtures::VILLE_CHARTRES);
        $lieu9->setVille($ville);

        $manager->persist($lieu9);

        $lieu10 = new Lieu();
        $lieu10->setNom('Ensemble Sportif Rémy Berranger');
        $lieu10->setRue('rue du hockey');
        $lieu10->setLongitude('7.154');
        $lieu10->setLatitude('78.526');
        $ville = $this->getReference(VilleFixtures::VILLE_CHARTRES);
        $lieu10->setVille($ville);

        $manager->persist($lieu10);

        $lieu11 = new Lieu();
        $lieu11->setNom('Bowling Chartres');
        $lieu11->setRue('rue du bowling');
        $lieu11->setLongitude('67.64');
        $lieu11->setLatitude('76.098');
        $ville = $this->getReference(VilleFixtures::VILLE_CHARTRES);
        $lieu11->setVille($ville);

        $manager->persist($lieu11);

        $lieu12 = new Lieu();
        $lieu12->setNom('Ikea');
        $lieu12->setRue('rue du commerce');
        $lieu12->setLongitude('63.65');
        $lieu12->setLatitude('12.09');
        $ville = $this->getReference(VilleFixtures::VILLE_SAINT_HERBLAIN);
        $lieu12->setVille($ville);

        $manager->persist($lieu12);

        $lieu13 = new Lieu();
        $lieu13->setNom('Spa L\'Orient Espace');
        $lieu13->setRue('rue relax');
        $lieu13->setLongitude('5.879');
        $lieu13->setLatitude('32.786');
        $ville = $this->getReference(VilleFixtures::VILLE_NIORT);
        $lieu13->setVille($ville);

        $manager->persist($lieu13);

        $lieu14 = new Lieu();
        $lieu14->setNom('L\'appel à Pizza');
        $lieu14->setRue('rue de la yoyo');
        $lieu14->setLongitude('153.78');
        $lieu14->setLatitude('98.688');
        $ville = $this->getReference(VilleFixtures::VILLE_QUIMPER);
        $lieu14->setVille($ville);

        $manager->persist($lieu14);

        $lieu15 = new Lieu();
        $lieu15->setNom('Escape Game La Prision');
        $lieu15->setRue('43 rue de la gallina');
        $lieu15->setLongitude('37.154');
        $lieu15->setLatitude('84.664');
        $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
        $lieu15->setVille($ville);

        $manager->persist($lieu15);

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
