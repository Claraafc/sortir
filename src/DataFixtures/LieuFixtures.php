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


         $manager->persist($lieu1);

        $user2 = new User();
        $user2->setUsername('Toto');
        $user2->setEmail("toto@mail.fr");
        $user2->setNom('Toto');
        $user2->setPrenom('Guizmo');
        $user2->setTelephone('0698745632');
        $user2->setUrlPhoto('photos/guizmo.jpg');
        $user2->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user2, 'pass_guizmo');
        $user2->setPassword($password);
        $manager->persist($user2);

         $manager->flush();
        $this->addReference(self::USER_ADMIN, $user1);
        $this->addReference(self::USER_TOTO, $user2);
    }
}
