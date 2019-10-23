<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LieuFixtures extends Fixture
{

    public const LIEU_TAPEO = 'lieu-tapeo';
    public const LIEU_BRASSEES = 'lieu-brassees';
    private $encoder;

    /**
     * LieuFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $lieu1 = new Lieu();
         $lieu1->setNom('tapeo');
         $lieu1->setRue('rue de la faim');
         $lieu1->setLongitude('18.55445554478');
         $lieu1->setLatitude('685.587646376987');
         $ville = $this->getReference(VilleFixtures::VILLE_RENNES);
         $lieu1->setVille($ville);

         $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('brassees');
        $lieu2->setRue('rue de la soif');
        $lieu2->setLongitude('24.55445554478');
        $lieu2->setLatitude('12.587646376987');
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
