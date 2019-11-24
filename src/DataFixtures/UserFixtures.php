<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {

        // $product = new Product();
        // $manager->persist($product);

        // On configure dans quelles langues nous voulons nos données


        // on créé 10 users

        $user = new User();
        $user->setEmail('saidi@topnet.tn');
        $user->setNom('Saidi');
        $user->setPrenom('Mourad');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setIsActive('1');
        $user->setAdresse('sousse');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '123456'
        ));
        $manager->persist($user);


        $manager->flush();
    }

}