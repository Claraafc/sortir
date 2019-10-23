<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VilleFixtures extends Fixture
{
    public const VILLE_RENNES = 'ville-rennes';
    public const VILLE_QUIMPER = 'ville-quimper';
    private $encoder;

    /**
     * VilleFixtures constructor.
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
        $ville1 = new Ville();
        $ville1->setName('Rennes');
        $ville1->setCodePostal('35000');
        $manager->persist($ville1);

        $ville2 = new Ville();
        $ville2->setName('Quimper');
        $ville2->setCodePostal('29000');
        $manager->persist($ville2);

         $ville3 = new Ville();
         $ville3->setName('Chartres-de-Bretagne');
         $ville3->setCodePostal('35131');
        $manager->persist($ville3);

        $ville4 = new Ville();
        $ville4->setName('Saint-Herblain');
        $ville4->setCodePostal('44800');
        $manager->persist($ville4);

        $ville4 = new Ville();
        $ville4->setName('Niort');
        $ville4->setCodePostal('79000');
        $manager->persist($ville4);

         $manager->flush();
        $this->addReference(self::VILLE_RENNES, $ville1);
        $this->addReference(self::VILLE_QUIMPER, $ville2);
    }
}
