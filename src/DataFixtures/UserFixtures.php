<?php

namespace App\DataFixtures;

use App\Entity\UserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['email' => 'alice.dupont@example.com', 'firstname' => 'Alice', 'lastname' => 'Dupont', 'roles' => ['ROLE_USER'], 'password' => 'alicepass'],
            ['email' => 'bob.martin@example.com', 'firstname' => 'Bob', 'lastname' => 'Martin', 'roles' => ['ROLE_USER'], 'password' => 'bobpass'],
            ['email' => 'charlie.leclerc@example.com', 'firstname' => 'Charlie', 'lastname' => 'Leclerc', 'roles' => ['ROLE_ADMIN'], 'password' => 'charliepass'],
            ['email' => 'david.bernard@example.com', 'firstname' => 'David', 'lastname' => 'Bernard', 'roles' => ['ROLE_MANAGER'], 'password' => 'davidpass'],
            ['email' => 'eva.moreau@example.com', 'firstname' => 'Eva', 'lastname' => 'Moreau', 'roles' => ['ROLE_USER'], 'password' => 'evapass'],
            ['email' => 'frank.dubois@example.com', 'firstname' => 'Frank', 'lastname' => 'Dubois', 'roles' => ['ROLE_USER'], 'password' => 'frankpass'],
            ['email' => 'gabriel.petit@example.com', 'firstname' => 'Gabriel', 'lastname' => 'Petit', 'roles' => ['ROLE_USER'], 'password' => 'gabrielpass'],
        ];


        foreach ($usersData as $data) {
            $user = new UserEntity();
            $user->setEmail($data['email']);
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setRoles($data['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
