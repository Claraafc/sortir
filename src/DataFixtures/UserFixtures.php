<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
         $user = new User();
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
