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
