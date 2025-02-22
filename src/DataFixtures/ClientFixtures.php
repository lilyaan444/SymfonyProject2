<?php

namespace App\DataFixtures;

use App\Entity\ClientEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clientsData = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'phoneNumber' => '0123456789',
                'address' => '123 Main Street, City'
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phoneNumber' => '0987654321',
                'address' => '456 Oak Avenue, Town'
            ],
            [
                'firstname' => 'Robert',
                'lastname' => 'Johnson',
                'email' => 'robert.johnson@example.com',
                'phoneNumber' => '0123987456',
                'address' => '789 Pine Road, Village'
            ],
        ];

        foreach ($clientsData as $data) {
            $client = new ClientEntity();
            $client->setFirstname($data['firstname']);
            $client->setLastname($data['lastname']);
            $client->setEmail($data['email']);
            $client->setPhoneNumber($data['phoneNumber']);
            $client->setAddress($data['address']);

            $manager->persist($client);
        }

        $manager->flush();
    }
}