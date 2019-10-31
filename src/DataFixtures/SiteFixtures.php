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
    public const SITE_ST_HERBLAIN = 'site-st-herblain';
    public const SITE_NIORT = 'site-niort';
    public const SITE_CHARTRES = 'site-chartres';

    /**
     * Load data fixtures with the passed EntityManager
     *
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

        $site3 = new Site();
        $site3->setName('eni-st-herblain');
        $manager->persist($site3);

        $site4 = new Site();
        $site4->setName('eni-niort');
        $manager->persist($site4);

        $site5 = new Site();
        $site5->setName('eni-chartres');
        $manager->persist($site5);

         $manager->flush();
        $this->addReference(self::SITE_RENNES, $site1);
        $this->addReference(self::SITE_QUIMPER, $site2);
        $this->addReference(self::SITE_ST_HERBLAIN, $site3);
        $this->addReference(self::SITE_NIORT, $site4);
        $this->addReference(self::SITE_CHARTRES, $site5);

    }

}
