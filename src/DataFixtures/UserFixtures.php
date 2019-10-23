<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    public const USER_ADMIN = 'user-admin';
    public const USER_TOTO = 'user-toto';
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $user1 = new User();
         $user1->setUsername('admin');
         $user1->setEmail("admin@mail.fr");
         $user1->setNom('Admin');
         $user1->setPrenom('strateur');
         $user1->setTelephone('0666547889');
         $user1->setUrlPhoto('photos/conan.jpg');
         $user1->setRoles(['ROLE_ADMIN']);

         $password = $this->encoder->encodePassword($user1, 'pass_administrateur');
         $user1->setPassword($password);
         $manager->persist($user1);

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
