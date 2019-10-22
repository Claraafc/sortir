<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VilleFixtures extends Fixture
{
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
         $ville = new Ville();
         $ville->setName('Chartres-de-Bretagne');
         $ville->setCodePostal('35131');
        $manager->persist($ville);

        $ville = new Ville();
        $ville->setName('Quimper');
        $ville->setCodePostal('29000');
        $manager->persist($ville);

        $ville = new Ville();
        $ville->setName('Saint-Herblain');
        $ville->setCodePostal('44800');
        $manager->persist($ville);

        $ville = new Ville();
        $ville->setName('Niort');
        $ville->setCodePostal('79000');
        $manager->persist($ville);

         $manager->flush();
    }
}
