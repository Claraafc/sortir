<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Etat;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SortieFixtures extends Fixture
{
    private $encoder;

    /**
     * SortieFixtures constructor.
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
         $sortie = new Sortie();
         $sortie->setName('tapas');
         $sortie->setDateDebut(new \DateTime('2020-01-09 05:20:30'));
         $sortie->setDuree('120');
         $sortie->setDateCloture(new \Date('2020-01-09'));
         $sortie->setNbInscriptionsMax('15');
         $sortie->setDescription('Tapas, tapas, tapas !!!!');
         $sortie->setUrlPhoto('photos/tapas.jpg');
         $user = $this->getReference(UserFixtures::CAT_SPORT);




         $user->setUsername('admin');
         $user->setEmail("admin@mail.fr");
         $user->setNom('Admin');
         $user->setPrenom('strateur');
         $user->setTelephone('0666547889');
         $user->setUrlPhoto('photos/conan.jpg');
         $user->setRoles(['ROLE_ADMIN']);

         $password = $this->encoder->encodePassword($user, 'pass_administrateur');
         $user->setPassword($password);
         $manager->persist($user);

        $user = new User();
        $user->setUsername('Toto');
        $user->setEmail("toto@mail.fr");
        $user->setNom('Toto');
        $user->setPrenom('Guizmo');
        $user->setTelephone('0698745632');
        $user->setUrlPhoto('photos/guizmo.jpg');
        $user->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user, 'pass_guizmo');
        $user->setPassword($password);
        $manager->persist($user);

         $manager->flush();
    }
}
