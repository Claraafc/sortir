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
    public const USER_7 = 'user-7';
    public const USER_8 = 'user-8';
    public const USER_9 = 'user-9';
    public const USER_10 = 'user-10';
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

         $password = $this->encoder->encodePassword($user1, 'P@ss_adm1n');
         $user1->setPassword($password);
         $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('abel');
        $site2 = $this->getReference(SiteFixtures::SITE_RENNES);
        $user2->setSite($site2);
        $user2->setEmail("abel@mail.fr");
        $user2->setNom('Auboisdormant');
        $user2->setPrenom('Abel');
        $user2->setTelephone('0698745632');
        $user2->setUrlPhoto('jordan.jpg');
        $user2->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user2, 'P@ss_1');
        $user2->setPassword($password);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('adam');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user3->setSite($site1);
        $user3->setEmail("adam@mail.fr");
        $user3->setNom('Labrosse');
        $user3->setPrenom('Adam');
        $user3->setTelephone('0666547889');
        $user3->setUrlPhoto('david bisbal.jpg');
        $user3->setRoles(['ROLE_USER']);
       // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user3->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user3, 'P@ss_3');
        $user3->setPassword($password);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUsername('geoffroy');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user4->setSite($site1);
        $user4->setEmail("geoffroy@mail.fr");
        $user4->setNom('Danledo');
        $user4->setPrenom('Geoffroy');
        $user4->setTelephone('0698745632');
        $user4->setUrlPhoto('wade.jpg');
        $user4->setRoles(['ROLE_USER']);
      //  $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user4->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user4, 'P@ss_4');
        $user4->setPassword($password);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setUsername('maggy');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user5->setSite($site1);
        $user5->setEmail("maggy@mail.fr");
        $user5->setNom('Tarestcassée');
        $user5->setPrenom('Maggy');
        $user5->setTelephone('0666547889');
        $user5->setUrlPhoto('katialenormand.jpg');
        $user5->setRoles(['ROLE_USER']);
      //  $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
      //  $user5->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user5, 'P@ss_5');
        $user5->setPassword($password);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setUsername('cecile');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user6->setSite($site1);
        $user6->setEmail("cecile@mail.fr");
        $user6->setNom('Encieu');
        $user6->setPrenom('Cécile');
        $user6->setTelephone('0698745632');
        $user6->setUrlPhoto('learenard.jpg');
        $user6->setRoles(['ROLE_USER']);
       // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
       // $user6->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user6, 'P@ss_6');
        $user6->setPassword($password);
        $manager->persist($user6);

        $user7 = new User();
        $user7->setUsername('gerard');
        $site2 = $this->getReference(SiteFixtures::SITE_RENNES);
        $user7->setSite($site2);
        $user7->setEmail("gerard@mail.fr");
        $user7->setNom('Menvussa');
        $user7->setPrenom('Gérard');
        $user7->setTelephone('0698745632');
        $user7->setUrlPhoto('');
        $user7->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user7, 'P@ss_7');
        $user7->setPassword($password);
        $manager->persist($user7);

        $user8 = new User();
        $user8->setUsername('hassan');
        $site1 = $this->getReference(SiteFixtures::SITE_RENNES);
        $user8->setSite($site1);
        $user8->setEmail("hasan@mail.fr");
        $user8->setNom('Cehef');
        $user8->setPrenom('Hassan');
        $user8->setTelephone('0698745632');
        $user8->setUrlPhoto('cliffordsmith.jpg');
        $user8->setRoles(['ROLE_USER']);
        // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
        // $user6->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user8, 'P@ss_6');
        $user8->setPassword($password);
        $manager->persist($user8);

        $user9 = new User();
        $user9->setUsername('tom');
        $site1 = $this->getReference(SiteFixtures::SITE_QUIMPER);
        $user9->setSite($site1);
        $user9->setEmail("tom@mail.fr");
        $user9->setNom('Egerie');
        $user9->setPrenom('Tom');
        $user9->setTelephone('0698745632');
        $user9->setUrlPhoto('romainleduc.jpg');
        $user9->setRoles(['ROLE_USER']);
        // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
        // $user6->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user9, 'P@ss_6');
        $user9->setPassword($password);
        $manager->persist($user9);

        $user10 = new User();
        $user10->setUsername('pacome');
        $site1 = $this->getReference(SiteFixtures::SITE_ST_HERBLAIN);
        $user10->setSite($site1);
        $user10->setEmail("pacome@mail.fr");
        $user10->setNom('Toutlemonde');
        $user10->setPrenom('Pacome');
        $user10->setTelephone('0698745632');
        $user10->setUrlPhoto('totolarmoire.jpg');
        $user10->setRoles(['ROLE_USER']);
        // $sortie2 = $this->getReference(SortieFixtures::SORTIE_2);
        // $user6->addSorty($sortie2);

        $password = $this->encoder->encodePassword($user10, 'P@ss_6');
        $user10->setPassword($password);
        $manager->persist($user10);


        $manager->flush();
        $this->addReference(self::USER_ADMIN, $user1);
        $this->addReference(self::USER_TOTO, $user2);
        $this->addReference(self::USER_3, $user3);
        $this->addReference(self::USER_4, $user4);
        $this->addReference(self::USER_5, $user5);
        $this->addReference(self::USER_6, $user6);
        $this->addReference(self::USER_7, $user7);
        $this->addReference(self::USER_8, $user8);
        $this->addReference(self::USER_9, $user9);
        $this->addReference(self::USER_10, $user10);
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
