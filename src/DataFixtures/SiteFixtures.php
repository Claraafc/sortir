<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SiteFixtures extends Fixture
{

    public const SITE_RENNES = 'site-rennes';
    public const SITE_QUIMPER = 'site-quimper';
    private $encoder;

    /**
     * SiteFixtures constructor.
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
         $site1 = new Site();
         $site1->setName('eni-rennes');
         $manager->persist($site1);

        $site2 = new Site();
        $site2->setName('eni-quimper');
        $manager->persist($site2);

         $manager->flush();
        $this->addReference(self::SITE_RENNES, $site1);
        $this->addReference(self::SITE_QUIMPER, $site2);
    }
}
