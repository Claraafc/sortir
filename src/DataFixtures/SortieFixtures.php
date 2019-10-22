<?php


namespace App\DataFixtures;


use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/*class SortieFixtures extends Fixture
{*/

    /**
     * UserFixtures constructor.
     */
   /* public function __construct()
    {

    }
*/
    /**
     * @param ObjectManager $manager
     */
  /*  public function load(ObjectManager $manager)
    {
        $sortie = new Sortie();
        $ville = new Ville();
        $lieu = new Lieu();

        $sortie->setName('Tapeo');
        $sortie->setDateDebut(new \DateTime('2019-10-30 21:00:00'));
        $sortie->setDateCloture(new \DateTime('2019-10-28'));
        $sortie->setNbInscriptionsMax(15);
        $sortie->setDuree(120);
        $sortie->setDescription('hgeuqrhgihzietbhgqhjgrvbhih');
        $ville->setName('St Herblain');
        $lieu->setRue('3 Faraday');
        $lieu->setLatitude('49.5252');
        $lieu->setLongitude('181.88');
        $ville->setCodePostal(44800);
        $manager->persist($sortie);
        $manager->persist($ville);
        $manager->persist($lieu);

        $manager->flush();
    }*/
