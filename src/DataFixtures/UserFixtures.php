<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Product;

use Doctrine\Persistence\ObjectManager;;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $superAdmin = $this->createSuperAdmin();


        $manager->persist($superAdmin);

        $manager->flush();
    }

    private function createSuperAdmin(): User
    {
        $user = new User();

        $passwordHashed = $this->hasher->hashPassword($user, "Joan@456789*");

        $user->setFirstName('Stephen');
        $user->setLastName('Smith');
        $user->setEmail('techstore@gmail.com');
        $user->setPhone('0160010203');
        $user->setAddress('11 rue de la pompe');
        $user->setTown('PARIS');
        $user->setZipCode('75016');
        $user->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER']);
        $user->setIsVerified(true);
        $user->setPassword($passwordHashed);
        $user->setVerifiedAt(new DateTimeImmutable('now'));

        return $user;
    }
}
