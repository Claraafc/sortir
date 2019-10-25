<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public const USER_ADMIN = 'user-admin';
    public const USER_TOTO = 'user-toto';
    public const USER_3 = 'user-3';
    public const USER_4 = 'user-4';
    public const USER_5 = 'user-5';
    public const USER_6 = 'user-6';
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
         $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
         $user1->setSite($site1);
         $user1->setEmail("admin@mail.fr");
         $user1->setNom('Admin');
         $user1->setPrenom('strateur');
         $user1->setTelephone('0666547889');
         $user1->setUrlPhoto('f643d24fb2c8c5ad12e8f46bacebbe53.jpg');
         $user1->setRoles(['ROLE_ADMIN']);

         $password = $this->encoder->encodePassword($user1, 'pass_administrateur');
         $user1->setPassword($password);
         $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('Toto');
        $site2 = $this->getReference(SiteFixtures::SITE_RENNES);
        $user2->setSite($site2);
        $user2->setEmail("toto@mail.fr");
        $user2->setNom('Toto');
        $user2->setPrenom('Guizmo');
        $user2->setTelephone('0698745632');
        $user2->setUrlPhoto('guizmo.jpg');
        $user2->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user2, 'pass_guizmo');
        $user2->setPassword($password);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('user3');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user3->setSite($site1);
        $user3->setEmail("user3@mail.fr");
        $user3->setNom('nomuser3');
        $user3->setPrenom('prenomuser3');
        $user3->setTelephone('0666547889');
        $user3->setUrlPhoto('bisounours.jpg');
        $user3->setRoles(['ROLE_USER']);
       // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user3->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user3, 'pass_3');
        $user3->setPassword($password);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUsername('user4');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user4->setSite($site1);
        $user4->setEmail("user4@mail.fr");
        $user4->setNom('nomuser4');
        $user4->setPrenom('prenomuser4');
        $user4->setTelephone('0698745632');
        $user4->setUrlPhoto('punk.jpg');
        $user4->setRoles(['ROLE_USER']);
      //  $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user4->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user4, 'pass_4');
        $user4->setPassword($password);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setUsername('user5');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user5->setSite($site1);
        $user5->setEmail("user5@mail.fr");
        $user5->setNom('nomuser5');
        $user5->setPrenom('prenomuser5');
        $user5->setTelephone('0666547889');
        $user5->setUrlPhoto('espagnol.jpg');
        $user5->setRoles(['ROLE_USER']);
      //  $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user5->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user5, 'pass_5');
        $user5->setPassword($password);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setUsername('user6');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user6->setSite($site1);
        $user6->setEmail("user6@mail.fr");
        $user6->setNom('nomuser6');
        $user6->setPrenom('prenomuser6');
        $user6->setTelephone('0698745632');
        $user6->setUrlPhoto('mexicain.jpg');
        $user6->setRoles(['ROLE_USER']);
       // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
       // $user6->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user6, 'pass_6');
        $user6->setPassword($password);
        $manager->persist($user6);

         $manager->flush();
        $this->addReference(self::USER_ADMIN, $user1);
        $this->addReference(self::USER_TOTO, $user2);
        $this->addReference(self::USER_3, $user3);
        $this->addReference(self::USER_4, $user4);
        $this->addReference(self::USER_5, $user5);
        $this->addReference(self::USER_6, $user6);
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
            SiteFixtures::class,
           // SortieFixtures::class
        ];
    }
}
